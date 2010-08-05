<?php
/**
 * Оплата через LiqPay
 */
class myPaymentLiqpayActions extends myPaymentActions
{
    public function executeIndex()
    {
        $this->invoice = $this->getRoute()->getObject();
        $this->invoice->setPaymentSystem('liqpay');
        $this->invoice->save();
        $this->form = new LiqpayRequestForm($this->invoice);
    }

    public function executeResult(sfWebRequest $request)
    {
        $invoiceId = (int) $request->getParameter('order_id');

        $invoice = Doctrine::getTable('Invoice')->findOneById(intval($orderId));

        $this->forward404Unless($invoice, 'Invoice not found.');

        // Оповещение о платеже
        $form = new LiqpayResultForm($invoice);
        $form->bind($params = $request->getPostParameters());
        if ($form->isValid()) {
            $this->status = $request->getParameter('status');
            if ($this->status == 'success') {
                $this->complete($invoice, $params);
            }
        } else {
            $this->status = 'failure';
        }
    }
}