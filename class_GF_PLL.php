<?php

if(!class_exists('GF_PLL')) :


class GF_PLL {


  private $whitelist;
  private $blacklist;
  private $registered_strings;
  private $form;
  
  
  public function __construct() {

    $this->whitelist = array(
      'title', 
      'description', 
      'text',
      'content',
      'message',
      'defaultValue', 
      'errorMessage',
      'placeholder',
      'label',
      'value'
    );

    $this->blacklist = array();

    $this->registered_strings = array();

  }


  private function is_translatable($key, $value) {

    return 
      $key && 
      in_array($key, $this->whitelist) &&
      is_string($value) &&
      !in_array($value, $this->registered_strings);

  }


  private function iterate_form(&$value, $key, $callback = null) {

    if(!$callback && is_callable($key)) {
      $callback = $key;
    }

    if(is_array($value) || is_object($value)) {
      foreach ($value as $new_key => &$new_value) {
        if(!(in_array($new_key, $this->blacklist) && !is_numeric($new_key))) {
          $this->iterate_form($new_value, $new_key, $callback);
        }
      }
    } else {
      if($this->is_translatable($key, $value)) {
        $callback($value, $key);
      }
    }

  }


  public function register_strings() {

    if(!class_exists('GFAPI') || !function_exists('pll_register_string')) return;

    $forms = GFAPI::get_forms();
    foreach ($forms as $form) {
      $this->form = $form;
      $this->iterate_form($form, function($value, $key) {
        $name = ''; // todo: suitable naming
        $group = "Form #{$this->form['id']}: {$this->form['title']}";
        pll_register_string($name, $value, $group);
        $this->registered_strings[] = $value;
      });
    }

  }


  public function translate_strings($form) {

    if(function_exists('pll__')) {
      $this->iterate_form($form, function(&$value, $key) {
        $value = pll__($value);
      });
    }

    return $form;

  }


}

endif;