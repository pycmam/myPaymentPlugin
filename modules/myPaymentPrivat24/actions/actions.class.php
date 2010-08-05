<?php
/**
 * Оплата через Приват 24
 */
class myPaymentPrivat24Actions extends myActions
{
    public function executeIndex()
    {
        $this->invoice = $this->getRoute()->getObject();

        // Установим новый transaction_id
        $this->invoice->setTransactionId(time() + rand(1,99));
        $this->invoice->setPaymentSystem('privat24');
        $this->invoice->save();

        $this->form = new Privat24RequestForm($this->invoice);
    }

    public function executeResult(sfWebRequest $request)
    {
        $payment = explode('&', $request->getParameter('payment'));
        $params = array(
            'signature' => $request->getParameter('signature'),
        );
        foreach($payment as $var) {
            list($key, $value) = explode('=', $var, 2);
            $params[$key] = $value;
        }

        $transactionId = (int) $params['order'];
        $invoice = Doctrine::getTable('Invoice')->findOneByTransactionId($transactionId);

        $this->forward404Unless($invoice, 'Invoice not found.');

        $this->errors = array();

        // Оповещение о платеже
        $form = new Privat24ResultForm($invoice);
        $form->bind($params);
        if ($form->isValid()) {
            $this->complete($invoice, $params);
            $this->status = 'ok';
        } else {
            foreach($form->getErrorSchema() as $name => $error) {
                $this->errors[$name] = $error->getMessage();
            }

            $this->status = 'fail';
        }

    }
}