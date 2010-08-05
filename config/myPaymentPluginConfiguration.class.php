<?php

require_once dirname(__FILE__) . '/../lib/vendor/QIWI/QIWI.class.php';
require_once dirname(__FILE__) . '/../lib/vendor/QIWI/QIWICurlRequester.class.php';
require_once dirname(__FILE__) . '/../lib/vendor/QIWI/QIWIMcryptEncrypter.class.php';
require_once dirname(__FILE__) . '/../lib/vendor/QIWI/QIWIMortalCombatException.class.php';

class myPaymentPluginConfiguration extends sfPluginConfiguration
{
    public function initialize()
    {
    }
}