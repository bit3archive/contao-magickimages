<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Layout Additional Sources
 * Copyright (C) 2011 Tristan Lins
 *
 * Extension for:
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
 * @copyright  InfinitySoft 2010,2011
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    Layout Additional Sources
 * @license    LGPL
 * @filesource
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_settings']['magickimages_force']                  = array('Use ImageMagick everytime', 'With this option GD2 is fully replaces by ImageMagick. Without this option ImageMagick is only used if its nececarry (image source size > 3000x3000 or target image size > 1200x1200).');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_process']                = array('Use external program call instead of Imagick library', 'Use this option if Imagick PHP Library not available. In this case the <strong>convert</strong> command from ImageMagick is used.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_process_call']           = array('Method for external program call', 'Choose the method how the external program should be called. Use <strong>exec</strong> or <strong>shell_exec</strong> only if <strong>proc_open</strong> is disabled.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_convert_path']           = array('convert path', 'Path to the convert executable.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_filter']                 = array('Filter', 'Choose your scaling filter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_blur']                   = array('Blur', 'Activate blur filter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_blur_radius']            = array('Blur Radius', 'Radius for blur filter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_blur_sigma']             = array('Blur Sigma', 'Sigma for blur filter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask']           = array('Unsharp', 'Activate unsharp filter');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_radius']    = array('Unsharp Radius', 'Radius for unsharp filter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_sigma']     = array('Unsharp Sigma', 'Sigma for unsharp filter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_amount']    = array('Unsharp Amount', 'Amount for unsharp filter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_threshold'] = array('Unsharp Threshold', 'Threshold for unsharp filter.');


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

?>
