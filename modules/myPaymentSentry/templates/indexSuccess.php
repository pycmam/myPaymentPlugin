<?php
/**
 * Оплата через пластик
 *
 * @param Order $order
 */
?>

<h1>Безналичная оплата Visa, MasterCard</h1>

<h2>Информация о платеже</h2>

<p>Счет №: <strong>#<?php echo $invoice->getId() ?></strong></p>
<p>Сумма: <strong><?php echo $invoice->getAmount() ?> грн.</strong></p>

<form action="<?php echo sfConfig::get('app_sentry_url') ?>" method="post">
    <?php echo $form->renderHiddenFields() ?>

    <input type="submit" class="add" value="Оплатить" />
</form>

<br />

<p><?php echo link_to('Выбрать другой способ', 'myPayment', $invoice) ?></p>