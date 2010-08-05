<?php
/**
 * Форма оповещения о платеже
 */
class WebmoneyResultForm extends WebmoneyPreResultForm
{
    /**
     * Config
     */
    public function configure()
    {
        parent::configure();

        $this->widgetSchema['LMI_MODE']           = new sfWidgetFormInputHidden();
        $this->widgetSchema['LMI_SYS_INVS_NO']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['LMI_SYS_TRANS_NO']   = new sfWidgetFormInputHidden();
        $this->widgetSchema['LMI_SYS_TRANS_DATE'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['LMI_PAYER_PURSE']    = new sfWidgetFormInputHidden();
        $this->widgetSchema['LMI_PAYER_WM']       = new sfWidgetFormInputHidden();
        $this->widgetSchema['LMI_HASH']           = new sfWidgetFormInputHidden();
        $this->widgetSchema['LMI_PAYMENT_DESC']   = new sfWidgetFormInputHidden();

        $this->validatorSchema['LMI_HASH']           = new sfValidatorPass();
        $this->validatorSchema['LMI_MODE']           = new sfValidatorPass();
        $this->validatorSchema['LMI_SYS_INVS_NO']    = new sfValidatorPass();
        $this->validatorSchema['LMI_SYS_TRANS_NO']   = new sfValidatorPass();
        $this->validatorSchema['LMI_SYS_TRANS_DATE'] = new sfValidatorPass();
        $this->validatorSchema['LMI_PAYER_PURSE']    = new sfValidatorPass();
        $this->validatorSchema['LMI_PAYER_WM']       = new sfValidatorPass();
        $this->validatorSchema['LMI_PAYMENT_DESC']   = new sfValidatorPass();

        $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
            'callback' => array($this, 'validateHash'),
        )));
    }

    /**
     * Проверка подписи платежа
     */
    public function validateHash($validator, $values)
    {
        $sign = strtoupper(md5(
            $values['LMI_PAYEE_PURSE']
            . $values['LMI_PAYMENT_AMOUNT']
            . $values['LMI_PAYMENT_NO']
            . $values['LMI_MODE']
            . $values['LMI_SYS_INVS_NO']
            . $values['LMI_SYS_TRANS_NO']
            . $values['LMI_SYS_TRANS_DATE']
            . sfConfig::get('app_webmoney_secret_key')
            . $values['LMI_PAYER_PURSE']
            . $values['LMI_PAYER_WM']
        ));

        if ($sign === $values['LMI_HASH']) {
            return $sign;
        }

        throw new sfValidatorError($validator, 'Invalid hash.');
    }
}