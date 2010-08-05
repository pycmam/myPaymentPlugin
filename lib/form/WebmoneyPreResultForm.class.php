<?php
/**
 * Форма предварительного запроса
 */
class WebmoneyPreResultForm extends BaseForm
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

        parent::__construct();
    }

    /**
     * Config
     */
    public function configure()
    {
        $this->widgetSchema['LMI_PAYEE_PURSE']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['LMI_PAYMENT_AMOUNT'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['LMI_PAYMENT_NO']     = new sfWidgetFormInputHidden();

        $this->validatorSchema['LMI_PAYEE_PURSE']    = new sfValidatorChoice(array(
            'choices' => array_keys($this->wallets),
        ));

        $this->validatorSchema['LMI_PAYMENT_AMOUNT'] = new sfValidatorPass();

        $this->validatorSchema['LMI_PAYMENT_NO']     = new sfValidatorRegex(array(
            'pattern' => sprintf('/^%d$/', $this->invoice->getId()),
        ));

        $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
            'callback' => array($this, 'validateAmount'),
        )));

        $this->validatorSchema->setOption('allow_extra_fields', true);
        $this->disableLocalCSRFProtection();
    }


    /**
     * Проверка суммы платежа
     */
    public function validateAmount($validator, $values)
    {
        $amount = $this->wallets[$values['LMI_PAYEE_PURSE']]['amount'];

        if ($amount == $values['LMI_PAYMENT_AMOUNT']) {
            return $values;
        }

        throw new sfValidatorError($validator, 'Invalid amount.');
    }

}