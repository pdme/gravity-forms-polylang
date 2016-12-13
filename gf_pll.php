<?php
/*
Plugin Name: Integrate Gravity Forms + Polylang
Plugin URI:  https://github.com/pdme/gravity-forms-polylang
Description: Add form titles, descriptions, field labels, etc, to Polylang string translations
Version:     0.3
Author:      Philip Ebels
Author URI:  https://github.com/pdme
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

if(!defined('ABSPATH')) exit;

if(!class_exists('GF_PLL_Initialize')) :

include 'class_GF_PLL.php';

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

add_action('init', array('GF_PLL_Initialize', 'register_strings'), 100);
add_filter('gform_pre_render', array('GF_PLL_Initialize', 'translate_strings'));
add_filter('gform_pre_process', array('GF_PLL_Initialize', 'translate_strings'));

endif;

?>