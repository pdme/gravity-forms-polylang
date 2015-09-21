<?php
/*
Plugin Name: Gravity Forms Polylang
Plugin URI:  
Description: Add Gravity Forms form title, description, field labels, etc, to Polylang string translations
Version:     0.1
Author:      Philip Ebels
Author URI:  
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

if(!defined('ABSPATH')) exit;

if(!class_exists('GF_PLL_Initialize')) :

include 'gf_pll.php';

class GF_PLL_Initialize {
  public static function register_strings() {
    $gf_pll = new GF_PLL();
    $gf_pll->register_strings();
  }

  public static function translate_strings($form) {
    $gf_pll = new GF_PLL();
    return $gf_pll->translate_strings($form);
  }    
}

add_action('gform_loaded', array('GF_PLL_Initialize', 'register_strings'));
add_filter('gform_pre_render', array('GF_PLL_Initialize', 'translate_strings'));

endif;

?>