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
    wp_register_script('lscf-main-js', plugins_url('js/calcfields.js', __FILE__),
                       array('jquery'), "0.0.1", true);
}
add_action('wp_enqueue_scripts', 'lscf_register_script');

function lscf_shortcode_init()
{
    wp_enqueue_script('lscf-main-js');
}

function lscf_sc_total($args, $content)
{
    $atts = shortcode_atts(array('id' => ''),
                           $args);
    lscf_shortcode_init();

    $id = $atts['id'];
    if(strlen($id) > 0) $id = "lscf_id_{$id}";

    $o  = "<span class=\"lscf_total {$id}\">";
    $o .= $content;
    $o .= '</span>';

    return $o;
}
add_shortcode('lscf_total', 'lscf_sc_total');

function lsfc_sc_checkbox($args, $content)
{
    lscf_shortcode_init();
    $o = '';

    return $o;
}
add_shortcode('lscf_checkbox', 'lscf_sc_checkbox');
