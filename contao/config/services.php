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

$container['magickimages.optimizer.advpng'] = function ($container) {
	$optimizer = new \MagickImages\AdvPngOptimizer();
	$optimizer->setPath($GLOBALS['TL_CONFIG']['magickimages_advpng_path']);
	$optimizer->setLevel($GLOBALS['TL_CONFIG']['magickimages_advpng_level']);
	return $optimizer;
};

$container['magickimages.optimizer.optipng'] = function ($container) {
	$optimizer = new \MagickImages\OptiPngOptimizer();
	$optimizer->setPath($GLOBALS['TL_CONFIG']['magickimages_optipng_path']);
	$optimizer->setLevel($GLOBALS['TL_CONFIG']['magickimages_optipng_optimization_level']);
	return $optimizer;
};

$container['magickimages.optimizer.pngrewrite'] = function ($container) {
	$optimizer = new \MagickImages\PngRewriteOptimizer();
	$optimizer->setPath($GLOBALS['TL_CONFIG']['magickimages_pngrewrite_path']);
	return $optimizer;
};

$container['magickimages.optimizer'] = function ($container) {
	$optimizerKeys = deserialize($GLOBALS['TL_CONFIG']['magickimages_optimizers'], true);
	$chain         = new \MagickImages\OptimizerChain();
	foreach ($optimizerKeys as $optimizerKey) {
		$chain->addOptimizer($container['magickimages.optimizer.' . $optimizerKey]);
	}
	return $chain;
};

$container['magickimages.impl.process'] = function ($container) {
	$hook = new \MagickImages\ProcessHookImplementation();
	$hook->setPath($GLOBALS['TL_CONFIG']['magickimages_convert_path']);
	$hook->setJpegQuality($GLOBALS['TL_CONFIG']['jpgQuality']);
	$hook->setSmhEnabled($GLOBALS['TL_CONFIG']['useFTP']);
	$hook->setFilter($GLOBALS['TL_CONFIG']['magickimages_filter']);
	$hook->setBlurEnabled($GLOBALS['TL_CONFIG']['magickimages_blur']);
	$hook->setBlurRadius($GLOBALS['TL_CONFIG']['magickimages_blur_radius']);
	$hook->setBlurSigma($GLOBALS['TL_CONFIG']['magickimages_blur_sigma']);
	$hook->setUnsharpMaskEnabled($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask']);
	$hook->setUnsharpMaskRadius($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_radius']);
	$hook->setUnsharpMaskSigma($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_sigma']);
	$hook->setUnsharpMaskAmount($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_amount']);
	$hook->setUnsharpMaskThreshold($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_threshold']);
	return $hook;
};

$container['magickimages.impl.imagick'] = function ($container) {
	$hook = new \MagickImages\ImagickHookImplementation();
	$hook->setJpegQuality($GLOBALS['TL_CONFIG']['jpgQuality']);
	$hook->setSmhEnabled($GLOBALS['TL_CONFIG']['useFTP']);
	$hook->setFilter($GLOBALS['TL_CONFIG']['magickimages_filter']);
	$hook->setBlurEnabled($GLOBALS['TL_CONFIG']['magickimages_blur']);
	$hook->setBlurRadius($GLOBALS['TL_CONFIG']['magickimages_blur_radius']);
	$hook->setBlurSigma($GLOBALS['TL_CONFIG']['magickimages_blur_sigma']);
	$hook->setUnsharpMaskEnabled($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask']);
	$hook->setUnsharpMaskRadius($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_radius']);
	$hook->setUnsharpMaskSigma($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_sigma']);
	$hook->setUnsharpMaskAmount($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_amount']);
	$hook->setUnsharpMaskThreshold($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_threshold']);
	return $hook;
};

$container['magickimages.hook'] = $container->share(
	function ($container) {
		return $container['magickimages.impl.' . $GLOBALS['TL_CONFIG']['magickimages_implementation']];
	}
);
