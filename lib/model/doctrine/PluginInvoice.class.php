<?php

/**
 * Абстрактный счет
 */
abstract class PluginInvoice extends BaseInvoice
{
    public function doPay($transactionData = null)
    {
        $this->setPaidAt(date('c'));
        $this->setIsPaid(true);
        $this->save();
    }
}