<?php
/**
 * Форма webmoney-платежа
 */
class WebmoneyRequestForm extends sfForm
{
    protected
        $invoice = null,
        $wallets = null;

    /**
     * Constructor
     */
    public function __construct(Invoice $invoice, array $wallets)
    {
        $this->invoice = $invoice;
        $this->wallets = $wallets;

        $defaults = array(
            'LMI_SIM_MODE'       => sfConfig::get('app_webmoney_sim_mode'),
            'LMI_PAYMENT_NO'     => $invoice->getId(),
            'LMI_PAYMENT_DESC_BASE64' => base64_encode($invoice->getDescription()),
        );

        parent::__construct($defaults);
    }

    /**
     * Config
     */
    public function configure()
    {
        $choices = array();
        foreach ($this->wallets as $purse => $wallet) {
            $choices[$purse] = sprintf('Webmoney %s (%s)', $wallet['name'], $wallet['amount']);
        }

        $this->widgetSchema['LMI_PAYEE_PURSE']         = new sfWidgetFormChoice(array('choices' => $choices));
        $this->widgetSchema['LMI_PAYMENT_NO']          = new sfWidgetFormInputHidden();
        $this->widgetSchema['LMI_PAYMENT_AMOUNT']      = new sfWidgetFormInputHidden();
        $this->widgetSchema['LMI_PAYMENT_DESC_BASE64'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['LMI_SIM_MODE']            = new sfWidgetFormInputHidden();

        $this->widgetSchema->setNameFormat('%s');
        $this->disableLocalCSRFProtection();
    }
}