<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
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
 * @copyright  InfinitySoft 2010
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    MagickImages
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


/**
 * Class MagickImages
 *
 * Provide an ImageMagick based image resize function.
 * @copyright  InfinitySoft 2010
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    MagickImages
 */
class MagickImages {
	public function getImage($image, $width, $height, $mode, $strCacheName, $objFile)
	{
		// break resize if ...
		if (
				// ImageMagick should never be used
				$GLOBALS['TL_CONFIG']['magickimages_use'] == 'never'
				// or it is not necessary
			||  $GLOBALS['TL_CONFIG']['magickimages_use'] == 'necessary'
			&& !(	$objFile->width  > 3000
				||  $objFile->height > 3000
				||  $width  > 1200
				||  $height > 1200))
		{
			return false;
		}
		
		return $this->resize($image, $width, $height, $mode, $strCacheName, $objFile);
	}
	
	/**
	 * Resize an image
	 * Enter description here ...
	 * @param unknown_type $image
	 * @param unknown_type $width
	 * @param unknown_type $height
	 * @param unknown_type $mode
	 * @param unknown_type $strCacheName
	 * @param unknown_type $objFile
	 */
	public function resize($image, $width, $height, $mode, $strCacheName, $objFile)
	{
		if (!$width && !$height) return false;

		// detect image format
		$strFormat = $objFile->extension;
		
		if (!(	$strFormat == 'jpg'
			||  $strFormat == 'png'
			||  $strFormat == 'gif'))
		{
			$strFormat = 'jpg';
		}
		
		// the target size
		$intWidth = intval($width);
		$intHeight = intval($height);
		
		// load imagick
		$objImagick = new Imagick();
		
		// read the source file
		$objImagick->readImage(TL_ROOT . '/' . $image);
		
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
			switch ($mode)
			{
				case 'proportional':
					if ($objFile->width >= $objFile->height)
					{
						unset($height, $intHeight);
					}
					else
					{
						unset($width, $intWidth);
					}
					break;

				case 'box':
					if (ceil($objFile->height * $width / $objFile->width) <= $intHeight)
					{
						unset($height, $intHeight);
					}
					else
					{
						unset($width, $intWidth);
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
		
		// do watermark
		if ($GLOBALS['TL_CONFIG']['magickimages_watermark']['enabled'])
		{
			$this->watermark($objImagick);
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
	
	public function unsharp(Imagick $objImagick, $fltRadius = false, $fltSigma = false, $fltAmount = false, $fltThreshold = false)
	{
		$objImagick->unsharpMaskImage(
			$fltRadius    !== false ? $fltRadius    : $GLOBALS['TL_CONFIG']['magickimages_resize_unsharp_mask']['radius'],
			$fltSigma     !== false ? $fltSigma     : $GLOBALS['TL_CONFIG']['magickimages_resize_unsharp_mask']['sigma'],
			$fltAmount    !== false ? $fltAmount    : $GLOBALS['TL_CONFIG']['magickimages_resize_unsharp_mask']['amount'],
			$fltThreshold !== false ? $fltThreshold : $GLOBALS['TL_CONFIG']['magickimages_resize_unsharp_mask']['threshold']);
	}
	
	public function watermark(Imagick $objImagick, $strText = false)
	{
		if ($strText === false)
		{
			$strText = $GLOBALS['TL_CONFIG']['magickimages_watermark']['text'];
		}
		
		$objDraw = new ImagickDraw();
		$objDraw->setFont($GLOBALS['TL_CONFIG']['magickimages_watermark']['font']);
		$objDraw->setFontSize($GLOBALS['TL_CONFIG']['magickimages_watermark']['font_size']);
		$objDraw->setFillOpacity($GLOBALS['TL_CONFIG']['magickimages_watermark']['opacity']);
		$objDraw->setGravity($GLOBALS['TL_CONFIG']['magickimages_watermark']['gravity']);
		$objImagick->annotateImage($objDraw, 0, 0, $GLOBALS['TL_CONFIG']['magickimages_watermark']['angle'], $strText);
	}
}

?>