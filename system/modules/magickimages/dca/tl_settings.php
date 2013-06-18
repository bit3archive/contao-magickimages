<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * MagickImages
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
 * @package    MagickImages
 * @license    LGPL
 * @filesource
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

$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['magickimages_process']      = 'magickimages_process_call,magickimages_convert_path';
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
$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_process_call'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_process_call'],
	'inputType'               => 'select',
	'options_callback'        => array('tl_settings_magickimages', 'getProcessTypes'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_settings'],
	'eval'                    => array('tl_class'=>'w50', 'submitOnChange'=>true)
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
	'options'                 => array('Bessel', 'Blackman', 'Box', 'Catrom', 'Cubic', 'Gaussian', 'Hanning', 'Hamming', 'Hermite', 'Lanczos', 'Mitchell', 'Point', 'Quadratic', 'Sinc', 'Triangle', 'Undefined'),
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

class tl_settings_magickimages
{
	public function getProcessTypes()
	{
		$disabled = explode(', ', ini_get('disable_functions'));
		$arrType = array();
		if (!in_array('proc_open', $disabled))
		{
			$arrType[] = 'proc';
		}
		if (!in_array('exec', $disabled))
		{
			$arrType[] = 'exec';
		}
		if (!in_array('shell_exec', $disabled))
		{
			$arrType[] = 'shell_exec';
		}
		return $arrType;
	}
}
?>