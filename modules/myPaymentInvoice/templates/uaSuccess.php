<?php
/**
 * Данные для оплаты по Украине
 */
?>

<?php use_helper('Number', 'Date') ?>

<table cellspacing="0">
    <tr>
        <td class="b-r-4 top">
            <p class="b">ПОВИДОМЛЕННЯ</p>
        </td>
        <td class="b-b-2" rowspan="2">
            <?php include_partial('ua', array('invoice' => $invoice)) ?>
        </td>
    </tr>
    <tr>
        <td class="b-b-2 b-r-4 bottom">
            <p class="i">Касир</p>
        </td>
    </tr>

    <tr>
        <td class="b-r-4 top">
            <p class="b">КВИТАНЦIЯ</p>
        </td>
        <td class="b-b-2" rowspan="2">
            <?php include_partial('ua', array('invoice' => $invoice)) ?>
        </td>
    </tr>
    <tr>
        <td class="b-b-2 b-r-4 bottom">
            <p class="i">Касир</p>
        </td>
    </tr>
</table>
