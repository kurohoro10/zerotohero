<?php
/**
 * Layout Renderer
 * ---------------
 * Minimal HTML wrapper.
 * User-driven later.
 */

namespace App\UI;

class Layout
{
    public static function header():void
    {
        echo "<!DOCTYPE html><html><head><meta charset='UTF-8'></head><body>";
    }

    public static function footer(): void
    {
        echo "</body></html>";
    }
}