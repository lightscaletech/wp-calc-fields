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

$fieldCounter = 0;

function lscf_register_script()
{
    wp_register_script('lscf-main-js',
                       plugins_url('js/calcfields.js', __FILE__),
                       array('jquery'), "0.0.1", true);
}
add_action('wp_enqueue_scripts', 'lscf_register_script');

function lscf_shortcode_init()
{
    wp_enqueue_script('lscf-main-js');
}

function lscf_nomalise_id($id)
{
    return (strlen($id) >  0 ? "lscf_id_{$id}" : '');
}

function lscf_sc_total($args, $content)
{
    $atts = shortcode_atts(array('id' => ''),
                           $args);
    $id = lscf_nomalise_id($atts['id']);

    lscf_shortcode_init();

    $o  = "<span class=\"lscf_total {$id}\">";
    $o .= $content;
    $o .= '</span>';

    return $o;
}
add_shortcode('lscf_total', 'lscf_sc_total');

function lscf_sc_checkbox($args, $content)
{
    global $fieldCounter;

    $atts = shortcode_atts(array('id' => '',
                                 'value' => '0'),
                           $args);
    $id = lscf_nomalise_id($atts['id']);
    $hid = 'lscf_cb_' . $fieldCounter++;
    $val = floatval($atts['value']);
    lscf_shortcode_init();

    $o  = "<label for=\"{$hid}\">{$content}</label> ";
    $o .= "<input type=\"checkbox\" id=\"{$hid}\" class=\"lscf_field {$id}\" " .
          " value=\"{$val}\" \>";

    return $o;
}
add_shortcode('lscf_checkbox', 'lscf_sc_checkbox');
