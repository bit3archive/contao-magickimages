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
 * Class ImagickHookImplementation
 *
 * @package magickimages
 */
class ImagickHookImplementation implements HookInterface
{
	/**
	 * @var OptimizerInterface
	 */
	protected $optimizer;

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

		$cacheName = $this->process($image, $width, $height, $mode, $cacheName, $file);

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

		// load imagick
		$imagick = new \Imagick();

		// read the source file
		$imagick->readImage(TL_ROOT . '/' . $image);

		// set the output format
		$imagick->setImageFormat($format);

		// set the jpeg quality
		if ($format == 'jpg') {
			$imagick->setImageCompression(\Imagick::COMPRESSION_JPEG);
			$imagick->setImageCompressionQuality($this->jpegQuality);
		}

		$this->resizeAndCrop($file, $imagick, $width, $height, $mode);
		$this->blurImage($imagick);
		$this->unsharpImage($imagick);

		if (!$imagick->writeImage(TL_ROOT . '/' . $cacheName)) {
			throw new \Exception('Could not write resized image');
		}

		return $this->optimize($cacheName);
	}

	/**
	 * @param \File    $file
	 * @param \Imagick $imagick
	 * @param string   $width
	 * @param string   $height
	 * @param string   $mode
	 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
	 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
	 */
	protected function resizeAndCrop(\File $file, \Imagick $imagick, $width, $height, $mode)
	{
		// set filter
		$filterName = 'FILTER_' . strtoupper(
				preg_replace('#[^\w]#', '', $this->filter)
			);
		$class      = new \ReflectionClass('Imagick');
		$filter     = $class->getConstant($filterName);

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

			// Advanced crop modes
			list($horizMode, $vertMode) = explode('_', $mode);

			if ($dblSrcAspectRatio == $dblTargetAspectRatio) {
				$imagick->resizeImage(
					$widthNumeric,
					$heightNumeric,
					$filter,
					1
				);
			}
			else if ($dblSrcAspectRatio < $dblTargetAspectRatio) {
				$imagick->resizeImage(
					$widthNumeric,
					0,
					$filter,
					1
				);

				switch ($vertMode) {
					case 'top':
						$positionY = 0;
						break;
					case 'bottom':
						$positionY = $imagick->getImageHeight() - $heightNumeric;
						break;
					default:
						$positionY = ceil(($imagick->getImageHeight() - $heightNumeric) / 2);
						break;
				}

				$imagick->cropImage(
					$widthNumeric,
					$heightNumeric,
					0,
					$positionY
				);
			}
			else if ($dblSrcAspectRatio > $dblTargetAspectRatio) {
				$imagick->resizeImage(
					0,
					$heightNumeric,
					$filter,
					1
				);

				switch ($horizMode) {
					case 'left':
						$positionX = 0;
						break;
					case 'right':
						$positionX = $imagick->getImageWidth() - $widthNumeric;
						break;
					default:
						$positionX = ceil(($imagick->getImageWidth() - $widthNumeric) / 2);
						break;
				}

				$imagick->cropImage(
					$widthNumeric,
					$heightNumeric,
					$positionX,
					0
				);
			}
		}

		// resize by width
		else if ($widthNumeric) {
			$imagick->resizeImage(
				$widthNumeric,
				ceil($widthNumeric * $file->height / $file->width),
				$filter,
				1
			);
		}

		// resize by height
		else if ($heightNumeric) {
			$imagick->resizeImage(
				ceil($heightNumeric * $file->width / $file->height),
				$heightNumeric,
				$filter,
				1
			);
		}
	}

	protected function blurImage(\Imagick $imagick)
	{
		if ($this->blurEnabled) {
			$imagick->blurimage(
				$this->blurRadius,
				$this->blurSigma
			);
		}
	}

	protected function unsharpImage(\Imagick $imagick)
	{
		if ($this->unsharpMaskEnabled) {
			$imagick->unsharpMaskImage(
				$this->unsharpMaskRadius,
				$this->unsharpMaskSigma,
				$this->unsharpMaskAmount,
				$this->unsharpMaskThreshold
			);
		}
	}

	protected function optimize($cacheName)
	{
		if ($this->optimizer) {
			return $this->optimizer->optimize($cacheName);
		}
		return $cacheName;
	}
}