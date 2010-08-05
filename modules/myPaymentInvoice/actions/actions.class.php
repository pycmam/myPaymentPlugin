<?php
/**
 * Квитанция на оплату
 */
class myPaymentInvoiceActions extends myActions
{
    public function executeIndex()
    {
        $this->invoice = $this->getRoute()->getObject();
    }

    public function executeShow(sfWebRequest $request)
    {
        $this->invoice = $this->getRoute()->getObject();
        $country = $request->getParameter('country');

        $this->forward404Unless(in_array($country, array('ru', 'ua')));

        $this->setTemplate($country);
    }
}