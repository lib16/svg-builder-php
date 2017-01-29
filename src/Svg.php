<?php

namespace Lib16\SVG;

use Lib16\SVG\Enums\{PreserveAspectRatio, Units};
use Lib16\Graphics\Geometry\{Angle, Path, Point};
use Lib16\XML\Xml;
use Lib16\XML\Shared\{ClassAttribute, MediaAttribute, Target, TargetAttribute};
use Lib16\XML\Shared\XLink\XLink;
use Lib16\Utils\NumberFormatter;
use Lib16\Utils\Enums\Mime\{ImageType, StyleType};
use Lib16\Utils\Enums\CSS\Media;

class Svg extends Xml
{
	use ClassAttribute, MediaAttribute, TargetAttribute, XLink;

	const MIME_TYPE = ImageType::SVG;
	const FILENAME_EXTENSION = 'svg';
	const XML_NAMESPACE = 'http://www.w3.org/2000/svg';
	const MORE_XML_NAMESPACES = ['xlink' => 'http://www.w3.org/1999/xlink'];

	const FRACTION_DIGITS = 4;
	const DEGREES_FRACTION_DIGITS = 2;
	private static $formatter = null;
	private static $degreesFormatter = null;

	public static function createSvg($width = null, $height = null,
			string $viewBox = null, PreserveAspectRatio $preserve = null): self
	{
		static::$formatter = static::$formatter
				?? new NumberFormatter(static::FRACTION_DIGITS);
		static::$degreesFormatter = static::$degreesFormatter
				?? new NumberFormatter(static::DEGREES_FRACTION_DIGITS);

		return static::createRoot('svg')
				->attrib('width', $width)
				->attrib('height', $height)
				->attrib('viewBox', $viewBox)
				->setPreserveAspectRatio($preserve);
	}

	public function rect(Point $corner,
			float $width, float $height, float $rx = null, float $ry = null): self
	{
		$rect = $this->append('rect')
				->setPosition($corner)
				->setSize($width, $height);
		$rect->attributes
				->setNumber('rx', $rx, static::$formatter)
				->setNumber('ry', $ry, static::$formatter);
		return $rect;
	}

	public function circle(Point $center, float $r): self
	{
		$circle = $this->append('circle')->setCenter($center);
		$circle->attributes->setNumber('r', $r, static::$formatter);
		return $circle;
	}

	public function ellipse(Point $center, float $rx, float $ry): self
	{
		$ellipse = $this->append('ellipse')->setCenter($center);
		$ellipse->attributes
				->setNumber('rx', $rx, static::$formatter)
				->setNumber('ry', $ry, static::$formatter);
		return $ellipse;
	}

	public function line(Point $point1, Point $point2): self
	{
		return $this->append('line')
				->setPoint($point1, 'x1', 'y1')
				->setPoint($point2, 'x2', 'y2');
	}

	public function polyline(Point ...$points): self
	{
		return $this->append('polyline')->setPoints(...$points);
	}

	public function polygon(Point ...$points): self
	{
		return $this->append('polygon')->setPoints(...$points);
	}

	public function path(Path $d): self
	{
		return $this->append('path')->setD($d);
	}

	public function image(string $href, Point $position = null,
			float $width = null, float $height = null, PreserveAspectRatio $preserve = null): self
	{
		return $this->append('image')
				->setHref($href)
				->setPosition($position)
				->setSize($width, $height)
				->setPreserveAspectRatio($preserve);
	}

	public function text(string $content = null,
			Point $position = null, $dx = null, $dy = null, $rotate = null): self
	{
		return $this->append('text', $content)
				->setPosition($position)
				->attrib('dx', $dx)
				->attrib('dy', $dy)
				->attrib('rotate', $rotate);
	}

	public function tspan(string $content = null,
			Point $position = null, $dx = null, $dy = null, $rotate = null): self
	{
		return $this->append('tspan', $content)
				->setPosition($position)
				->attrib('dx', $dx)
				->attrib('dy', $dy)
				->attrib('rotate', $rotate);
	}

	public function textPath(string $content, string $href): self
	{
		return $this->append('textPath', $content)->setHref($href);
	}

	public function a(string $href, $target = null): self
	{
		return $this->append('a')
				->setHref($href)
				->setTarget($target);
	}

	public function defs(): self
	{
		return $this->append('defs');
	}

	public function use(string $href, Point $corner,
			float $width = null, float $height = null): self
	{
		return $this->append('use')
				->setHref($href)
				->setPosition($corner)
				->setSize($width, $height);
	}

	public function g(): self
	{
		return $this->append('g');
	}

	public function title(string $content): self
	{
		return $this->append('title', $content);
	}

	public function desc(string $content): self
	{
		return $this->append('desc', $content);
	}

	public function clipPath(string $id, Units $clipPathUnits = null): self
	{
		return $this->append('clipPath')
				->setId($id)
				->attrib('clipPathUnits', $clipPathUnits);
	}

	public function mask(string $id, Point $position = null,
			float $width = null, float $height = null,
			Units $maskUnits = null, Units $maskContentUnits = null): self
	{
		return $this->append('mask')
				->setId($id)
				->setPosition($position)
				->setSize($width, $height)
				->setMaskUnits($maskUnits)
				->setMaskContentUnits($maskContentUnits);
	}

