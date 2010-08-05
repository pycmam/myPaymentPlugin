<?php
/**
 * Форма webmoney merchant, детали платежа
 *
 * @param Order $order
 * @param WebmoneyRequestForm $form
 */

$jsWallets = array();
foreach ($wallets as $purse => $wallet) {
    $jsWallets[] = sprintf("'%s': '%s'", $purse, $wallet['amount']);
}
?>

<script type="text/javascript">
$(function(){
    $('#LMI_PAYEE_PURSE').change(function(){
        var wallets = {<?php echo join(', ', $jsWallets) ?>};
        $('#LMI_PAYMENT_AMOUNT').val(wallets[$(this).val()]);
    }).change();
});
</script>

<h1>Оплата через Webmoney</h1>

<h2>Информация о платеже</h2>

<p>Счет №: <strong>#<?php echo $invoice->getId() ?></strong></p>

<form class="list" action="<?php echo sfConfig::get('app_webmoney_merchant_url') ?>" method="post">
    <?php echo $form->renderHiddenFields() ?>
    <ul>
        <li>
            <?php echo $form['LMI_PAYEE_PURSE']->renderLabel() ?>
            <?php echo $form['LMI_PAYEE_PURSE'] ?>
        </li>
    </ul>

    <input type="submit" class="add" value="Оплатить" />
</form>

<br />

<p><?php echo link_to('Выбрать другой способ', 'myPayment', $invoice) ?></p>