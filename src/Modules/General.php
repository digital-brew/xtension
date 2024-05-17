<?php

namespace DigitalBrew\Xtension\Modules;

use DigitalBrew\Hooks\Action;
use Illuminate\Container\EntryNotFoundException;

class General
{
  /**
   * @throws EntryNotFoundException
   */
  public static function init(): void
  {
    $instance = new self();

    Action::add( 'admin_head', [ $instance, 'accentColors' ] );
  }

  /**
   * @throws EntryNotFoundException
   */
  public function accentColors(): void
  {
    $accent = config('xtension.colors.accent', '#0fc0c0');
    $accent_light = config('xtension.colors.accent_light', '#DCFCFC');
    $accent_dark = config('xtension.colors.accent_dark', '#053E3E');
    echo '
      <style>
        :root {
          --color-accent: ' . $accent . ';
          --color-accent-light: ' . $accent_light . ';
          --color-accent-dark: ' . $accent_dark . ';
        }
      </style>
    ';
  }
}