	public function style(string $content, StyleType $type = null, Media ...$media): self
	{
		return $this->append('style')
				->cdata()
				->appendText($content)
				->attrib('type', $type)
				->setMedia(...$media);
	}

	/**
	 * Appends a <code>translate</code> operation to the <code>transform</code> attribute.
	 */
	public function addTranslate(float $x, float $y = null): self
	{
		return $this->setTransform('translate',
				static::$formatter->format($x), static::$formatter->format($y));
	}

	/**
	 * Appends a <code>scale</code> operation to the <code>transform</code> attribute.
	 */
	public function addScale(float $x, float $y = null): self
	{
		return $this->setTransform('scale',
				static::$formatter->format($x), static::$formatter->format($y));
	}

	/**
	 * Appends a <code>rotate</code> operation to the <code>transform</code> attribute.
	 */
	public function addRotate($angle, Point $center = null): self
	{
		return $this->setTransform('rotate',
				self::degrees($angle),
				is_null($center) ? $center : $center->toSvg(static::$formatter));
	}

	/**
	 * Appends a <code>skewX</code> operation to the <code>transform</code> attribute.
	 */
	public function addSkewX($angle): self
	{
		return $this->setTransform('skewX', self::degrees($angle));
	}

	/**
	 * Appends a <code>skewY</code> operation to the <code>transform</code> attribute.
	 */
	public function addSkewY($angle): self
	{
		return $this->setTransform('skewY', self::degrees($angle));
	}

	/**
	 * Appends a <code>matrix</code> operation to the <code>transform</code> attribute.
	 */
	public function addMatrix(float $a, float $b, float $c, float $d, float $e, float $f): self
	{
		return $this->setTransform('matrix',
				static::$formatter->formatArray([$a, $b, $c, $d, $e, $f], ' '));
	}

	/**
	 * Sets the <code>cx</code> and <code>cy</code> attributes.
	 */
	public function setCenter(Point $center = null): self
	{
		return $this->setPoint($center, 'cx', 'cy');
	}

	public function setD(Path $d = null): self
	{
		$this->attributes->setComplex(
				'd', ' ', false, $d->toSvg(static::$formatter, static::$degreesFormatter));
		return $this;
	}

	public function setDx(float ...$dx): self
	{
		$this->attributes->setNumbers('dx', ' ', static::$formatter, null, ...$dx);
		return $this;
	}

	public function setDy(float ...$dy): self
	{
		$this->attributes->setNumbers('dy', ' ', static::$formatter, null, ...$dy);
		return $this;
	}

	public function setHeight(float $height = null): self
	{
		return $this->attrib('height', $height);
	}

	public function setHref(string $href = null): self
	{
		return $this->setXLinkHref($href);
	}

	public function setId(string $id = null): self
	{
		return $this->attrib('id', $id);
	}

	public function setMaskContentUnits(Units $maskContentUnits = null): self
	{
		return $this->attrib('maskContentUnits', $maskContentUnits);
	}

	public function setMaskUnits(Units $maskUnits = null): self
	{
		return $this->attrib('maskUnits', $maskUnits);
	}

	public function setPoints(Point... $points): self
	{
		foreach ($points as $point) {
			$this->attributes->setComplex('points', ' ', false, $point->toSvg(static::$formatter));
		}
		return $this;
	}

	/**
	 * Sets the <code>x</code> and <code>y</code> attributes.
	 */
	public function setPosition(Point $position = null): self
	{
		return $this->setPoint($position, 'x', 'y');
	}

	public function setPreserveAspectRatio(PreserveAspectRatio $preserve = null): self
	{
		return $this->attrib('preserveAspectRatio', $preserve);
	}

	public function setRotate(Angle ...$rotate): self
	{
		$this->attributes->setNumbers('rotate', ' ', static::$formatter, null, ...$rotate);
		return $this;
	}

	/**
	 * Sets the <code>$width</code> and <code>$height</code> attributes.
	 */
	public function setSize(float $width = null, float $height = null): self
	{
		return $this->setWidth($width)->setHeight($height);
	}

	public function setViewBox(Point $corner, float $width, float $height): self
	{
		return $this->attrib('viewBox', static::$formatter->formatArray([
			$corner->getX(), $corner->getY(), $width, $height
		], ' '));
	}

	public function setWidth(float $width = null): self
	{
		return $this->attrib('width', $width);
	}

	private static function degrees($angle)
	{
		return static::$degreesFormatter
				->format($angle instanceof Angle ? $angle->getDegrees() : $angle);
	}

	private function setTransform(string $type, ...$args)
	{
		$args = implode(' ', array_filter($args, 'strlen'));
		$this->attributes->setComplex('transform', ' ', false, $type . '(' . $args . ')');
		return $this;
	}

	private function setUnitsAttrib(string $attributeName, Units $units): self
	{
		$this->attrib($attributeName, $units);
		return $this;
	}

	private function setPoint(Point $point = null, string $xName = 'x', string $yName = 'y')
	{
		$x = null;
		$y = null;
		if (!is_null($point)) {
			$x = $point->getX();
			$y = $point->getY();
		}
		$this->attributes
				->setNumber($xName, $x, static::$formatter)
				->setNumber($yName, $y, static::$formatter);
		return $this;
	}
}

