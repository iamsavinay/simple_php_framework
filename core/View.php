<?php

class View {
  protected $_head, $_body, $_script,$_siteTitle = SITE_TITLE, $_outputBuffer, $_layout = DEFAULT_LAYOUT;

  public function render($viewname) {
    if(file_exists(ROOT.'/app/views/'.$viewname.'.php')) {
      include(ROOT.'/app/views/'.$viewname.'.php');
      include(ROOT.'/app/views/layouts/'.$this->_layout.'.php');
    } else {
      die('The View \"'.$viewname. '\" does not exists.');
    }
  }

  public function content($type) {
    if ($type == 'head') {
      return $this->_head;
    } elseif ($type == 'body') {
      return $this->_body;
    } elseif ($type == 'script') {
      return $this->_script;
    }
    return false;
  }

  public function start($type) {
    $this->_outputBuffer = $type;
    ob_start();
  }

  public function end() {
    if($this->_outputBuffer == 'head') {
      $this->_head = ob_get_clean();
    } elseif ($this->_outputBuffer == 'body') {
      $this->_body = ob_get_clean();
    } elseif($this->_outputBuffer == 'script') {
      $this->_script = ob_get_clean();
    }else {
      die("You must call the start method first.");
    }
  }

  public function siteTitle() {
    return $this->_siteTitle;
  }

  public function setSiteTitle($title) {
    $this->_siteTitle = $title;
  }

  public function setLayout($path) {
    $this->_layout = $path;
  }
}
