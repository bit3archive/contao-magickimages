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
 * Class AdvPngOptimizer
 *
 * @package magickimages
 */
class AdvPngOptimizer implements OptimizerInterface
{
	protected $path = 'advpng';

	protected $level = 'normal';

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
	 * @param mixed $level
	 */
	public function setLevel($level)
	{
		$this->level = $level;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getLevel()
	{
		return $this->level;
	}

	/**
	 * {@inheritdoc}
	 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
	 */
	public function optimize($image, $target = null)
	{
		$file = new \File($image, true);

		if (!$target) {
			$target = $image;
		}

		if ($file->exists() && $file->extension == 'png') {
			// advpng does not support output files,
			// so we need to copy the file before optimize it
			if ($image != $target) {
				\Files::getInstance()
					->copy($image, $target);
			}

			$processBuilder = new ProcessBuilder();
			$processBuilder->add($this->path);
			$processBuilder->add('-z');
			switch ($this->level) {
				case 'store':
					$processBuilder->add('--shrink-store');
					break;
				case 'fast':
					$processBuilder->add('--shrink-fast');
					break;
				case 'extra':
					$processBuilder->add('--shrink-extra');
					break;
				case 'insane':
					$processBuilder->add('--shrink-insane');
					break;
				default:
					$processBuilder->add('--shrink-normal');
					break;
			}
			$processBuilder->add(TL_ROOT . '/' . $target);
			$process = $processBuilder->getProcess();
			$process->run();

			if (!$process->isSuccessful()) {
				throw new \RuntimeException('Could not execute advpng: ' . $process->getErrorOutput());
			}

			return $target;
		}

		return $image;
	}
}
