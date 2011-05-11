<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * MagickImages
 * Copyright (C) 2011 Tristan Lins
 *
 * Extension for:
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 * 
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  InfinitySoft 2010,2011
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    MagickImages
 * @license    LGPL
 * @filesource
 */


/**
 * Class MagickImages
 *
 * Provide an ImageMagick based image resize function.
 * @copyright  InfinitySoft 2010,2011
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    MagickImages
 */
if ($GLOBALS['TL_CONFIG']['magickimages_process'])
{
	/**
	 * MagickImages Implementation using convert command with exec.
	 */
	class MagickImagesImpl extends System {
		/**
		 * Resize an image
		 * 
		 * @param string $strImage
		 * @param mixed $varWidth
		 * @param mixed $varHeight
		 * @param string $strMode
		 * @param string $strCacheName
		 * @param File $objFile
		 */
		protected function resize($strImage, $varWidth, $varHeight, $strMode, $strCacheName, $objFile)
		{
			if (!$varWidth && !$varHeight) return false;
	
			// detect image format
			$strFormat = $objFile->extension;
			
			if (!(	$strFormat == 'jpg'
				||  $strFormat == 'png'
				||  $strFormat == 'gif'))
			{
				$strFormat = 'jpg';
			}
			
			// the target size
			$intWidth = intval($varWidth);
			$intHeight = intval($varHeight);
			
			// set the source path
			$strSource = TL_ROOT . '/' . $strImage;
			
			// set the output path
			$strTarget = TL_ROOT . '/' . $strCacheName;
			
			// begin build the exec command
			$arrCmd = array($strSource);
			
			// set the jpeg quality
			if ($strFormat=='jpg')
			{
				$arrCmd[] = '-quality';
				$arrCmd[] = $GLOBALS['TL_CONFIG']['jpgQuality'];
			}
			
			// add filter
			$arrCmd[] = '-filter';
			$arrCmd[] = $GLOBALS['TL_CONFIG']['magickimages_filter'];
			
			// blur image
			if ($GLOBALS['TL_CONFIG']['magickimages_blur'])
			{
				$arrCmd[] = '-blur';
				$arrCmd[] = $GLOBALS['TL_CONFIG']['magickimages_blur_radius'] . 'x' . $GLOBALS['TL_CONFIG']['magickimages_blur_sigma'];
			}
			
			// unsharp image
			if ($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask'])
			{
				$arrCmd[] = '-unsharp';
				$arrCmd[] = sprintf('%sx%s+%s+%s',
					$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_radius'],
					$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_sigma'],
					$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_amount'],
					$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_threshold']);
			}
			
			// Mode-specific changes
			if ($intWidth && $intHeight)
			{
				switch ($strMode)
				{
					case 'proportional':
						if ($objFile->width >= $objFile->height)
						{
							unset($varHeight, $intHeight);
						}
						else
						{
							unset($varWidth, $intWidth);
						}
						break;
	
					case 'box':
						if (ceil($objFile->height * $varWidth / $objFile->width) <= $intHeight)
						{
							unset($varHeight, $intHeight);
						}
						else
						{
							unset($varWidth, $intWidth);
						}
						break;
				}
			}
			
			// Resize width and height and crop the image if necessary
			if ($intWidth && $intHeight)
			{
				$dblSrcAspectRatio = $objFile->width / $objFile->height;
				$dblTargetAspectRatio = $intWidth / $intHeight;
				
				$arrCmd[] = '-resize';
				
				if ($dblSrcAspectRatio == $dblTargetAspectRatio)
				{
					$arrCmd[] = $intWidth . 'x' . $intHeight;
				}
				else if ($dblSrcAspectRatio < $dblTargetAspectRatio)
				{
					$arrCmd[] = $intWidth . 'x' . $intHeight . '^';
					
					// crop image
					$arrCmd[] = '-gravity';
					$arrCmd[] = 'Center';
					$arrCmd[] = '-extent';
					$arrCmd[] = $intWidth . 'x' . $intHeight;
				}
				else if ($dblSrcAspectRatio > $dblTargetAspectRatio)
				{
					$arrCmd[] = '0x' . $intHeight . '^';
					
					// crop image
					$arrCmd[] = '-gravity';
					$arrCmd[] = 'Center';
					$arrCmd[] = '-extent';
					$arrCmd[] = $intWidth . 'x' . $intHeight;
				}
			}
	
			// resize by width
			else if ($intWidth)
			{
				$arrCmd[] = '-resize';
				$arrCmd[] = $intWidth . 'x0^';
			}
	
			// resize by height
			else if ($intHeight)
			{
				$arrCmd[] = '-resize';
				$arrCmd[] = '0x' . $intHeight . '^';
			}
			
			// add target file path
			$arrCmd[] = $strTarget;
			
			// build command
			$strCmd = escapeshellcmd($GLOBALS['TL_CONFIG']['magickimages_convert_path']);
			foreach ($arrCmd as $strArg)
			{
				$strCmd .= ' ' . escapeshellarg($strArg);
			}
			
			switch ($GLOBALS['TL_CONFIG']['magickimages_type'])
			{
			case 'proc':
				// execute convert
				$procConvert = proc_open(
					$strCmd,
					array(
						0 => array("pipe", "r"),
						1 => array("pipe", "w"),
						2 => array("pipe", "w")
					),
					$arrPipes);
				if ($procConvert === false)
				{
					$this->log(sprintf("convert could not be started!
cmd: %s", $strCmd), 'MagickImages::getImage', TL_ERROR);
					return false;
				}
				// close stdin
				fclose($arrPipes[0]);
				// close stdout
				fclose($arrPipes[1]);
				// read and close stderr
				$strErr = stream_get_contents($arrPipes[2]);
				fclose($arrPipes[2]);
				// wait until yui-compressor terminates
				$intCode = proc_close($procConvert);
				if ($intCode != 0)
				{
					$this->log(sprintf("Execution of convert failed!
cmd: %s
stderr: %s", $strCmd, $strErr), 'MagickImages::getImage', TL_ERROR);
					return false;
				}
				break;
				
			case 'exec':
				exec($strCmd, $arrOutput, $varReturn);
				if ($varReturn != 0)
				{
					$this->log(sprintf("Execution of convert failed!
cmd: %s
output: %s", $strCmd, implode("\n", $arrOutput)), 'MagickImages::getImage', TL_ERROR);
					return false;
				}
				break;
				
			case 'shell_exec':
				$strOutput = shell_exec($strCmd);
				if ($strOutput)
				{
					$this->log(sprintf("Execution of convert failed!
cmd: %s
output: %s", $strCmd, $strOutput), 'MagickImages::getImage', TL_ERROR);
					return false;
				}
				break;
			}
			
			// Set the file permissions when the Safe Mode Hack is used
			if ($GLOBALS['TL_CONFIG']['useFTP'])
			{
				$this->import('Files');
				$this->Files->chmod($strCacheName, 0644);
			}
			
			// Return the path to new image
			return $strCacheName;
		}
	}
}
else
{
	/**
	 * MagickImages Implementation using Imagick library.
	 */
	class MagickImagesImpl extends System {
		/**
		 * Resize an image
		 * 
		 * @param string $strImage
		 * @param mixed $varWidth
		 * @param mixed $varHeight
		 * @param string $strMode
		 * @param string $strCacheName
		 * @param File $objFile
		 */
		protected function resize($strImage, $varWidth, $varHeight, $strMode, $strCacheName, $objFile)
		{
			if (!$varWidth && !$varHeight) return false;
	
			try {
				// detect image format
				$strFormat = $objFile->extension;
				
				if (!(	$strFormat == 'jpg'
					||  $strFormat == 'png'
					||  $strFormat == 'gif'))
				{
					$strFormat = 'jpg';
				}
				
				// the target size
				$intWidth = intval($varWidth);
				$intHeight = intval($varHeight);
				
				// load imagick
				$objImagick = new Imagick();
				
				// read the source file
				$objImagick->readImage(TL_ROOT . '/' . $strImage);
				
				// set the output format
				$objImagick->setImageFormat($strFormat);
				
				// set the jpeg quality
				if ($strFormat=='jpg')
				{
					$objImagick->setCompressionQuality($GLOBALS['TL_CONFIG']['jpgQuality']);
				}
				
				// set filter
				$strFilter = 'FILTER_' . strtoupper(preg_replace('#[^\w]#', '', $GLOBALS['TL_CONFIG']['magickimages_filter']));
				$intFilter = eval('return Imagick::'.$strFilter.';');
				
				// Mode-specific changes
				if ($intWidth && $intHeight)
				{
					switch ($strMode)
					{
						case 'proportional':
							if ($objFile->width >= $objFile->height)
							{
								unset($varHeight, $intHeight);
							}
							else
							{
								unset($varWidth, $intWidth);
							}
							break;
		
						case 'box':
							if (ceil($objFile->height * $varWidth / $objFile->width) <= $intHeight)
							{
								unset($varHeight, $intHeight);
							}
							else
							{
								unset($varWidth, $intWidth);
							}
							break;
					}
				}
				
				// Resize width and height and crop the image if necessary
				if ($intWidth && $intHeight)
				{
					$dblSrcAspectRatio = $objFile->width / $objFile->height;
					$dblTargetAspectRatio = $intWidth / $intHeight;
					
					if ($dblSrcAspectRatio == $dblTargetAspectRatio)
					{
						$objImagick->resizeImage(
							$intWidth,
							$intHeight,
							$intFilter,
							1);
					}
					else if ($dblSrcAspectRatio < $dblTargetAspectRatio)
					{
						$objImagick->resizeImage(
							$intWidth,
							0,
							$intFilter,
							1);
						$objImagick->cropimage(
							$intWidth,
							$intHeight,
							0,
							ceil(($objImagick->getImageHeight() - $intHeight) / 2));
					}
					else if ($dblSrcAspectRatio > $dblTargetAspectRatio)
					{
						$objImagick->resizeImage(
							0,
							$intHeight,
							$intFilter,
							1);
						$objImagick->cropimage(
							$intWidth,
							$intHeight,
							ceil(($objImagick->getImageWidth() - $intWidth) / 2),
							0);
					}
				}
		
				// resize by width
				else if ($intWidth)
				{
					$objImagick->resizeImage(
						$intWidth,
						ceil($intWidth * $objFile->height / $objFile->width),
						$intFilter,
						1);
				}
		
				// resize by height
				else if ($intHeight)
				{
					$objImagick->resizeImage(
						ceil($intHeight * $objFile->width / $objFile->height),
						$intHeight,
						$intFilter,
						1);
				}
				
				// blur image
				if ($GLOBALS['TL_CONFIG']['magickimages_blur'])
				{
					$objImagick->blurimage($GLOBALS['TL_CONFIG']['magickimages_blur_radius'], $GLOBALS['TL_CONFIG']['magickimages_blur_sigma']);
				}
				
				// unsharp image
				if ($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask'])
				{
					$objImagick->unsharpMaskImage(
						$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_radius'],
						$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_sigma'],
						$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_amount'],
						$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_threshold']);
				}
				
				if ($objImagick->writeImage(TL_ROOT . '/' . $strCacheName)) {
					// Set the file permissions when the Safe Mode Hack is used
					if ($GLOBALS['TL_CONFIG']['useFTP'])
					{
						$this->import('Files');
						$this->Files->chmod($strCacheName, 0644);
					}
					
					// Return the path to new image
					return $strCacheName;
				}
			} catch (ImagickException $e) {
				$this->log('Could not resize image "' . $strImage . '": '. $e->getMessage(), 'MagickImages::resize', TL_ERROR);
			}
			return false;
		}
	}
}

class MagickImages extends MagickImagesImpl {
	public function getImage($strImage, $varWidth, $varHeight, $strMode, $strCacheName, $objFile)
	{
		// break resize if ...
		if (
				// ImageMagick should not allways be used
				!$GLOBALS['TL_CONFIG']['magickimages_force']
				// and it is not necessary
			&& !(	$objFile->width  > 3000
				||  $objFile->height > 3000
				||  $varWidth  > 1200
				||  $varHeight > 1200))
		{
			return false;
		}
		
		// Hack to determinate the $target parameter of Controller::getImage
		$arrBacktrace = debug_backtrace();
		$arrCall = $arrBacktrace[1];
		if ($arrCall['class'] == 'Controller' && $arrCall['function'] == 'getImage' && isset($arrCall['args'][4]) && strlen($arrCall['args'][4]))
		{
			$strCacheName = $arrCall['args'][4];
		}
			
		return $this->resize($strImage, $varWidth, $varHeight, $strMode, $strCacheName, $objFile);
	}
}
?>