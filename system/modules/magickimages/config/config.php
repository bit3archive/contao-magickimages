<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * MagickImages
 * Copyright (C) 2011 Tristan Lins
 *
 * Extension for:
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
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
 * @copyright  InfinitySoft 2010,2011,2012
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    MagickImages
 * @license    LGPL
 * @filesource
 */


/**
 * MagickImages settings
 */
$GLOBALS['TL_CONFIG']['magickimages_force']                  = false;
$GLOBALS['TL_CONFIG']['magickimages_process']                = !class_exists('Imagick');
$GLOBALS['TL_CONFIG']['magickimages_process_call']           = 'proc';
$GLOBALS['TL_CONFIG']['magickimages_convert_path']           = 'convert';
$GLOBALS['TL_CONFIG']['magickimages_filter']                 = 'Cubic';
$GLOBALS['TL_CONFIG']['magickimages_blur']                   = false;
$GLOBALS['TL_CONFIG']['magickimages_blur_radius']            = 3;
$GLOBALS['TL_CONFIG']['magickimages_blur_sigma']             = 2;
$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask']           = false;
$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_radius']    = 1.5;
$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_sigma']     = 1.2;
$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_amount']    = 1;
$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_threshold'] = 0.1;

/**
 * HOOKS
 */
$GLOBALS['TL_HOOKS']['getImage'][]        = array('MagickImages', 'getImage');
