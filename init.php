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

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


add_action( 'gform_loaded', function() { 
  new GF_PLL(); 
}, 5 );


if( ! class_exists('GF_PLL') ) :

  class GF_PLL {
    
    public function __construct() {

      if(!class_exists('GFAPI') || !function_exists('pll_register_string')) return;

      $forms = GFAPI::get_forms();
      foreach ($forms as $form) {
        foreach ($form as $key => $value) {
          if(method_exists($this, 'register_' . $key)) {
            $func = 'register_' . $key;
            $this->$func($value, $form);
          }
        }
      }

    }

    private function register_title($value, $form) {
      pll_register_string('Title', $value, 'Gravity Form #' . $form['id']);
    }

    private function register_description($value, $form) {
      pll_register_string('Description', $value, 'Gravity Form #' . $form['id']);
    }

  }


endif;


?>

