<?php

/**
 * @package  NewsPlugin
 */

class NewsPluginActivate
{
    public static function np_activate() {
        flush_rewrite_rules();
    }
}