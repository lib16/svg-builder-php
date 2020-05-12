# Lib16 SVG Builder for PHP 7
A library for creating SVG documents written in PHP 7.

[![Build Status](https://travis-ci.org/lib16/svg-builder-php.svg?branch=master)](https://travis-ci.org/lib16/svg-builder-php)

## Installation with Composer
This package is available on [packagist](https://packagist.org/packages/lib16/svg), so you can use [Composer](https://getcomposer.org) to install it.
Run the following command in your shell:

```
composer require lib16/svg
```

## Basic Usage

```php
<?php
require_once 'vendor/autoload.php';

use Lib16\SVG\Svg;
use Lib16\Graphics\Geometry\Point;

$dbRows = [
    ['month' => '2015-01', 'clicks' => '501'],
    ['month' => '2015-02', 'clicks' => '560'],
    ['month' => '2015-03', 'clicks' => '543'],
    ['month' => '2015-04', 'clicks' => '607'],
    ['month' => '2015-05', 'clicks' => '646'],
    ['month' => '2015-06', 'clicks' => '645']
];

$svg = Svg::createSvg(400, 400);
$svg->defs()->style('.bgr {
    fill: #593;
    fill-opacity: 0.25;
}
.graph {
    fill: none;
    stroke-width: 3px;
    stroke: #593;
}
.solid {
    fill: #593;
    fill-opacity: 0.5;
}
.labels, .title {
    font-family: open sans, tahoma, verdana, sans-serif;
    fill: 333;
    stroke: none;
}
.labels {
    font-size: 16px;
}
.title {
    font-size: 24px;
    text-anchor: middle;
}');
$group = $svg->g();
$group->rect(new Point(0, 0), 400, 400)->setClass('bgr');
$group->text('Clicks 1/2015', new Point(200, 45))->setClass('title');
$solid = $group->polygon()->setClass('solid');
$solid->setPoints(new Point(350, 330), new Point(50, 330));
$graph = $group->polyline()->setClass('graph');
$labels1 = $group->text()->setClass('labels');
$labels2 = $group->text()->setClass('labels');
foreach ($dbRows as $i => $row) {
    $x = 50 + $i * 60;
    $y = (1000 - $row['clicks']) / 2;
    $solid->setPoints(new Point($x, $y));
    $graph->setPoints(new Point($x, $y));
    $labels1->tspan($row['clicks'], new Point($x - 10, $y - 15));
    $labels2->tspan(
        strftime('%b', (new DateTime($row['month']))->getTimestamp()),
        new Point($x - 10, 350)
    );
}
print $svg->headerfields('stats');
print $svg->getMarkup();
```

The generated markup:

```svg
<?xml version="1.0" encoding="UTF-8" ?>
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="400" height="400">
    <defs>
        <style>
        <![CDATA[
            .bgr {
                fill: #593;
                fill-opacity: 0.25;
            }
            .graph {
                fill: none;
                stroke-width: 3px;
                stroke: #593;
            }
            .solid {
                fill: #593;
                fill-opacity: 0.5;
            }
            .labels, .title {
                font-family: open sans, tahoma, verdana, sans-serif;
                fill: 333;
                stroke: none;
            }
            .labels {
                font-size: 16px;
            }
            .title {
                font-size: 24px;
                text-anchor: middle;
            }
        ]]>
        </style>
    </defs>
    <g>
        <rect x="0" y="0" width="400" height="400" class="bgr"/>
        <text x="200" y="45" class="title">Clicks 1/2015</text>
        <polygon class="solid" points="350,330 50,330 50,249.5 110,220 170,228.5 230,196.5 290,177 350,177.5"/>
        <polyline class="graph" points="50,249.5 110,220 170,228.5 230,196.5 290,177 350,177.5"/>
        <text class="labels">
            <tspan x="40" y="234.5">501</tspan>
            <tspan x="100" y="205">560</tspan>
            <tspan x="160" y="213.5">543</tspan>
            <tspan x="220" y="181.5">607</tspan>
            <tspan x="280" y="162">646</tspan>
            <tspan x="340" y="162.5">645</tspan>
        </text>
        <text class="labels">
            <tspan x="40" y="350">Jan</tspan>
            <tspan x="100" y="350">Feb</tspan>
            <tspan x="160" y="350">Mar</tspan>
            <tspan x="220" y="350">Apr</tspan>
            <tspan x="280" y="350">May</tspan>
            <tspan x="340" y="350">Jun</tspan>
        </text>
    </g>
</svg>
```

