<?php
/**
 * Форма выбора платежной системы
 */
class PayForm extends InvoiceForm
{
    public function configure()
    {
        $this->useFields(array('payment_system'));

        $this->setWidget('payment_system', new myWidgetFormPaymentSystems());
        $this->setValidator('payment_system', new sfValidatorChoice(array(
            'choices' => array_keys(sfConfig::get('app_payment_systems')),
        )));

        $this->widgetSchema->setNameFormat('pay[%s]');
    }
}