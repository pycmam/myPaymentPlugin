<?php
/**
 * Данные для оплаты через Migom
 */
class myPaymentMigomActions extends myActions
{
    public function executeIndex()
    {
        $this->invoice = $this->getRoute()->getObject();
    }

    public function executeShow(sfWebRequest $request)
    {
        $this->invoice = $this->getRoute()->getObject();
    }
}