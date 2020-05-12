<?php
namespace Lib16\SVG\Tests;

use Lib16\SVG\Svg;
use Lib16\SVG\Enums\ {
    PreserveAspectRatio,
    Units
};
use Lib16\Graphics\Geometry\ {
    Point,
    Angle,
    Path
};
use Lib16\XML\Shared\Target;
use Lib16\Utils\Enums\Mime\StyleType;
use Lib16\Utils\Enums\CSS\Media;
use PHPUnit\Framework\TestCase;

class SvgTest extends TestCase
{
    private $point, $angle;

    public function setUp()
    {
        $this->p = new Point(10, 20);
        $this->a = Angle::byDegrees(45);
    }

    public function testCreateSvg1()
    {
        $this->assertEqualSvg(
            Svg::createSvg(
                '100%',
                '100%',
                '0 0 400 300',
                PreserveAspectRatio::XMIDYMIN_SLICE()
            ),
            '<?xml version="1.0" encoding="UTF-8" ?>'
            . "\n" . '<svg xmlns="http://www.w3.org/2000/svg"'
            . ' xmlns:xlink="http://www.w3.org/1999/xlink"'
            . ' width="100%" height="100%"'
            . ' viewBox="0 0 400 300"'
            . ' preserveAspectRatio="xMidYMin slice"/>'
        );
    }

    public function testCreateSvg2()
    {
        $this->assertEqualSvg(
            Svg::createSvg(),
            '<?xml version="1.0" encoding="UTF-8" ?>'
            . "\n" . '<svg xmlns="http://www.w3.org/2000/svg"'
            . ' xmlns:xlink="http://www.w3.org/1999/xlink"/>'
        );
    }

    public function testRect1()
    {
        $this->assertEqualSvg(
            Svg::create()->rect($this->p, 30, 40, 5, 2.5),
            '<rect x="10" y="20" width="30" height="40" rx="5" ry="2.5"/>'
        );
    }

    public function testRect2()
    {
        $this->assertEqualSvg(
            Svg::create()->rect($this->p, 30, 40),
            '<rect x="10" y="20" width="30" height="40"/>'
        );
    }

    public function testCircle()
    {
        $this->assertEqualSvg(
            Svg::create()->circle($this->p, 30),
            '<circle cx="10" cy="20" r="30"/>'
        );
    }

    public function testEllipse()
    {
        $this->assertEqualSvg(
            Svg::create()->ellipse($this->p, 30, 25),
            '<ellipse cx="10" cy="20" rx="30" ry="25"/>'
        );
    }

    public function testLine()
    {
        $this->assertEqualSvg(
            Svg::create()->line($this->p, new Point(30, 40)),
            '<line x1="10" y1="20" x2="30" y2="40"/>'
        );
    }

    public function testPolyline()
    {
        $this->assertEqualSvg(
            Svg::create()->polyline($this->p, new Point(30, 40), new Point(50, 60)),
            '<polyline points="10,20 30,40 50,60"/>'
        );
    }

    public function testPolygon()
    {
        $this->assertEqualSvg(
            Svg::create()->polygon($this->p, new Point(30, 40), new Point(50, 60)),
            '<polygon points="10,20 30,40 50,60"/>'
        );
    }

    public function testPath()
    {
        $this->assertEqualSvg(
            Svg::create()->path((new Path())->star($this->p, 4, 100)),
            '<path d="M 10,-80 L 110,20 L 10,120 L -90,20 Z"/>'
        );
    }

    public function testImage()
    {
        $this->assertEqualSvg(
            Svg::create()->image(
                'cat.jpg',
                new Point(80, 20),
                320,
                200,
                PreserveAspectRatio::XMIDYMID()
            ),
            '<image xlink:href="cat.jpg" x="80" y="20" width="320" height="200"'
            . ' preserveAspectRatio="xMidYMid"/>'
        );
    }

    public function testText1()
    {
        $this->assertEqualSvg(
            Svg::create()->text('lorem ipsum', new Point(20, 100)),
            '<text x="20" y="100">lorem ipsum</text>'
        );
    }

    public function testText2()
    {
        $this->assertEqualSvg(
            Svg::create()->text('lorem ipsum', new Point(0, 0)),
            '<text x="0" y="0">lorem ipsum</text>'
        );
    }

    public function testText3()
    {
        $this->assertEqualSvg(
            Svg::create()->text('lorem ipsum'),
            '<text>lorem ipsum</text>'
        );
    }

