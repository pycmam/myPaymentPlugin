<?php
/**
 * Форма ответа от Liqpay
 */
class LiqpayResultForm extends sfForm
{
    protected $invoice = null;

    /**
     * Constructor
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;

        parent::__construct();
    }

    /**
     * Config
     */
    public function configure()
    {
        $this->widgetSchema['version']      = new sfWidgetFormInputHidden();
        $this->widgetSchema['action_name']  = new sfWidgetFormInputHidden();
        $this->widgetSchema['sender_phone'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['merchant_id']  = new sfWidgetFormInputHidden();
        $this->widgetSchema['currency']     = new sfWidgetFormInputHidden();
        $this->widgetSchema['amount']       = new sfWidgetFormInputHidden();
        $this->widgetSchema['order_id']     = new sfWidgetFormInputHidden();
        $this->widgetSchema['transaction_id'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['status']       = new sfWidgetFormInputHidden();
        $this->widgetSchema['code']         = new sfWidgetFormInputHidden();
        $this->widgetSchema['signature']    = new sfWidgetFormInputHidden();

        $this->validatorSchema['version'] = new sfValidatorRegex(array(
            'pattern' => '/^1\.1$/',
        ));

        $this->validatorSchema['action_name'] = new sfValidatorPass();
        $this->validatorSchema['sender_phone'] = new sfValidatorPass();
        $this->validatorSchema['status'] = new sfValidatorPass();
        $this->validatorSchema['code'] = new sfValidatorPass();
        $this->validatorSchema['signature'] = new sfValidatorPass();
        $this->validatorSchema['transaction_id'] = new sfValidatorPass();

        $this->validatorSchema['merchant_id'] = new sfValidatorRegex(array(
            'pattern' => sprintf('/^%s$/', sfConfig::get('app_liqpay_merchant')),
        ));

        $this->validatorSchema['order_id'] = new sfValidatorRegex(array(
            'pattern' => sprintf('/^%s$/', $this->invoice->getId()),
        ));

        $this->validatorSchema['currency'] = new sfValidatorRegex(array(
            'pattern' => '/^UAH$/',
        ));

        $this->validatorSchema['amount'] = new sfValidatorRegex(array(
            'pattern' => sprintf('/^%s$/', str_replace('.', '\.',
                sprintf('%01.2f', $this->invoice->getAmount()))),
        ));

        $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
            'callback' => array($this, 'validateHash'),
        )));

        $this->validatorSchema->setOption('allow_extra_fields', true);
        $this->disableLocalCSRFProtection();
    }


    /**
     * Проверка подписи платежа
     */
    public function validateHash($validator, $values)
    {
        $sign = base64_encode(sha1($str = '|'.
            $values['version'].'|'.
            sfConfig::get('app_liqpay_password').'|'.
            $values['action_name'].'|'.
            $values['sender_phone'].'|'.
            $values['merchant_id'].'|'.
            $values['amount'].'|'.
            $values['currency'].'|'.
            $values['order_id'].'|'.
            $values['transaction_id'].'|'.
            $values['status'].'|'.
            $values['code'].'|', 1));

        if ($sign === @$values['signature']) {
            return $sign;
        }

        throw new sfValidatorError($validator, 'Signature invalid.');
    }
}