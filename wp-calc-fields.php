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
    $atts = shortcode_atts(array('id' => '',
                                 'decimal' => '2'),
                           $args);
    $id = lscf_nomalise_id($atts['id']);
    $decimal = $atts['decimal'];

    lscf_shortcode_init();

    $o  = "<span class=\"lscf_total {$id}\" data-decimal=\"{$decimal}\">";
    $o .= $content;
    $o .= '</span>';

    return $o;
}
add_shortcode('lscf_total', 'lscf_sc_total');

function lscf_sc_checkbox($args, $content)
{
    global $fieldCounter;

    $atts = shortcode_atts(array('id' => '',
                                 'value' => '0',
                                 'checked' => '0'),
                           $args);
    $id = lscf_nomalise_id($atts['id']);
    $hid = 'lscf_cb_' . $fieldCounter++;
    $val = floatval($atts['value']);
    $checked = (bool) intval($atts['checked']);
    $checked = ($checked ? 'checked="checked"' : '');

    lscf_shortcode_init();

    $o  = "<input type=\"checkbox\" id=\"{$hid}\" class=\"lscf_field {$id}\" " .
          " value=\"{$val}\" {$checked} \>";
    $o .= "<label for=\"{$hid}\">{$content}</label> ";

    return $o;
}
add_shortcode('lscf_checkbox', 'lscf_sc_checkbox');

/**
* Radio fields definition
* There is a radio group wrapper shortcode that set globals to make it easier
* to write the radio fields.
*/
$lscf_radio_name = '';
$lscf_radio_id = '';
$lscf_radio_name_counter = 0;
$lscf_radio_hid_counter = 0;

function lscf_radio_glob_reset() {
    global $lscf_radio_name, $lscf_radio_id;
    $lscf_radio_name = "";
    $lscf_radio_id = "";
}

function lscf_sc_radios($args, $content) {
    global $lscf_radio_name,
           $lscf_radio_id,
           $lscf_radio_name_counter;

    $atts = shortcode_atts(array('id' => '',
                                 'name' => $lscf_radio_name_counter++),
                           $args);
    $lscf_radio_id = $atts['id'];
    $lscf_radio_name = $atts['name'];

    $o = do_shortcode($content);

    lscf_radio_glob_reset();

    return $o;
}
add_shortcode('lscf_radio_group', 'lscf_sc_radios');

function lscf_sc_radio($args, $content) {
    global $lscf_radio_name, $lscf_radio_id, $lscf_radio_hid_counter;

    $atts = shortcode_atts(array('id' => $lscf_radio_id,
                                 'name' => $lscf_radio_name,
                                 'checked' => '0',
                                 'value' => '0'),
                           $args);

    $id = lscf_nomalise_id($atts['id']);
    $hid = 'lscf_rdo_' . $lscf_radio_hid_counter++;
    $name = $atts['name'];
    $name = "name=\"lscf_{$name}\"";
    $value = $atts['value'];
    $checked = (bool) intval($atts['checked']);
    $checked = $checked ? 'checked="checked"' : '';

    $o  = "<input id=\"{$hid}\" name=\"{$name}\" value=\"{$value}\" " .
          "type=\"radio\" class=\"lscf_field {$id}\" {$checked} />";
    $o .= "<label for=\"{$hid}\">{$content}</label>";

    return $o;
}
add_shortcode('lscf_radio', 'lscf_sc_radio');
