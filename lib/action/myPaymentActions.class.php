<?php

/**
 * myPaymentActions
 */
class myPaymentActions extends sfActions
{
    protected function complete(Invoice $invoice, $transactionData = null)
    {
        $invoice->doPay($transactionData);
    }

    /**
     * Success URL
     */
    public function executeSuccess(sfWebRequest $request)
    {
    }


    /**
     * Fail URL
     */
    public function executeFail(sfWebRequest $request)
    {
    }
}
