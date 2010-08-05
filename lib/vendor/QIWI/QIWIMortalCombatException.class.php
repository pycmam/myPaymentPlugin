<?php

class QIWIMortalCombatException extends Exception{
  var $fatality = FALSE;
  var $code = 0;
  function __construct($code, $fatality) {
    $this->code = $code;
    $this->fatality = $fatality;
  }
}