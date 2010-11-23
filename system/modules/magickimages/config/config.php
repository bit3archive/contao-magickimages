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
 * Use of alternative MagicImage resize method.
 * never - im disabled
 * necessary - for images > 3000x3000 or target size > 1200x1200
 * always - always use imagemagick
 */
$GLOBALS['TL_CONFIG']['magickimages_use'] = 'necessary';

$GLOBALS['TL_CONFIG']['magickimages_quality']['jpg'] = -1;
$GLOBALS['TL_CONFIG']['magickimages_quality']['png'] = -1;
$GLOBALS['TL_CONFIG']['magickimages_quality']['gif'] = -1;

$GLOBALS['TL_CONFIG']['magickimages_resize_filter'] = Imagick::FILTER_CUBIC;
$GLOBALS['TL_CONFIG']['magickimages_resize_blur'] = 1;

$GLOBALS['TL_CONFIG']['magickimages_resize_unsharp_mask']['enabled'] = false;
$GLOBALS['TL_CONFIG']['magickimages_resize_unsharp_mask']['radius'] = 0;
$GLOBALS['TL_CONFIG']['magickimages_resize_unsharp_mask']['sigma'] = 0.5;
$GLOBALS['TL_CONFIG']['magickimages_resize_unsharp_mask']['amount'] = 1;
$GLOBALS['TL_CONFIG']['magickimages_resize_unsharp_mask']['threshold'] = 0.05;

$GLOBALS['TL_CONFIG']['magickimages_watermark']['enabled'] = false;
$GLOBALS['TL_CONFIG']['magickimages_watermark']['text'] = 'MagickImages';
$GLOBALS['TL_CONFIG']['magickimages_watermark']['font'] = '/usr/share/fonts/truetype/freefont/FreeSansBold.ttf';
$GLOBALS['TL_CONFIG']['magickimages_watermark']['font_size'] = 25;
$GLOBALS['TL_CONFIG']['magickimages_watermark']['opacity'] = 0.4;
$GLOBALS['TL_CONFIG']['magickimages_watermark']['gravity'] = Imagick::GRAVITY_CENTER;
$GLOBALS['TL_CONFIG']['magickimages_watermark']['angle'] = 25;

/**
 * HOOKS
 */
$GLOBALS['TL_HOOKS']['getImage'][] = array('MagickImages', 'getImage');

?>