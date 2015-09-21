<?php

if(!class_exists('GF_PLL')) :

class GF_PLL {

  
  public function __construct() {

    $this->translatable_properties = array(
      'title', 
      'description', 
      'text', 
      'content', 
      'message', 
      'defaultValue', 
      'errorMessage',
      'placeholder'
    );

  }


  private function is_translatable($key) {

    return $key && in_array($key, $this->translatable_properties);

  }


  public function register_strings() {

    if(!class_exists('GFAPI') || !function_exists('pll_register_string')) return;

    $forms = GFAPI::get_forms();
    foreach ($forms as $form) {
      array_walk_recursive($form, function($value, $key, $form) {
        if($this->is_translatable($key)) {
          pll_register_string($key, $value, 'Form: "' . $form['title'] . '"');
        }
      }, $form);
    }

  }


  public function translate_strings($form) {

    if(function_exists('pll__')) {
      array_walk_recursive($form, function(&$value, $key) {
        if($this->is_translatable($key)) {
          $value = pll__($value);
        }
      });
    }

    return $form;
  }


}

endif;