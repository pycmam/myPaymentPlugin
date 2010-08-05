<?php
/**
 * Форма w1, детали платежа
 *
 * @param Order $order
 * @param W1RequestForm $form
 */
?>

<h1>Оплата через "Единую кассу"</h1>

<h2>Информация о платеже</h2>

<p>Счет №: <strong>#<?php echo $invoice->getId() ?></strong></p>
<p>Сумма: <strong><?php echo $invoice->getAmount() ?> грн.</strong></p>

<form action="<?php echo sfConfig::get('app_w1_url') ?>" method="post">
    <?php echo $form->renderHiddenFields() ?>

    <input type="submit" class="add" value="Оплатить" />
</form>

<br />

<p><?php echo link_to('Выбрать другой способ', 'myPayment', $invoice) ?></p>