<?php
/**
 * Оплата через Webmoney
 */
class myPaymentWebmoneyActions extends myPaymentActions
{
    /**
     * Детали платежа, форма отправки
     */
    public function executeIndex()
    {
        $this->invoice = $this->getRoute()->getObject();
        $this->wallets = $this->getWallets($this->invoice);
        $this->form = new WebmoneyRequestForm($this->invoice, $this->wallets);
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

        $wallets = $this->getWallets($invoice);

        // Предварительный запрос
        if ($request->getParameter('LMI_PREREQUEST')) {
            $form = new WebmoneyPreResultForm($invoice, $wallets);
            $form->bind($params = $request->getPostParameters());

            if ($form->isValid()) {
                return $this->renderText('YES');
            } else {
                return $this->renderText('INVALID');
            }
            return sfView::NONE;
        }

        // Оповещение о платеже
        $form = new WebmoneyResultForm($invoice, $wallets);
        $form->bind($params = $request->getPostParameters());
        if ($form->isValid()) {
            $this->complete($invoice, $params);
            return $this->renderText('YES');
        }

        return sfView::NONE;
    }


    /**
     * Возвращает доступные для оплаты кошельки
     */
    protected function getWallets(Invoice $invoice)
    {
        $wallets = array();
        foreach (sfConfig::get('app_webmoney_wallet') as $name => $config) {
            $amount = Currency::convertByAbbr($invoice->getAmount(), $config['currency']);
            if (false !== $amount) {
                $wallets[$config['purse']]['amount'] = sprintf('%01.2f', $amount);
                $wallets[$config['purse']]['name'] = $name;
            }
        }

        return $wallets;
    }
}