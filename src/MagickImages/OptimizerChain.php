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
 * Class OptimizerChain
 *
 * @package magickimages
 */
class OptimizerChain implements OptimizerInterface
{
	/**
	 * The chain.
	 *
	 * @var OptimizerInterface[]
	 */
	protected $chain = array();

	/**
	 * Add an optimizer to the chain.
	 *
	 * @param OptimizerInterface $optimizer
	 */
	public function addOptimizer(OptimizerInterface $optimizer)
	{
		$this->chain[spl_object_hash($optimizer)] = $optimizer;
	}

	/**
	 * Remove the optimizer from the chain.
	 *
	 * @param OptimizerInterface $optimizer
	 */
	public function removeOptimizer(OptimizerInterface $optimizer)
	{
		unset($this->chain[spl_object_hash($optimizer)]);
	}

	/**
	 * Optimize an image.
	 *
	 * @param string $image  The image path
	 * @param string $target The target path, if its not set, use the $image path.
	 *
	 * @return string Return the optimized image path.
	 */
	public function optimize($image, $target = null)
	{
		foreach ($this->chain as $optimizer) {
			$image = $optimizer->optimize($image, $target);
		}
		return $image;
	}
}
