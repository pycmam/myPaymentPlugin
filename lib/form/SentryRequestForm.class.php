<?php
/**
 * Форма запроса к Sentry
 */
class SentryRequestForm extends sfForm
{
    /**
     * Constructor
     */
    public function __construct(Invoice $invoice)
    {
        sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url', 'Number'));

        $amount = sprintf('%01.2f', $invoice->getAmount());
        while(strlen($amount) < 13) {
            $amount = '0' . $amount;
        }

        $resultUrl = 'https://' . sfContext::getInstance()->getRequest()->getHost() . url_for('payment_sentry_result');

        $defaults = array(
            'version'        => '1.0.0',
            'MerID'          => sfConfig::get('app_sentry_merchant'),
            'MerRespURL'     => $resultUrl,
            'MerRespURL2'    => $resultUrl,
            'AcqID'          => 414963,
            'PurchaseAmt'    => str_replace('.', '', $amount),
            'PurchaseCurrency' => 980,
            'PurchaseCurrencyExponent' => 2,
            'SignatureMethod' => 'SHA1',
            'OrderID'        => $invoice->getTransactionId(),
        );

        $defaults['Signature'] = $this->createSign($defaults);

        parent::__construct($defaults);
    }

    /**
     * Config
     */
    public function configure()
    {
        $this->widgetSchema['version']                  = new sfWidgetFormInputHidden();
        $this->widgetSchema['MerID']                    = new sfWidgetFormInputHidden();
        $this->widgetSchema['MerRespURL']               = new sfWidgetFormInputHidden();
        $this->widgetSchema['MerRespURL2']              = new sfWidgetFormInputHidden();
        $this->widgetSchema['AcqID']                    = new sfWidgetFormInputHidden();
        $this->widgetSchema['PurchaseAmt']              = new sfWidgetFormInputHidden();
        $this->widgetSchema['PurchaseCurrency']         = new sfWidgetFormInputHidden();
        $this->widgetSchema['OrderID']                  = new sfWidgetFormInputHidden();
        $this->widgetSchema['PurchaseCurrencyExponent'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['SignatureMethod']          = new sfWidgetFormInputHidden();
        $this->widgetSchema['Signature']                = new sfWidgetFormInputHidden();

        $this->widgetSchema->setNameFormat('%s');
        $this->disableLocalCSRFProtection();
    }


    /**
     * Подпись запроса
     */
    protected function createSign(array $data)
    {
        function hexbin($temp) {
           $data="";
           $len = strlen($temp);
           for ($i=0;$i<$len;$i+=2) $data.=chr(hexdec(substr($temp,$i,2)));
           return $data;
        }

        $sign = base64_encode(hexbin(sha1(
            sfConfig::get('app_sentry_password') .
            $data['MerID'] .
            $data['AcqID'] .
            $data['OrderID'] .
            $data['PurchaseAmt'] .
            $data['PurchaseCurrency']
        )));

        return $sign;
    }
}