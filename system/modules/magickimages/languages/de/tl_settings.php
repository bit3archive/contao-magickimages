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
 * @copyright  InfinitySoft 2010,2011,2012
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    Layout Additional Sources
 * @license    LGPL
 * @filesource
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_settings']['magickimages_force']                  = array('ImageMagick immer verwenden', 'Wählen Sie diese Option um GD vollständig durch ImageMagick zu ersetzen. Ist diese Option nicht aktiviert wird ImageMagick nur dann verwendet, wenn GD das Bild nicht verarbeiten kann (Bildquelle > 3000x3000 oder Zieldatei > 1200x1200).');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_process']                = array('Externen Prozessaufruf anstatt Imagick verwenden', 'Wählen Sie diese Option wenn die Imagick PHP Library nicht zur Verfügung steht. Dann wird der <strong>convert</strong> Befehl von ImageMagick verwendet.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_process_call']           = array('Methode für externen Prozessaufruf', 'Wählen Sie hier aus, wie der externe Prozessaufruf durchgeführt werden soll. Wählen Sie <strong>exec</strong> bzw. <strong>shell_exec</strong> nur aus, wenn <strong>proc_open</strong> nicht erlaubt ist.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_convert_path']           = array('convert Pfad', 'Pfad zur Ausführbaren convert Datei.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_filter']                 = array('Filter', 'Wählen Sie hier den Skalierungsfilter aus.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_blur']                   = array('Blur', 'Blur-Filter aktivieren.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_blur_radius']            = array('Blur Radius', 'Radius für Blur-Filter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_blur_sigma']             = array('Blur Sigma', 'Sigma für Blur-Filter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask']           = array('Unsharp', 'Unschärfefilter aktivieren.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_radius']    = array('Unsharp Radius', 'Radius für Unschärfefilter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_sigma']     = array('Unsharp Sigma', 'Sigma für Unschärfefilter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_amount']    = array('Unsharp Amount', 'Amount für Unschärfefilter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_threshold'] = array('Unsharp Threshold', 'Threshold für Unschärfefilter.');


/**
 * References
 */
$GLOBALS['TL_LANG']['tl_settings']['buildin']    = 'Imagick PHP Library';
$GLOBALS['TL_LANG']['tl_settings']['proc']       = 'proc-Process';
$GLOBALS['TL_LANG']['tl_settings']['exec']       = 'exec-Befehl';
$GLOBALS['TL_LANG']['tl_settings']['shell_exec'] = 'shell_exec-Befehl';


/**
 * Legend
 */
$GLOBALS['TL_LANG']['tl_settings']['magickimages_legend'] = 'ImageMagick Bildverarbeitung';

?>
