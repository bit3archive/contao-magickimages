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
 * System configuration
 */
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'magickimages_process';
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'magickimages_blur';
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'magickimages_unsharp_mask';
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'magickimages_optipng';
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'magickimages_advpng';

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{magickimages_legend:hide},magickimages_force,magickimages_process,magickimages_filter,magickimages_blur,magickimages_unsharp_mask,magickimages_pngrewrite,magickimages_optipng,magickimages_advpng';

$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['magickimages_process']      = 'magickimages_convert_path';
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['magickimages_blur']         = 'magickimages_blur_radius,magickimages_blur_sigma';
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['magickimages_unsharp_mask'] = 'magickimages_unsharp_mask_radius,magickimages_unsharp_mask_sigma,magickimages_unsharp_mask_amount,magickimages_unsharp_mask_threshold';
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['magickimages_optipng']      = 'magickimages_optipng_optimization_level';
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['magickimages_advpng']       = 'magickimages_advpng_level';

$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_force'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_force'],
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class' => 'm12')
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_process'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_process'],
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true, 'tl_class' => 'm12 clr')
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_convert_path'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_convert_path'],
	'inputType'               => 'text',
	'eval'                    => array('tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_filter'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_filter'],
	'inputType'               => 'select',
	'options'                 => array('Box', 'Catrom', 'Cubic', 'Gaussian', 'Hermite', 'Mitchell', 'Point', 'Quadratic', 'Triangle'),
	'eval'                    => array('tl_class'=>'clr')
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_blur'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_blur'],
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'m12 clr', 'submitOnChange'=>true)
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_blur_radius'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_blur_radius'],
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'digit', 'mandatory'=>true, 'tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_blur_sigma'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_blur_sigma'],
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_unsharp_mask'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask'],
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'m12 clr', 'submitOnChange'=>true)
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_unsharp_mask_radius'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_radius'],
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_unsharp_mask_sigma'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_sigma'],
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_unsharp_mask_amount'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_amount'],
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_unsharp_mask_threshold'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_threshold'],
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_pngrewrite'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_pngrewrite'],
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class' => 'm12 w50 clr')
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_optipng'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_optipng'],
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true, 'tl_class' => 'm12 w50 clr')
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_optipng_optimization_level'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_optipng_optimization_level'],
	'inputType'               => 'select',
	'options'                 => array(0, 1, 2, 3, 4, 5, 6, 7),
	'reference'               => array(0 => '0 (fast)', 1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5 (slow)', 6 => '6', 7 => '7 (very slow)'),
	'eval'                    => array('tl_class' => 'w50', 'isAssociative' => true)
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_advpng'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_advpng'],
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true, 'tl_class' => 'm12 w50 clr')
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_advpng_level'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_advpng_level'],
	'inputType'               => 'select',
	'options'                 => array('store' => 'don\'t compress', 'fast' => 'compress fast', 'normal' => 'compress normal', 'extra' => 'compress extra', 'insane' => 'compress extreme'),
	'eval'                    => array('tl_class' => 'w50', 'isAssociative' => true)
);
