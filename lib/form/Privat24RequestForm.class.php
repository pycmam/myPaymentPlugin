<?php
/**
 * Форма приват24-платежа
 */
class Privat24RequestForm extends sfForm
{
    /**
     * Constructor
     */
    public function __construct(Invoice $invoice)
    {
        sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url', 'Date'));

        $resultUrl = 'https://' . sfContext::getInstance()->getRequest()->getHost() . url_for('payment_privat24_result');

        $defaults = array(
            'amt'                => $invoice->getAmount(),
            'ccy'                => 'UAH',
            'merchant'           => sfConfig::get('app_privat24_merchant'),
            'order'              => $invoice->getTransactionId(),
            'details'            => $invoice->getDescription(),
            'pay_way'            => 'privat24',
            'return_url'         => $resultUrl,
            'server_url'         => $resultUrl,
        );

        parent::__construct($defaults);
    }

    /**
     * Config
     */
    public function configure()
    {
        $this->widgetSchema['amt']         = new sfWidgetFormInputHidden();
        $this->widgetSchema['ccy']         = new sfWidgetFormInputHidden();
        $this->widgetSchema['merchant']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['order']       = new sfWidgetFormInputHidden();
        $this->widgetSchema['details']     = new sfWidgetFormInputHidden();
        $this->widgetSchema['ext_details'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['pay_way']     = new sfWidgetFormInputHidden();
        $this->widgetSchema['return_url']  = new sfWidgetFormInputHidden();
        $this->widgetSchema['server_url']  = new sfWidgetFormInputHidden();

        $this->widgetSchema->setNameFormat('%s');
        $this->disableLocalCSRFProtection();
    }
}