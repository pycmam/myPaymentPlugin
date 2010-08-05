<?php
/**
 * Квитанция на оплату
 *
 * @param Order $order
 */
?>

<h1>Оплата банковским переводом</h1>

<h2>Информация о платеже</h2>

<p>Счет №: <strong>#<?php echo $invoice->getId() ?></strong></p>
<p>Сумма: <strong><?php echo $invoice->getAmount() ?> грн.</strong></p>


<h2><?php echo link_to('Перевод из России', 'payment_invoice_show', array(
        'id' => $invoice->getId(),
        'country' => 'ru',
    ), array(
        'target' => '_blank',
    )) ?></h2>

<h2><?php echo link_to('Перевод по Украине', 'payment_invoice_show', array(
        'id' => $invoice->getId(),
        'country' => 'ua',
    ), array(
        'target' => '_blank',
    )) ?></h2>

<br />

<p><?php echo link_to('Выбрать другой способ', 'myPayment', $invoice) ?></p>