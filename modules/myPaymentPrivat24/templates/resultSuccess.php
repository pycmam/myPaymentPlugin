<?php
/**
 * Sentry result page
 */
?>

<?php use_helper('I18N') ?>

<h1>Оплата через Приват24</h1>

<p><?php echo __('privat24_state_' . $status)?></p>


<br />

<p><?php echo link_to('Вернуться в личный кабинет', 'cabinet') ?></p>