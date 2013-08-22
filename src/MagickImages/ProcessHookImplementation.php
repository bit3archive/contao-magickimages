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
 * Class MagickImages
 *
 * @package magickimages
 */
class ProcessHookImplementation implements HookInterface
{
	/**
	 * @var OptimizerInterface
	 */
	protected $optimizer;

	/**
	 * @var string
	 */
	protected $path = 'convert';

	/**
	 * @var float
	 */
	protected $jpegQuality;

	/**
	 * @var bool
	 */
	protected $smhEnabled;

	/**
	 * @var string
	 */
	protected $filter;

	/**
	 * @var bool
	 */
	protected $blurEnabled;

	/**
	 * @var float
	 */
	protected $blurRadius;

	/**
	 * @var float
	 */
	protected $blurSigma;

	/**
	 * @var bool
	 */
	protected $unsharpMaskEnabled;

	/**
	 * @var float
	 */
	protected $unsharpMaskRadius;

	/**
	 * @var float
	 */
	protected $unsharpMaskSigma;

	/**
	 * @var float
	 */
	protected $unsharpMaskAmount;

	/**
	 * @var float
	 */
	protected $unsharpMaskThreshold;

	/**
	 * @param string $path
	 */
	public function setPath($path)
	{
		$this->path = $path;
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
	 * {@inheritdoc}
	 */
	public function setOptimizer(OptimizerInterface $optimizer = null)
	{
		$this->optimizer = $optimizer;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getOptimizer()
	{
		return $this->optimizer;
	}

	/**
	 * @param float $jpegQuality
	 */
	public function setJpegQuality($jpegQuality)
	{
		$this->jpegQuality = $jpegQuality;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getJpegQuality()
	{
		return $this->jpegQuality;
	}

	/**
	 * @param boolean $smhEnabled
	 */
	public function setSmhEnabled($smhEnabled)
	{
		$this->smhEnabled = (bool) $smhEnabled;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isSmhEnabled()
	{
		return $this->smhEnabled;
	}

	/**
	 * @param string $filter
	 */
	public function setFilter($filter)
	{
		$this->filter = $filter;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFilter()
	{
		return $this->filter;
	}

	/**
	 * @param boolean $blurEnabled
	 */
	public function setBlurEnabled($blurEnabled)
	{
		$this->blurEnabled = (bool) $blurEnabled;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isBlur()
	{
		return $this->blurEnabled;
	}

	/**
	 * @param float $blurRadius
	 */
	public function setBlurRadius($blurRadius)
	{
		$this->blurRadius = $blurRadius;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getBlurRadius()
	{
		return $this->blurRadius;
	}

	/**
	 * @param float $blurSigma
	 */
	public function setBlurSigma($blurSigma)
	{
		$this->blurSigma = $blurSigma;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getBlurSigma()
	{
		return $this->blurSigma;
	}

	/**
	 * @param boolean $unsharpMaskEnabled
	 */
	public function setUnsharpMaskEnabled($unsharpMaskEnabled)
	{
		$this->unsharpMaskEnabled = (bool) $unsharpMaskEnabled;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isUnsharpMask()
	{
		return $this->unsharpMaskEnabled;
	}

	/**
	 * @param float $unsharpMaskRadius
	 */
	public function setUnsharpMaskRadius($unsharpMaskRadius)
	{
		$this->unsharpMaskRadius = $unsharpMaskRadius;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getUnsharpMaskRadius()
	{
		return $this->unsharpMaskRadius;
	}

	/**
	 * @param float $unsharpMaskSigma
	 */
	public function setUnsharpMaskSigma($unsharpMaskSigma)
	{
		$this->unsharpMaskSigma = $unsharpMaskSigma;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getUnsharpMaskSigma()
	{
		return $this->unsharpMaskSigma;
	}

	/**
	 * @param float $unsharpMaskAmount
	 */
	public function setUnsharpMaskAmount($unsharpMaskAmount)
	{
		$this->unsharpMaskAmount = $unsharpMaskAmount;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getUnsharpMaskAmount()
	{
		return $this->unsharpMaskAmount;
	}

	/**
	 * @param float $unsharpMaskThreshold
	 */
	public function setUnsharpMaskThreshold($unsharpMaskThreshold)
	{
		$this->unsharpMaskThreshold = $unsharpMaskThreshold;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getUnsharpMaskThreshold()
	{
		return $this->unsharpMaskThreshold;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get($image, $width, $height, $mode, $cacheName, \File $file, $target)
	{
		if (!$width && !$height) {
			return false;
		}

		$this->process($image, $width, $height, $mode, $cacheName, $file);

		// Set the file permissions when the Safe Mode Hack is used
		if ($this->smhEnabled) {
			\Files::getInstance()
				->chmod($cacheName, 0644);
		}

		if ($target) {
			\Files::getInstance()
				->copy($cacheName, $target);
			return $target;
		}

		// Return the path to new image
		return $cacheName;
	}

	protected function process($image, $width, $height, $mode, $cacheName, \File $file)
	{
		// detect image format
		$format = $file->extension;

		if ($format != 'jpg' && $format != 'png' && $format != 'gif') {
			$format = 'jpg';
		}

		$processBuilder = new ProcessBuilder();
		$processBuilder->add($this->path);

		// set the source path
		$sourcePath = TL_ROOT . '/' . $image;

		// set the output path
		$targetPath = TL_ROOT . '/' . $cacheName;

		// begin build the exec command
		$processBuilder->add($sourcePath);

		// set the jpeg quality
		if ($format == 'jpg') {
			$processBuilder->add('-quality');
			$processBuilder->add($this->jpegQuality);
		}

		$this->resizeAndCrop($file, $processBuilder, $width, $height, $mode);
		$this->filterImage($processBuilder);
		$this->blurImage($processBuilder);
		$this->unsharpImage($processBuilder);

		// add target file path
		$processBuilder->add($targetPath);

		$process = $processBuilder->getProcess();
		$process->run();

		if (!$process->isSuccessful()) {
			throw new \RuntimeException('Could not convert image: ' . $process->getErrorOutput());
		}
	}

	/**
	 * @param \File          $file
	 * @param ProcessBuilder $processBuilder
	 * @param string         $width
	 * @param string         $height
	 * @param string         $mode
	 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
	 * @SuppressWarnings(PHPMD.NPathComplexity)
	 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
	 */
	protected function resizeAndCrop(
		\File $file,
		ProcessBuilder $processBuilder,
		$width,
		$height,
		$mode
	) {
		// the target size
		$widthNumeric  = intval($width);
		$heightNumeric = intval($height);

		// Mode-specific changes
		if ($widthNumeric && $heightNumeric) {
			if ($mode == 'proportional') {
				if ($file->width >= $file->height) {
					unset($height, $heightNumeric);
				}
				else {
					unset($width, $widthNumeric);
				}
			}

			if ($mode == 'box') {
				if (ceil($file->height * $width / $file->width) <= $heightNumeric) {
					unset($height, $heightNumeric);
				}
				else {
					unset($width, $widthNumeric);
				}
			}
		}

		// Resize width and height and crop the image if necessary
		if ($widthNumeric && $heightNumeric) {
			$dblSrcAspectRatio    = $file->width / $file->height;
			$dblTargetAspectRatio = $widthNumeric / $heightNumeric;

			$processBuilder->add('-resize');

			// Advanced crop modes
			switch ($mode) {
				case 'left_top':
					$gravity = 'NorthWest';
					break;

				case 'center_top':
					$gravity = 'North';
					break;

				case 'right_top':
					$gravity = 'NorthEast';
					break;

				case 'left_center':
					$gravity = 'West';
					break;

				case 'right_center':
					$gravity = 'East';
					break;

				case 'left_bottom':
					$gravity = 'SouthWest';
					break;

				case 'center_bottom':
					$gravity = 'South';
					break;

				case 'right_bottom':
					$gravity = 'SouthEast';
					break;

				default:
					$gravity = 'Center';
					break;
			}

			if ($dblSrcAspectRatio == $dblTargetAspectRatio) {
				$processBuilder->add($widthNumeric . 'x' . $heightNumeric);
			}
			else if ($dblSrcAspectRatio < $dblTargetAspectRatio) {
				$processBuilder->add($widthNumeric . 'x' . $heightNumeric . '^');

				// crop image
				$processBuilder->add('-gravity');
				$processBuilder->add($gravity);
				$processBuilder->add('-extent');
				$processBuilder->add($widthNumeric . 'x' . $heightNumeric);
			}
			else if ($dblSrcAspectRatio > $dblTargetAspectRatio) {
				$processBuilder->add('0x' . $heightNumeric . '^');

				// crop image
				$processBuilder->add('-gravity');
				$processBuilder->add($gravity);
				$processBuilder->add('-extent');
				$processBuilder->add($widthNumeric . 'x' . $heightNumeric);
			}
		}

		// resize by width
		else if ($widthNumeric) {
			$processBuilder->add('-resize');
			$processBuilder->add($widthNumeric . 'x0^');
		}

		// resize by height
		else if ($heightNumeric) {
			$processBuilder->add('-resize');
			$processBuilder->add('0x' . $heightNumeric . '^');
		}
	}

	protected function filterImage(ProcessBuilder $processBuilder)
	{
		$processBuilder->add('-filter');
		$processBuilder->add($this->filter);
	}

	protected function blurImage(ProcessBuilder $processBuilder)
	{
		if ($this->blurEnabled) {
			$processBuilder->add('-blur');
			$processBuilder->add(
				$this->blurRadius .
				'x' .
				$this->blurSigma
			);
		}
	}

	protected function unsharpImage(ProcessBuilder $processBuilder)
	{
		if ($this->unsharpMasknMas) {
			$processBuilder->add('-unsharp');
			$processBuilder->add(
				sprintf(
					'%sx%s+%s+%s',
					$this->unsharpMaskRadius,
					$this->unsharpMaskSigma,
					$this->unsharpMaskAmount,
					$this->unsharpMaskThreshold
				)
			);
		}
	}
}
