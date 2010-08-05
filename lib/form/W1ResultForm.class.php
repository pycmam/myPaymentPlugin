<?php
/**
 * Форма ответа от W1
 */
class W1ResultForm extends sfForm
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
        $this->widgetSchema['WMI_AUTO_ACCEPT']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_CREATE_DATE']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_LAST_NOTIFY_DATE']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_NOTIFY_COUNT']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_ORDER_ID']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_PAYMENT_TYPE']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_TO_USER_ID']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_UPDATE_DATE']    = new sfWidgetFormInputHidden();

        $this->widgetSchema['WMI_MERCHANT_ID']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_PAYMENT_AMOUNT'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_PAYMENT_NO'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_CURRENCY_ID']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_DESCRIPTION']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_EXPIRED_DATE']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_SUCCESS_URL']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_FAIL_URL']       = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_ORDER_STATE']      = new sfWidgetFormInputHidden();
        $this->widgetSchema['WMI_SIGNATURE']      = new sfWidgetFormInputHidden();

        $this->validatorSchema['WMI_AUTO_ACCEPT'] = new sfValidatorPass();
        $this->validatorSchema['WMI_CREATE_DATE'] = new sfValidatorPass();
        $this->validatorSchema['WMI_LAST_NOTIFY_DATE'] = new sfValidatorPass();
        $this->validatorSchema['WMI_NOTIFY_COUNT'] = new sfValidatorPass();
        $this->validatorSchema['WMI_ORDER_ID'] = new sfValidatorPass();
        $this->validatorSchema['WMI_PAYMENT_TYPE'] = new sfValidatorPass();
        $this->validatorSchema['WMI_TO_USER_ID'] = new sfValidatorPass();
        $this->validatorSchema['WMI_UPDATE_DATE'] = new sfValidatorPass();

        $this->validatorSchema['WMI_MERCHANT_ID'] = new sfValidatorRegex(array(
            'pattern' => sprintf('/^%s$/', sfConfig::get('app_w1_merchant')),
        ));
        $this->validatorSchema['WMI_PAYMENT_AMOUNT'] = new sfValidatorRegex(array(
            'pattern' => sprintf('/^%s$/', str_replace('.', '\.',
                sprintf('%01.2f', $this->invoice->getAmount()))),
        ));
        $this->validatorSchema['WMI_PAYMENT_NO'] = new sfValidatorRegex(array(
            'pattern' => sprintf('/^%d$/', $this->invoice->getId()),
        ));
        $this->validatorSchema['WMI_CURRENCY_ID'] = new sfValidatorRegex(array(
            'pattern' => '/^980$/',
        ));
        $this->validatorSchema['WMI_DESCRIPTION'] = new sfValidatorPass();
        $this->validatorSchema['WMI_EXPIRED_DATE'] = new sfValidatorPass();
        $this->validatorSchema['WMI_SUCCESS_URL'] = new sfValidatorPass();
        $this->validatorSchema['WMI_FAIL_URL'] = new sfValidatorPass();
        $this->validatorSchema['WMI_ORDER_STATE'] = new sfValidatorRegex(array(
            'pattern' => '/^Accepted$/',
        ));
        $this->validatorSchema['WMI_SIGNATURE'] = new sfValidatorPass();

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
        $origin = $values['WMI_SIGNATURE'];

        unset($values['WMI_SIGNATURE']);

        ksort($values, SORT_STRING);

        $sign  = '';
        foreach($values as $name => $value) {
            $sign .= $value;
        }

        $sign = base64_encode(pack("H*", md5($sign . sfConfig::get('app_w1_secret_key'))));

        if ($sign === $origin) {
            return $values;
        }

        throw new sfValidatorError($validator, 'Invalid signature.');
    }
}