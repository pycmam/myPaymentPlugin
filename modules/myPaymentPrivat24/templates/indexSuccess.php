<?php
/**
 * Оплата через Приват24
 *
 * @param Order $order
 */
?>

<h1>Оплата через Приват24</h1>

<h2>Информация о платеже</h2>

<p>Счет №: <strong>#<?php echo $invoice->getId() ?></strong></p>
<p>Сумма: <strong><?php echo $invoice->getAmount() ?> грн.</strong></p>

<form action="<?php echo sfConfig::get('app_privat24_url') ?>" method="post" accept-charset="windows-1251">
    <?php echo $form->renderHiddenFields() ?>

    <input type="submit" class="add" value="Оплатить" />
</form>

<p><?php echo link_to('Выбрать другой способ', 'myPayment', $invoice) ?></p>