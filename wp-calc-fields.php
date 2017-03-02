<?php
/*
   Plugin Name: Calculation fields
   Description: A set of shortcodes to calculate a total on a post
   Version:     0.0.1
   Author:      Lightscale Tech Ltd
   Author URI:  http://lightscale.co.uk/
   License:     GPL3
   License URI: https://www.gnu.org/licenses/gpl-3.0.html
   Text Domain: lscf
 */

function lscf_register_script()
{
    wp_register_script('lsfc-main-js', plugins_url('js/calcfields.js'),
                       array('jquery'), "0.0.1", true);
}
add_action('wp_enqueue_scripts', 'lscf_register_script');

function lsfc_shortcode_init()
{
    wp_enqueue_script('lsfc-main-js');
}

function lsfc_sc_total($args, $content)
{
    lsfc_shortcode_init();
    $o = '';

    return $o;
}
add_shortcode('lscf_total', 'lscf_sc_total');

function lsfc_sc_checkbox($args, $content)
{
    lsfc_shortcode_init();
    $o = '';

    return $o;
}
add_shortcode('lscf_total', 'lscf_sc_checkbox');
