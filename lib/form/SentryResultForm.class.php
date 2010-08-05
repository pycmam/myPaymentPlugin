<?php
/**
 * Форма ответа от Sentry
 */
class SentryResultForm extends sfForm
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
        $this->widgetSchema['AcqID']                  = new sfWidgetFormInputHidden();
        $this->widgetSchema['MerID']                  = new sfWidgetFormInputHidden();
        $this->widgetSchema['OrderID']                = new sfWidgetFormInputHidden();
        $this->widgetSchema['Signature']              = new sfWidgetFormInputHidden();
        $this->widgetSchema['ECI']                    = new sfWidgetFormInputHidden();
        $this->widgetSchema['IP']                     = new sfWidgetFormInputHidden();
        $this->widgetSchema['CountryBIN']             = new sfWidgetFormInputHidden();
        $this->widgetSchema['CountryIP']              = new sfWidgetFormInputHidden();
        $this->widgetSchema['ONUS']                   = new sfWidgetFormInputHidden();

        $this->widgetSchema['Time']                   = new sfWidgetFormInputHidden();
        $this->widgetSchema['OTPPhone']               = new sfWidgetFormInputHidden();
        $this->widgetSchema['PhoneCountry']           = new sfWidgetFormInputHidden();
        $this->widgetSchema['Signature2']             = new sfWidgetFormInputHidden();
        $this->widgetSchema['ResponseCode']           = new sfWidgetFormInputHidden();
        $this->widgetSchema['ReasonCode']             = new sfWidgetFormInputHidden();
        $this->widgetSchema['ReasonCodeDesc']         = new sfWidgetFormInputHidden();
        $this->widgetSchema['ReferenceNo']            = new sfWidgetFormInputHidden();
        $this->widgetSchema['PaddedCardNo']           = new sfWidgetFormInputHidden();
        $this->widgetSchema['AuthCode']               = new sfWidgetFormInputHidden();


        $this->validatorSchema['AcqID']                  = new sfValidatorRegex(array(
            'pattern' => '/^414963$/',
        ));

        $this->validatorSchema['MerID']                  = new sfValidatorRegex(array(
            'pattern' => sprintf('/^%s$/', sfConfig::get('app_sentry_merchant')),
        ));
        $this->validatorSchema['OrderID']                = new sfValidatorRegex(array(
            'pattern' => sprintf('/^%s$/', $this->invoice->getTransactionId()),
        ));
        $this->validatorSchema['Signature']              = new sfValidatorPass();
        $this->validatorSchema['ECI']                    = new sfValidatorPass();
        $this->validatorSchema['IP']                     = new sfValidatorPass();
        $this->validatorSchema['CountryBIN']             = new sfValidatorPass();
        $this->validatorSchema['CountryIP']              = new sfValidatorPass();
        $this->validatorSchema['ONUS']                   = new sfValidatorPass();

        $this->validatorSchema['Time']                   = new sfValidatorPass();
        $this->validatorSchema['OTPPhone']               = new sfValidatorPass();
        $this->validatorSchema['PhoneCountry']           = new sfValidatorPass();
        $this->validatorSchema['Signature2']             = new sfValidatorPass();

        $this->validatorSchema['ResponseCode']           = new sfValidatorRegex(array(
            'pattern' => '/^1$/',
        ));
        $this->validatorSchema['ReasonCode']             = new sfValidatorRegex(array(
            'pattern' => '/^1$/',
        ));

        $this->validatorSchema['ReasonCodeDesc']         = new sfValidatorPass();
        $this->validatorSchema['ReferenceNo']            = new sfValidatorPass();
        $this->validatorSchema['PaddedCardNo']           = new sfValidatorPass();
        $this->validatorSchema['AuthCode']               = new sfValidatorPass();

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
        $sign = base64_encode(mhash(MHASH_SHA1,
            sfConfig::get('app_sentry_password') .
            $values['MerID'] .
            $values['AcqID'] .
            $values['OrderID']
        ));

        if ($sign === @$values['Signature']) {
            return $sign;
        }

        throw new sfValidatorError($validator, 'Invalid.');
    }
}