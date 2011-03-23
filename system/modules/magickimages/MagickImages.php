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
if ($GLOBALS['TL_CONFIG']['magickimages_type'] == 'buildin')
{
	/**
	 * MagickImages Implementation using Imagick library.
	 */
	class MagickImagesImpl {
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
			
			// load imagick
			$objImagick = new Imagick();
			
			// read the source file
			$objImagick->readImage(TL_ROOT . '/' . $strImage);
			
			// set the output format
			$objImagick->setImageFormat($strFormat);
			
			// set the quality, if its defined, otherwise use defaults
			if (	isset($GLOBALS['TL_CONFIG']['magickimages_quality'][$strFormat])
				&&  $GLOBALS['TL_CONFIG']['magickimages_quality'][$strFormat] != -1)
			{
				$objImagick->setCompressionQuality($GLOBALS['TL_CONFIG']['magickimages_quality'][$strFormat]);
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
				
				if ($dblSrcAspectRatio == $dblTargetAspectRatio)
				{
					$objImagick->resizeImage(
						$intWidth,
						$intHeight,
						$GLOBALS['TL_CONFIG']['magickimages_resize_filter'],
						$GLOBALS['TL_CONFIG']['magickimages_resize_blur']);
				}
				else if ($dblSrcAspectRatio < $dblTargetAspectRatio)
				{
					$objImagick->resizeImage(
						$intWidth,
						0,
						$GLOBALS['TL_CONFIG']['magickimages_resize_filter'],
						$GLOBALS['TL_CONFIG']['magickimages_resize_blur']);
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
						$GLOBALS['TL_CONFIG']['magickimages_resize_filter'],
						$GLOBALS['TL_CONFIG']['magickimages_resize_blur']);
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
					0,
					$GLOBALS['TL_CONFIG']['magickimages_resize_filter'],
					$GLOBALS['TL_CONFIG']['magickimages_resize_blur']);
			}
	
			// resize by height
			else if ($intHeight)
			{
				$objImagick->resizeImage(
					0,
					$intHeight,
					$GLOBALS['TL_CONFIG']['magickimages_resize_filter'],
					$GLOBALS['TL_CONFIG']['magickimages_resize_blur']);
			}
			
			// do image unsharp
			if ($GLOBALS['TL_CONFIG']['magickimages_resize_unsharp_mask']['enabled'])
			{
				$this->unsharp($objImagick);
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
			} else {
				return false;
			}
		}
		
		/**
		 * Unsharp the image to improve quality.
		 * 
		 * @param Imagick $objImagick
		 * @param float $fltRadius
		 * @param float $fltSigma
		 * @param float $fltAmount
		 * @param float $fltThreshold
		 */
		protected function unsharp(Imagick $objImagick, $fltRadius = false, $fltSigma = false, $fltAmount = false, $fltThreshold = false)
		{
			$objImagick->unsharpMaskImage(
				$fltRadius    !== false ? $fltRadius    : $GLOBALS['TL_CONFIG']['magickimages_resize_unsharp_mask']['radius'],
				$fltSigma     !== false ? $fltSigma     : $GLOBALS['TL_CONFIG']['magickimages_resize_unsharp_mask']['sigma'],
				$fltAmount    !== false ? $fltAmount    : $GLOBALS['TL_CONFIG']['magickimages_resize_unsharp_mask']['amount'],
				$fltThreshold !== false ? $fltThreshold : $GLOBALS['TL_CONFIG']['magickimages_resize_unsharp_mask']['threshold']);
		}
	}
}
else
{
/**
	 * MagickImages Implementation using convert command with exec.
	 */
	class MagickImagesImpl {
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
			
			// set the quality, if its defined, otherwise use defaults
			if (	isset($GLOBALS['TL_CONFIG']['magickimages_quality'][$strFormat])
				&&  $GLOBALS['TL_CONFIG']['magickimages_quality'][$strFormat] != -1)
			{
				$arrCmd[] = '-quality';
				$arrCmd[] = $GLOBALS['TL_CONFIG']['magickimages_quality'][$strFormat];
			}
			
			// add blur
			$arrCmd[] = '-blur';
			$arrCmd[] = $GLOBALS['TL_CONFIG']['magickimages_resize_blur'];
			
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
					$arrCmd[] = '-crop';
					$arrCmd[] = $intWidth . 'x' . $intHeight;
				}
				else if ($dblSrcAspectRatio > $dblTargetAspectRatio)
				{
					$arrCmd[] = '0x' . $intHeight . '^';
					
					// crop image
					$arrCmd[] = '-gravity';
					$arrCmd[] = 'Center';
					$arrCmd[] = '-crop';
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
			
			// do image unsharp
			if ($GLOBALS['TL_CONFIG']['magickimages_resize_unsharp_mask']['enabled'])
			{
				$arrCmd[] = '-unsharp';
				$arrCmd[] = sprintf('%sx%s+%s+%s',
					$fltRadius    !== false ? $fltRadius    : $GLOBALS['TL_CONFIG']['magickimages_resize_unsharp_mask']['radius'],
					$fltSigma     !== false ? $fltSigma     : $GLOBALS['TL_CONFIG']['magickimages_resize_unsharp_mask']['sigma'],
					$fltAmount    !== false ? $fltAmount    : $GLOBALS['TL_CONFIG']['magickimages_resize_unsharp_mask']['amount'],
					$fltThreshold !== false ? $fltThreshold : $GLOBALS['TL_CONFIG']['magickimages_resize_unsharp_mask']['threshold']);
			}
			
			// add target file path
			$arrCmd[] = $strTarget;
			
			// build command
			$strCmd = escapeshellcmd('convert');
			foreach ($arrCmd as $strArg)
			{
				$strCmd .= ' ' . escapeshellarg($strArg);
			}
			
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
				$this->log(sprintf("convert could not be started!<br/>\ncmd: %s", $strCmd), 'MagickImages::getImage', TL_ERROR);
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
				$this->log(sprintf("Execution of convert failed!<br/>\ncmd: %s<br/>\nstderr: %s", $strCmd, $strErr), 'LessCss::minimize', TL_ERROR);
				return false;
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

class MagickImages extends MagickImagesImpl {
	public function getImage($strImage, $varWidth, $varHeight, $strMode, $strCacheName, $objFile)
	{
		// break resize if ...
		if (
				// ImageMagick should not allways be used
				$GLOBALS['TL_CONFIG']['magickimages_use'] == 'never'
				// or it is not necessary
			||  $GLOBALS['TL_CONFIG']['magickimages_use'] == 'necessary'
			&& !(	$objFile->width  > 3000
				||  $objFile->height > 3000
				||  $varWidth  > 1200
				||  $varHeight > 1200))
		{
			return false;
		}
		
		return $this->resize($strImage, $varWidth, $varHeight, $strMode, $strCacheName, $objFile);
	}
}
?>