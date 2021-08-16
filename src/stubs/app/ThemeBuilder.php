<?php

namespace App;

use OzdemirBurak\Iris\Color\Hex;

class ThemeBuilder
{
    public $colors;

    public function __construct($colors)
    {
        $this->colors = collect(explode(',', $colors))->mapWithKeys(function($color, $index) {
            $hex = new Hex($color);
            return ['c' . ($index + 1) => collect([
                '100' => $hex,
                '200' => ($hex->isDark() ? $hex->lighten(3) : $hex->darken(3)),
                '300' => ($hex->isDark() ? $hex->lighten(6) : $hex->darken(6)),
                '400' => ($hex->isDark() ? $hex->lighten(9) : $hex->darken(9)),
                '500' => ($hex->isDark() ? $hex->lighten(12) : $hex->darken(12)),
                '600' => ($hex->isDark() ? $hex->lighten(15) : $hex->darken(15)),
                '700' => ($hex->isDark() ? $hex->lighten(18) : $hex->darken(18)),
                '800' => ($hex->isDark() ? $hex->lighten(21) : $hex->darken(21)),
                '900' => ($hex->isDark() ? $hex->lighten(24) : $hex->darken(24)),
            ])];
        });
    }

    public function generateCss()
    {
        return $this->colors->flatMap(function($group, $index) {
            return $group->map(function($color, $key) use ($index) {
                return  '--theme-' . $index . '-' . $key . ': ' . $color . ';';
            });
        })->join("\n");
    }
}
