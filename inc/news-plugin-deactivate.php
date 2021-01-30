<?php

/**
 * @package  NewsPlugin
 */

class NewsPluginDeactivate
{
    public static function np_deactivate() {
        flush_rewrite_rules();
    }
}