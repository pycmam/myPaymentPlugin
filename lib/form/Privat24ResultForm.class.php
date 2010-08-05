<?php
/**
 * Форма приват24-платежа
 */
class Privat24ResultForm extends sfForm
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
        $this->widgetSchema['amt']         = new sfWidgetFormInputHidden();
        $this->widgetSchema['ccy']         = new sfWidgetFormInputHidden();
        $this->widgetSchema['merchant']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['order']       = new sfWidgetFormInputHidden();
        $this->widgetSchema['details']     = new sfWidgetFormInputHidden();
        $this->widgetSchema['ext_details'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['pay_way']     = new sfWidgetFormInputHidden();
        $this->widgetSchema['state']       = new sfWidgetFormInputHidden();
        $this->widgetSchema['date']        = new sfWidgetFormInputHidden();
        $this->widgetSchema['ref']         = new sfWidgetFormInputHidden();
        $this->widgetSchema['sender_phone']  = new sfWidgetFormInputHidden();
        $this->widgetSchema['signature']   = new sfWidgetFormInputHidden();

        $this->validatorSchema['amt'] = new sfValidatorRegex(array(
            'pattern' => sprintf('/^%s$/', $this->invoice->getAmount()),
        ));
        $this->validatorSchema['amt'] = new sfValidatorRegex(array(
            'pattern' => '/^UAH$/',
        ));
        $this->validatorSchema['merchant'] = new sfValidatorRegex(array(
            'pattern' => sprintf('/^%s$/', sfConfig::get('app_privat24_merchant')),
        ));
        $this->validatorSchema['order'] = new sfValidatorRegex(array(
            'pattern' => sprintf('/^%s$/', $this->invoice->getTransactionId()),
        ));
        $this->validatorSchema['details'] = new sfValidatorPass();
        $this->validatorSchema['ext_details'] = new sfValidatorPass();
        $this->validatorSchema['pay_way'] = new sfValidatorPass();
        $this->validatorSchema['state'] = new sfValidatorRegex(array(
            'pattern' => '/^ok$/i',
        ));
        $this->validatorSchema['date'] = new sfValidatorPass();
        $this->validatorSchema['ref'] = new sfValidatorPass();
        $this->validatorSchema['sender_phone'] = new sfValidatorPass();
        $this->validatorSchema['signature'] = new sfValidatorPass();

        $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
            'callback' => array($this, 'validateHash'),
        )));

        $this->widgetSchema->setNameFormat('%s');
        $this->disableLocalCSRFProtection();
    }


    /**
     * Проверка подписи платежа
     */
    public function validateHash($validator, $values)
    {
        $sign = sha1(md5(
            'amt='.$values['amt'].'&'.
            'ccy='.$values['ccy'].'&'.
            'details='.$values['details'].'&'.
            'ext_details='.$values['ext_details'].'&'.
            'pay_way='.$values['pay_way'].'&'.
            'order='.$values['order'].'&'.
            'merchant='.$values['merchant'].'&'.
            'state='.$values['state'].'&'.
            'date='.$values['date'].'&'.
            'ref='.$values['ref'].'&'.
            'sender_phone='.$values['sender_phone']));

        if ($sign === @$values['signature']) {
            return $sign;
        }

        throw new sfValidatorError($validator, 'Invalid.');
    }
}