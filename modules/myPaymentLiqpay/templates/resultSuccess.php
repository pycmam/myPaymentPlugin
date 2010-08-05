<?php
/**
 * Sentry result page
 */
?>

<?php use_helper('I18N') ?>
<h1>Безналичная оплата Visa, MasterCard (liqpay.com)</h1>

<p><?php echo __('liqpay_status_' . $status)?></p>

<br />

<p><?php echo link_to('Вернуться в личный кабинет', 'cabinet') ?></p>