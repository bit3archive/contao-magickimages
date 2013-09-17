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
 * Class MagickImages
 *
 * Provide an ImageMagick based image resize function.
 *
 * @package magickimages
 */
class Loader
{
	/**
	 * @return HookInterface
	 * @SuppressWarnings(PHPMD.Superglobals)
	 * @SuppressWarnings(PHPMD.CamelCaseVariableName)
	 */
	static public function getInstance()
	{
		return $GLOBALS['container']['magickimages.hook'];
	}
}
