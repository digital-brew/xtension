<?php

namespace DigitalBrew\Xtension\Modules;

use DigitalBrew\Hooks\Action;

class General
{
    public static function register(): void
    {
        $instance = new self;

        Action::add('admin_head', [$instance, 'accentColors']);
    }

    public function accentColors(): void
    {
        $accent = getConfig('xtension.colors.accent', '#0fc0c0');
        $accent_light = getConfig('xtension.colors.accent_light', '#DCFCFC');
        $accent_dark = getConfig('xtension.colors.accent_dark', '#053E3E');
        $accent_bg = getConfig('xtension.colors.accent_bg', '#edf7f7');
        echo '
      <style>
        :root {
          --color-accent: '.$accent.';
          --color-accent-light: '.$accent_light.';
          --color-accent-dark: '.$accent_dark.';
          --color-accent-bg: '.$accent_bg.';
        }
      </style>
    ';
    }
}

