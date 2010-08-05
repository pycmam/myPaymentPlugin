<?php
/**
 * Оплата через "Единую кассу"
 */
class myPaymentW1Actions extends myPaymentActions
{
    /**
     * Детали платежа, форма отправки
     */
    public function executeIndex()
    {
        $this->invoice = $this->getRoute()->getObject();
        $this->form = new W1RequestForm($this->invoice);
    }


    /**
     * Result URL
     */
    public function executeResult(sfWebRequest $request)
    {
        $invoiceId = (int) $request->getParameter('WMI_PAYMENT_NO');

        $invoice = Doctrine::getTable('Invoice')->findOneById($invoiceId);

        if (! $invoice) {
            return $this->renderText('WMI_RESULT=RETRY&WMI_DESCRIPTION=INVOICE NOT FOUND');
            return sfView::NONE;
        }

        $form = new W1ResultForm($invoice);
        $form->bind($params = $request->getPostParameters());
        if ($form->isValid()) {
            $this->complete($invoice, $params);

            return $this->renderText('WMI_RESULT=OK');
        }

        return $this->renderText('WMI_RESULT=RETRY&WMI_DESCRIPTION=INVALID FORM');
    }
}