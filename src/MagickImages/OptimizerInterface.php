<?php

/**
 * MagickImages
 * ImageMagick integration for Contao Open Source CMS
 *
 * PHP Version 5.3
 *
 * @copyright  bit3 UG 2013
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @package    magickimages
 * @license    LGPL-3.0+
 * @link       http://avisota.org
 */


namespace MagickImages;


/**
 * Interface OptimizerInterface
 *
 * @package magickimages
 */
interface OptimizerInterface
{
	/**
	 * Optimize an image.
	 *
	 * @param string $image  The image path
	 * @param string $target The target path, if its not set, use the $image path.
	 *
	 * @return string Return the optimized image path.
	 */
	public function optimize($image, $target = null);
}
