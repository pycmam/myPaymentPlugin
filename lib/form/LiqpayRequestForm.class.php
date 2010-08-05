<?php
/**
 * Форма запроса к Liqpay
 */
class LiqpayRequestForm extends sfForm
{
    /**
     * Constructor
     */
    public function __construct(Invoice $invoice)
    {
        sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url', 'Date'));

        $resultUrl = 'https://' . sfContext::getInstance()->getRequest()->getHost() . url_for('payment_liqpay_result');

        $defaults = array(
            'version'        => '1.1',
            'merchant_id'    => sfConfig::get('app_liqpay_merchant'),
            'amount'         => $invoice->getAmount(),
            'currency'       => 'UAH',
            'order_id'       => $invoice->getId(),
            'description'    => $invoice->getDescription(),
            'result_url'     => $resultUrl,
            'server_url'     => $resultUrl,
        );

        parent::__construct($defaults);
    }

    /**
     * Config
     */
    public function configure()
    {
        $this->widgetSchema['version']     = new sfWidgetFormInputHidden();
        $this->widgetSchema['merchant_id'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['currency']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['amount']      = new sfWidgetFormInputHidden();
        $this->widgetSchema['description'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['order_id']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['result_url']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['server_url']    = new sfWidgetFormInputHidden();

        $this->widgetSchema->setNameFormat('%s');
        $this->disableLocalCSRFProtection();
    }
}