    public function testText4()
    {
        $this->assertEqualSvg(
            Svg::create()->text(),
            '<text/>'
        );
    }

    public function testTspan1()
    {
        $this->assertEqualSvg(
            Svg::create()->tspan('lorem ipsum', new Point(30, 110)),
            '<tspan x="30" y="110">lorem ipsum</tspan>'
        );
    }

    public function testTspan2()
    {
        $this->assertEqualSvg(
            Svg::create()->tspan('lorem ipsum'),
            '<tspan>lorem ipsum</tspan>'
        );
    }

    public function testTspan3()
    {
        $this->assertEqualSvg(
            Svg::create()->tspan(),
            '<tspan/>'
        );
    }

    public function testTextPath()
    {
        $this->assertEqualSvg(
            Svg::create()->textPath('lorem ipsum', '#path'),
            '<textPath xlink:href="#path">lorem ipsum</textPath>'
        );
    }

    public function testA1()
    {
        $this->assertEqualSvg(
            Svg::create()->a('https://github.com', Target::BLANK()),
            '<a xlink:href="https://github.com" target="_blank"/>'
        );
    }

    public function testA2()
    {
        $this->assertEqualSvg(
            Svg::create()->a('https://github.com'),
            '<a xlink:href="https://github.com"/>'
        );
    }

    public function testUse1()
    {
        $this->assertEqualSvg(
            Svg::create()->use('#circle', new Point(20, 30), 40, 50),
            '<use xlink:href="#circle" x="20" y="30" width="40" height="50"/>'
        );
    }

    public function testUse2()
    {
        $this->assertEqualSvg(
            Svg::create()->use('#circle', new Point(20, 40)),
            '<use xlink:href="#circle" x="20" y="40"/>'
        );
    }

    public function testDefs()
    {
        $this->assertEqualSvg(
            Svg::create()
                ->defs()
                ->circle(new Point(0, 0), 20)
                ->setId('circle'),
            "<defs>\n\t<circle cx=\"0\" cy=\"0\" r=\"20\" id=\"circle\"/>\n</defs>"
        );
    }

    public function testG()
    {
        $this->assertEqualSvg(
            Svg::create()->g()->circle(new Point(0, 0), 20),
            "<g>\n\t<circle cx=\"0\" cy=\"0\" r=\"20\"/>\n</g>"
        );
    }

    public function testTitle()
    {
        $this->assertEqualSvg(
            Svg::create()->title('Lorem Ipsum'),
            '<title>Lorem Ipsum</title>'
        );
    }

    public function testDesc()
    {
        $this->assertEqualSvg(
            Svg::create()->desc('lorem ipsum'),
            '<desc>lorem ipsum</desc>'
        );
    }

    public function testClipPath1()
    {
        $this->assertEqualSvg(
            Svg::create()->clipPath('p1', Units::USER_SPACE_ON_USE()),
            '<clipPath id="p1" clipPathUnits="userSpaceOnUse"/>'
        );
    }

    public function testClipPath2()
    {
        $this->assertEqualSvg(
            Svg::create()->clipPath('p1'),
            '<clipPath id="p1"/>'
        );
    }

    public function testMask1()
    {
        $this->assertEqualSvg(
            Svg::create()->mask(
                'm1',
                new Point(10, 20),
                200,
                120,
                Units::OBJECT_BOUNDING_BOX(),
                Units::USER_SPACE_ON_USE()
            ),
            '<mask id="m1" x="10" y="20" width="200" height="120"'
            . ' maskUnits="objectBoundingBox" maskContentUnits="userSpaceOnUse"/>'
        );
    }

    public function testMask2()
    {
        $this->assertEqualSvg(
            Svg::create()->mask('m1', new Point(10, 20)),
            '<mask id="m1" x="10" y="20"/>'
        );
    }

    public function testMask3()
    {
        $this->assertEqualSvg(
            Svg::create()->mask('m1'),
            '<mask id="m1"/>'
        );
    }

    public function testStyle()
    {
        $this->assertEqualSvg(
            Svg::create()->defs()->style(
                ".h1 {\n\tfont-size: 20px;\n}",
                StyleType::CSS(),
                Media::SCREEN(),
                Media::PRINT()
            ),
            "<defs>\n\t<style type=\"text/css\" media=\"screen,print\">"
            . "\n\t"
            . Svg::CDATA_START
            . "\n\t\t.h1 {\n\t\t\tfont-size: 20px;\n\t\t}"
            . "\n\t"
            . Svg::CDATA_STOP
            . "\n\t</style>\n</defs>"
        );
    }

