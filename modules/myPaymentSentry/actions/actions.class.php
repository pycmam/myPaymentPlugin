<?php
/**
 * Оплата через Sentry
 */
class myPaymentSentryActions extends myPaymentActions
{
    public function executeIndex()
    {
        $this->invoice = $this->getRoute()->getObject();

        // Установим новый transaction_id
        $this->invoice->setTransactionId(time() + rand(1,99));
        $this->invoice->setPaymentSystem('sentry');
        $this->invoice->save();

        $this->form = new SentryRequestForm($this->invoice);
    }

    public function executeResult(sfWebRequest $request)
    {
        $transactionId = (int) $request->getParameter('OrderID');

        $invoice = Doctrine::getTable('Invoice')->findOneByTransactionId($transactionId);

        $this->forward404Unless($invoice, 'Invoice not found.');

        // Оповещение о платеже
        $form = new SentryResultForm($invoice);
        $form->bind($params = $request->getPostParameters());
        if ($form->isValid()) {
            $this->complete($invoice, $params);
        }

        $this->responseCode = @$params['ResponseCode'];
        $this->reasonCode = @$params['ReasonCode'];
        $this->reasonCodeDesc = @$params['ReasonCodeDesc'];

    }
}