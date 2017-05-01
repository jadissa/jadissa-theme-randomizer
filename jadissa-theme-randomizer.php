<?php
defined( 'ABSPATH' ) or die( 'Direct access to this file is prevented' );

/*
Plugin Name: jadissa-theme-randomizer
Plugin URI:  https://github.com/jadissa/jadissa-theme-randomizer.git
Description: jadissa-theme-randomizer is pretty self-explanatory but essentially, it randomizes the active theme at runtime for each page load
Version:     1
Author:      Jadissa Griffin
Author URI:  https://github.com/jadissa
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: github
Domain Path: /jadissa

jadissa-theme-randomizer is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

jadissa-theme-randomizer is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with jadissa-theme-randomizer. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

function add_to_wplog($message)
{
    if (WP_DEBUG === true)
    {
        if (is_array($message) || is_object($message))
        {
            error_log(print_r($message, true));
        }
        else
        {
            error_log($message);
        }
    }
}

function j_randomizer()
{
    if (did_action('init') === 1)
    {
        add_to_wplog('starting theme randomizer...');

        $current_theme = wp_get_theme();

        // Get all the site allowed themes
        $themes = wp_get_themes(true);
        if (!$themes)
        {
            return;
        }

        // Inspect for needed elements
        $themes_metadata = [];
        foreach ($themes as $stylesheet => $theme)
        {
            //add_to_wplog(get_class_methods($theme));
            $themes_metadata[$stylesheet] = $theme->get('ThemeURI');
        }

        // Available themes
        $available_randoms = array_diff($themes_metadata, [$current_theme->get('ThemeURI')]);
        //add_to_wplog($available_randoms);

        // Randomizer
        $random_theme = array_rand($available_randoms, 1);
        //add_to_wplog($random_theme);

        //do_action('switch_theme', $random_theme);
        //update_option('template', $random_theme);
        //update_option('stylesheet', $random_theme);
        //update_option('current_theme', $random_theme);
        add_to_wplog("done setting to $random_theme");
    }
}

// Before headers sent
add_action('init', 'j_randomizer');