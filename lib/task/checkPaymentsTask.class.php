<?php
/**
 * Проверка статусов платежей QIWI
 */
class checkPaymentsTask extends sfBaseTask
{
    protected function configure()
    {
        $this->addArguments(array(
          new sfCommandArgument('application', sfCommandArgument::REQUIRED, 'The application name'),
        ));

        $this->addOptions(array(
          new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment name', 'dev'),
        ));

        $this->namespace        = 'qiwi';
        $this->name             = 'checkPayments';
        $this->briefDescription = '';
    }

    protected function execute($arguments = array(), $options = array())
    {
        new sfDatabaseManager($this->configuration);

        $invoices = Doctrine::getTable('Invoice')->createQuery('a')
            ->where('a.is_paid = 0')
            ->andWhere('a.payment_system = ?', 'qiwi')
            ->execute();

        $this->logSection('invoices found', $invoices->count());

        $qiwi = QIWI::getInstance();

        $bills = array();
        foreach($invoices as $invoice) {
            $bills[$invoice->getTransactionId()] = $invoice;
        }

        if (count($bills)) {
            $result = $qiwi->billStatus(array_keys($bills));

            foreach ($result as $billId => $billStatus) {
                if ($billStatus['status'] == QIWI::STATUS_PAID) {
                    $bills[$billId]->doPay($billStatus);
                    $this->logSection('success', '#' . $bills[$billId]->getId());
                }
            }
        }
    }
}
