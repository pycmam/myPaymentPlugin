<?php
/**
 * Оплата через QIWI
 */
class myPaymentQiwiActions extends myPaymentActions
{
    /**
     * Детали платежа, форма отправки
     */
    public function executeIndex()
    {
        $this->invoice = $this->getRoute()->getObject();
    }

    public function executeCreate()
    {
        $invoice = $this->getRoute()->getObject();
        $invoice->setTransactionId(time() + rand(1,99) . $invoice->getId());
        $invoice->setPaymentSystem('qiwi');
        $invoice->save();

        $qiwi = QIWI::getInstance();

        try {
            $result = $qiwi->createBill(array(
                'phone'     => substr($invoice->getUser()->getProfile()->getMobilePhone(), -10, 10),
                'amount'    => Currency::convertByAbbr($invoice->getAmount(), 'RUR'),
                'comment'   => $invoice->getDescription(),
                /*
                'comment'   => sprintf('Бронирование %s, %s, с %s по %s, заявка №%d (%s)',
                    $order->getRealtyObject()->getTown()->getName(),
                    $order->getRealtyObject()->getName(),
                    $order->getArrivalDate(),
                    $order->getDepartureDate(),
                    $order->getId(),
                    $order->getUser()->getProfile()->getName()),
                */
                'txn-id'    => $invoice->getTransactionId(),
            ));

            if ($result) {
                $this->redirect('payment_qiwi_success');
            } else {
                $this->redirect('payment_qiwi_fail');
            }

        } catch(QIWIMortalCombatException $e) {
            $this->redirect('payment_qiwi_fail');
        }
    }


    /**
     * Result URL
     */
    public function executeResult(sfWebRequest $request)
    {
        $invoiceId = (int) $request->getParameter('LMI_PAYMENT_NO');

        $invoice = Doctrine::getTable('Invoice')->findOneById($invoiceId);

        if (! $invoice) {
            return $this->renderText('INVOICE NOT FOUND');
            return sfView::NONE;
        }

        return sfView::NONE;
    }
}