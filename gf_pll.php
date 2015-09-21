<?php

if(!class_exists('GF_PLL')) :


class GF_PLL {


  private $translatable_properties;
  
  
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


  private function iterate($value, $key, $callback = null) {

    if(!$callback && is_callable($key)) $callback = $key;

    if(is_array($value) || is_object($value)) {
      foreach ($value as $key => $new_value) {
        $this->iterate($new_value, $key, $callback);
      }
    } else {
      $callback($value, $key);
    }

  }


  public function register_strings() {

    if(!class_exists('GFAPI') || !function_exists('pll_register_string')) return;

    $forms = GFAPI::get_forms();
    foreach ($forms as $form) {
      $this->iterate($form, function($value, $key) {
        if($this->is_translatable($key)) {
          pll_register_string($key, $value, 'Form');
        }
      });
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