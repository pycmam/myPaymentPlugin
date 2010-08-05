<?php

class myPaymentActions extends sfActions
{
    public function executeIndex(sfWebRequest $request)
    {
        $this->invoice = $this->getRoute()->getObject();

        $this->form = new PayForm($this->invoice);

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {
                $systems = sfConfig::get('app_payment_systems', array());
                $name = $this->form->getValue('payment_system');

                if (isset($systems[$name])) {
                    $this->redirect($systems[$name]['route'], $this->invoice);
                } else {
                    $this->forward404('Undefined payment system ' . $system);
                }
            }
        }
    }
}