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
$GLOBALS['TL_LANG']['tl_settings']['magickimages_force']                      = array('ImageMagick immer verwenden', 'Wählen Sie diese Option um GD vollständig durch ImageMagick zu ersetzen. Ist diese Option nicht aktiviert wird ImageMagick nur dann verwendet, wenn GD das Bild nicht verarbeiten kann (Bildquelle > 3000x3000 oder Zieldatei > 1200x1200).');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_process']                    = array('Externen Prozessaufruf anstatt Imagick verwenden', 'Wählen Sie diese Option wenn die Imagick PHP Library nicht zur Verfügung steht. Dann wird der <strong>convert</strong> Befehl von ImageMagick verwendet.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_convert_path']               = array('convert Pfad', 'Pfad zur Ausführbaren convert Datei.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_filter']                     = array('Filter', 'Wählen Sie hier den Skalierungsfilter aus.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_blur']                       = array('Blur', 'Blur-Filter aktivieren.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_blur_radius']                = array('Blur Radius', 'Radius für Blur-Filter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_blur_sigma']                 = array('Blur Sigma', 'Sigma für Blur-Filter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask']               = array('Unsharp', 'Unschärfefilter aktivieren.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_radius']        = array('Unsharp Radius', 'Radius für Unschärfefilter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_sigma']         = array('Unsharp Sigma', 'Sigma für Unschärfefilter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_amount']        = array('Unsharp Amount', 'Amount für Unschärfefilter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_threshold']     = array('Unsharp Threshold', 'Threshold für Unschärfefilter.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_pngrewrite']                 = array('PNG Bilder mit pngrewrite optimieren', 'Benutzt pngrewrite um PNG Bilder zu optimieren.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_optipng']                    = array('PNG/BMP/GIF Bilder mit optipng optimieren', 'Benutzt optipng um PNG/BMP/GIF/PNM/TIFF Bilder zu optimieren.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_optipng_optimization_level'] = array('optipng Optimierungslevel', 'Wählen Sie hier den gewünschten Optimierungslevel für optipng aus.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_advpng']                     = array('PNG Bilder mit advpng optimieren', 'Benutzt advpng um PNG Bilder zu optimieren.');
$GLOBALS['TL_LANG']['tl_settings']['magickimages_advpng_level']               = array('advpng Optimierungslevel', 'Wählen Sie hier den gewünschten Optimierungslevel für advpng aus.');


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
