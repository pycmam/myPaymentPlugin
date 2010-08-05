<?php
/**
 * Форма w1-платежа
 */
class W1RequestForm extends sfForm
{
    /**
     * Constructor
     */
    public function __construct(Invoice $invoice)
    {
        sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url'));

        $defaults = array(
            'WMI_MERCHANT_ID'    => sfConfig::get('app_w1_merchant'),
            'WMI_PAYMENT_AMOUNT' => sprintf('%01.2f', $invoice->getAmount()),
            'WMI_CURRENCY_ID'    => 980, // UAH ISO 4217
            'WMI_PAYMENT_NO'     => $invoice->getId(),
            'WMI_DESCRIPTION'    => $invoice->geDescription(),
            'WMI_SUCCESS_URL'    => url_for('payment_w1_success', array(), true),
            'WMI_FAIL_URL'       => url_for('payment_w1_fail', array(), true),
            'WMI_PTENABLED'      => 'CashTerminalUAH',
        );

        $defaults['WMI_SIGNATURE'] = $this->createSign($defaults);

        parent::__construct($defaults);
    }

    /**
     * Config
     */
    public function configure()
    {
        $this->widgetSchema['WMI_MERCHANT_ID']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_PAYMENT_AMOUNT'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_PAYMENT_NO'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_CURRENCY_ID']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_DESCRIPTION']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_SUCCESS_URL']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_PTENABLED']      = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_FAIL_URL']       = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_SIGNATURE']      = new sfWidgetFormInputHidden();

        $this->widgetSchema->setNameFormat('%s');
        $this->disableLocalCSRFProtection();
    }

    /**
     * Цифровая подпись
     *
     * @param array $data
     */
    protected function createSign(array $data)
    {
        ksort($data, SORT_STRING);

        $sign = '';
        foreach($data as $key => $value) {
            $sign .= iconv("utf-8", "windows-1251", $value);
        }

        return base64_encode(pack("H*", md5($sign . sfConfig::get('app_w1_secret_key'))));
    }
}