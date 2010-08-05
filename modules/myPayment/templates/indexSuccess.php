<?php
/**
 * Выбор способа оплаты
 *
 * @param Invoice $invoice
 * @param PayForm $form
 */
?>

<h1><?php echo __('Cabinet') ?></h1>

<?php include_partial('cabinet/tabs') ?>

<h2><?php echo __('Payment for invoice') ?> #<?php echo $invoice->getId() ?></h2>

<form action="<?php echo url_for('myPayment', $invoice) ?>" id="form_payment_system" method="post">
    <ul><?php echo $form ?></ul>

    <br />
    <p><?php echo __('Required to pay:') ?> <strong><?php echo $invoice->getAmount() ?> <?php echo __('UAH') ?></strong></p>
    <br />
    <p><?php echo __('Please indicate the deposit, immediately after payment.') ?></p>
    <br />

    <input type="submit" class="add" value="<?php echo __('Continue') ?>" />
</form>