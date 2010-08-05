<?php
/**
 * Форма счета QIWI
 *
 * @param Order $order
 */

use_helper('Number', 'Currency')
?>

<h1>Оплата через терминалы QIWI</h1>

<h2>Информация о платеже</h2>

<p>Счет №: <strong>#<?php echo $invoice->getId() ?></strong></p>
<p>Сумма: <strong><?php echo Currency::convertByAbbr($invoice->getAmount(), 'RUR') ?> руб.</strong></p>
<br />

<p><?php echo link_to('Выставить счет', 'payment_qiwi_create', $invoice) ?></p>

<br />

<p><?php echo link_to('Выбрать другой способ', 'myPayment', $invoice) ?></p>