    public function testTransformAttribute1()
    {
        $this->assertEqualSvg(
            Svg::create()->circle($this->p, 100)->addTranslate(50, 40),
            '<circle cx="10" cy="20" r="100" transform="translate(50 40)"/>'
        );
    }

    public function testTransformAttribute2()
    {
        $this->assertEqualSvg(
            Svg::create()->circle($this->p, 100)->addTranslate(50),
            '<circle cx="10" cy="20" r="100" transform="translate(50)"/>'
        );
    }

    public function testTransformAttribute3()
    {
        $this->assertEqualSvg(
            Svg::create()->circle($this->p, 100)->addScale(1.5, - 2),
            '<circle cx="10" cy="20" r="100" transform="scale(1.5 -2)"/>'
        );
    }

    public function testTransformAttribute4()
    {
        $this->assertEqualSvg(
            Svg::create()->circle($this->p, 100)->addScale(1.5),
            '<circle cx="10" cy="20" r="100" transform="scale(1.5)"/>'
        );
    }

    public function testTransformAttribute5()
    {
        $this->assertEqualSvg(
            Svg::create()->circle($this->p, 100)->addRotate($this->a),
            '<circle cx="10" cy="20" r="100" transform="rotate(45)"/>'
        );
    }

    public function testTransformAttribute6()
    {
        $this->assertEqualSvg(
            Svg::create()->circle($this->p, 100)->addRotate(60),
            '<circle cx="10" cy="20" r="100" transform="rotate(60)"/>'
        );
    }

    public function testTransformAttribute7()
    {
        $this->assertEqualSvg(
            Svg::create()->circle($this->p, 100)->addRotate($this->a, $this->p),
            '<circle cx="10" cy="20" r="100" transform="rotate(45 10,20)"/>'
        );
    }

    public function testTransformAttribute8()
    {
        $this->assertEqualSvg(
            Svg::create()->circle($this->p, 100)->addSkewX($this->a),
            '<circle cx="10" cy="20" r="100" transform="skewX(45)"/>'
        );
    }

    public function testTransformAttribute9()
    {
        $this->assertEqualSvg(
            Svg::create()->circle($this->p, 100)->addSkewY(60),
            '<circle cx="10" cy="20" r="100" transform="skewY(60)"/>'
        );
    }

    public function testTransformAttribute10()
    {
        $this->assertEqualSvg(
            Svg::create()->circle($this->p, 100)->addMatrix(1, 2, 3, 4, 5, 6),
            '<circle cx="10" cy="20" r="100" transform="matrix(1 2 3 4 5 6)"/>'
        );
    }

    public function testTransformAttribute11()
    {
        $this->assertEqualSvg(
            Svg::create()
                ->circle($this->p, 100)
                ->addScale(0.6, 1)
                ->addSkewX($this->a),
            '<circle cx="10" cy="20" r="100" transform="scale(0.6 1) skewX(45)"/>'
        );
    }


    public function testSetClass()
    {
        $this->assertEqualSvg(
            Svg::create()->g()->setClass('foo', 'bar')->setClass('baz'),
            '<g class="foo bar baz"/>'
        );
    }

    public function testSetDx()
    {
        $this->assertEqualSvg(
            Svg::create()->text('foo bar')->setDx(- 5, 0),
            '<text dx="-5 0">foo bar</text>'
        );
    }

    public function testSetDy()
    {
        $this->assertEqualSvg(
            Svg::create()->text('foo bar')->setDy(- 5, 0),
            '<text dy="-5 0">foo bar</text>'
        );
    }

    public function testSetRotate()
    {
        $this->assertEqualSvg(
            Svg::createSub()->text('foo bar')->setRotate(
                Angle::byDegrees(15),
                Angle::byDegrees(10),
                Angle::byDegrees(5),
                Angle::byDegrees(0)
            ),
            '<text rotate="15 10 5 0">foo bar</text>'
        );
    }

    public function testSetViewbox()
    {
        $this->assertEqualSvg(
            Svg::create()
                ->image('image.jpg')
                ->setViewBox(new Point(0, 20), 640, 400),
            '<image xlink:href="image.jpg" viewBox="0 20 640 400"/>'
        );
    }

    public function assertEqualSvg(Svg $actual, string $expected)
    {
        Svg::initialize();
        $this->assertEquals($expected, $actual->__toString());
    }
}
