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
 * Interface HookInterface
 *
 * @package magickimages
 */
interface HookInterface
{
	/**
	 * Set the image optimizer, used by the hook.
	 *
	 * @param OptimizerInterface $optimizer
	 */
	public function setOptimizer(OptimizerInterface $optimizer = null);

	/**
	 * Get the image optimizer, that is used by this hook.
	 *
	 * @return OptimizerInterface
	 */
	public function getOptimizer();

	/**
	 * Resize an image and store the resized version in the assets/images folder
	 *
	 * @param string  $image     The image path
	 * @param integer $width     The target width
	 * @param integer $height    The target height
	 * @param string  $mode      The resize mode
	 * @param string  $cacheName The cached image path
	 * @param \File   $file      The image file object
	 * @param string  $target    An optional target path
	 */
	public function get($image, $width, $height, $mode, $cacheName, \File $file, $target);
}
