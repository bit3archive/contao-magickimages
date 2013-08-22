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

use Symfony\Component\Process\ProcessBuilder;

/**
 * Class PngRewriteOptimizer
 *
 * @package magickimages
 */
class PngRewriteOptimizer implements OptimizerInterface
{
	/**
	 * @var string
	 */
	protected $path = 'pngrewrite';

	/**
	 * @param mixed $path
	 */
	public function setPath($path)
	{
		$this->path = $path;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * {@inheritdoc}
	 */
	public function optimize($image, $target = null)
	{
		$file = new \File($image, true);

		if (!$target) {
			$target = $image;
		}

		if ($file->exists() && $file->extension == 'png') {
			$processBuilder = new ProcessBuilder();
			$processBuilder->add($this->path);
			$processBuilder->add(TL_ROOT . '/' . $image);
			$processBuilder->add(TL_ROOT . '/' . $target);
			$process = $processBuilder->getProcess();
			$process->run();

			if (!$process->isSuccessful()) {
				throw new \RuntimeException('Could not execute pngrewrite: ' . $process->getErrorOutput());
			}
		}

		return $target;
	}
}
