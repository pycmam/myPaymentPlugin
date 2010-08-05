<?php
/**
 * Данные для оплаты из России
 */
?>

<?php use_helper('Number', 'Text', 'Date') ?>

<?php
$profile = $invoice->getUser()->getProfile();
?>

<table id="invoice" cellspacing="0" cellpadding="5">
    <tr>
        <td>ПОЛУЧАТЕЛЬ</td>
        <td>Коадэ Иоана</td>
    </tr>

    <tr>
        <td>СЧЕТ</td>
        <td>26200603006271</td>
    </tr>

    <tr>
        <td>БАНК ПОЛУЧАТЕЛЯ</td>
        <td>ПРИВАТБАНК, ДНЕПРОПЕТРОВСК, УКРАИНА</td>
    </tr>

    <tr>
        <td>СЧЕТ БАНКА ПОЛУЧАТЕЛЯ В БАНКЕ-КОРРЕСПОНДЕНТЕ</td>
        <td>30111810355550000028</td>
    </tr>

    <tr>
        <td>БАНК-КОРРЕСПОНДЕНТ</td>
        <td>ВНЕШТОРГБАНК, МОСКВА, РОССИЯ</td>
    </tr>

    <tr>
        <td>К БАНКА-КОРРЕСПОНДЕНТА</td>
        <td>а/с №623 16051 45</td>
    </tr>

    <tr>
        <td>НОМЕР СЧЕТА БАНКА-КОРРЕСПОНДЕНТА В ОПЕРУ ГТУ БАНКА РОССИИ</td>
        <td>30101810700000000187</td>
    </tr>

    <tr>
        <td>ПЛАТЕЛЬЩИК</td>
        <td><?php echo $profile->getName() ?></td>
    </tr>

    <tr>
        <td colspan="2">
            <?php echo $profile->getLocation(), ', тел. ', $profile->getPhone(), ', ', $profile->getMobilePhone() ?>
        </td>
    </tr>

    <tr>
        <td>НАЗНАЧЕНИЕ ПЛАТЕЖА</td>
        <td><?php echo $invoice->getDescription() ?></td>
    </tr>

    <tr>
        <td>СУММА</td>
        <td><?php echo format_currency($invoice->getAmount()) ?> грн.</td>
    </tr>
</table>