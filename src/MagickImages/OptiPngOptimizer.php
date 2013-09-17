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
 * Class OptiPngOptimizer
 *
 * @package magickimages
 */
class OptiPngOptimizer implements OptimizerInterface
{
	/**
	 * @var string
	 */
	protected $path = 'optipng';

	/**
	 * @var int
	 */
	protected $level = 2;

	/**
	 * @param string $path
	 */
	public function setPath($path)
	{
		$this->path = (string) $path;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * @param int $level
	 */
	public function setLevel($level)
	{
		$this->level = (int) $level;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getLevel()
	{
		return $this->level;
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

		if ($file->exists() && in_array($file->extension, array('png', 'bmp', 'gif', 'pnm', 'tiff'))) {
			$processBuilder = new ProcessBuilder();
			$processBuilder
				->add($this->path)
				->add('-o')
				->add($this->level)
				->add('-out')
				->add(TL_ROOT . '/' . $target)
				->add(TL_ROOT . '/' . $image);
			$process = $processBuilder->getProcess();
			$process->run();

			if (!$process->isSuccessful()) {
				throw new \RuntimeException('Could not execute optipng: ' . $process->getErrorOutput());
			}
		}

		return $target;
	}
}
