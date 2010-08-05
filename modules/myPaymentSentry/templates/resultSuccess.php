<?php
/**
 * Sentry result page
 */
?>

<?php use_helper('I18N') ?>

<h1>Безналичная оплата Visa, MasterCard</h1>

<p><?php echo __('sentry_response_' . $responseCode . $reasonCode)?></p>

<br />

<p><?php echo $reasonCodeDesc ?></p>

<br />

<p><?php echo link_to('Вернуться в личный кабинет', 'cabinet') ?></p>