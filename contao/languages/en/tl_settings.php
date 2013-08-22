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


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_settings']['magickimages_force']                      = array('Use ImageMagick everytime', 'With this option GD2 is fully replaces by ImageMagick. Without this option ImageMagick is only used if its nececarry (image source size > 3000x3000 or target image size > 1200x1200).');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_process']                    = array('Use external program call instead of Imagick library', 'Use this option if Imagick PHP Library not available. In this case the <strong>convert</strong> command from ImageMagick is used.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_convert_path']               = array('convert path', 'Path to the convert executable.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_filter']                     = array('Filter', 'Choose your scaling filter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_blur']                       = array('Blur', 'Activate blur filter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_blur_radius']                = array('Blur Radius', 'Radius for blur filter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_blur_sigma']                 = array('Blur Sigma', 'Sigma for blur filter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask']               = array('Unsharp', 'Activate unsharp filter');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_radius']        = array('Unsharp Radius', 'Radius for unsharp filter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_sigma']         = array('Unsharp Sigma', 'Sigma for unsharp filter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_amount']        = array('Unsharp Amount', 'Amount for unsharp filter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_threshold']     = array('Unsharp Threshold', 'Threshold for unsharp filter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_pngrewrite']                 = array('Optimize PNG images with pngrewrite', 'Use pngrewrite to optimize PNG images.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_optipng']                    = array('Optimize PNG/BMP/GIF/PNM/TIFF images with optipng', 'Use optipng to optimize PNG/BMP/GIF/PNM/TIFF images.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_optipng_optimization_level'] = array('optipng optimization level', 'Choose the optimization level for optipng.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_advpng']                     = array('Optimize PNG images with advpng', 'Use advpng to optimize PNG images.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_advpng_level']               = array('advpng optimization level', 'Choose the optimization level for advpng.');


/**
 * References
 */
$GLOBALS['TL_LANG']['tl_settings']['buildin']    = 'Imagick PHP Library';
$GLOBALS['TL_LANG']['tl_settings']['proc']       = 'proc-Process';
$GLOBALS['TL_LANG']['tl_settings']['exec']       = 'exec-Command';
$GLOBALS['TL_LANG']['tl_settings']['shell_exec'] = 'shell_exec-Command';


/**
 * Legend
 */
$GLOBALS['TL_LANG']['tl_settings']['magickimages_legend'] = 'ImageMagick image manipulation';
