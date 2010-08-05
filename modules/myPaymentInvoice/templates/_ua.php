<?php
$profile = $invoice->getUser()->getProfile();
?>

<table cellspacing="0">
    <tr class="desc">
        <td colspan="8">
            <span class="right small">Форма № ПД-4</span>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td class="b-b-2">Коадэ Иоана Ивановна<br />ИНН 1900525245</td>
        <td>&nbsp;</td>
        <td class="b-2" colspan="3">29244825509100</td>
        <td>&nbsp;</td>
        <td class="b-2">14360576</td>
    </tr>

    <tr class="desc">
        <td>&nbsp;</td>
        <td>отримувач платежу</td>
        <td>&nbsp;</td>
        <td colspan="3">Р/рахунок отримувача</td>
        <td>&nbsp;</td>
        <td>код ОКПО отримувача</td>
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td class="b-b-2" colspan="3">ПриватБанк</td>
        <td>&nbsp;</td>
        <td class="b-2">6762462050585345</td>
        <td>&nbsp;</td>
        <td class="b-2">305299</td>
    </tr>

    <tr class="desc">
        <td>&nbsp;</td>
        <td colspan="3">назва установи банку</td>
        <td>&nbsp;</td>
        <td>Карта "Миттева"</td>
        <td>&nbsp;</td>
        <td>МФО банку</td>
    </tr>

    <tr>
        <td colspan="7">&nbsp;</td>
        <td class="b-2">14360570</td>
    </tr>

    <tr class="desc">
        <td colspan="7">&nbsp;</td>
        <td>код ОКПО банку</td>
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td class="b-b-2" colspan="7">
            <?php echo $profile->getName() ?>
        </td>
    </tr>

    <tr class="desc">
        <td>&nbsp;</td>
        <td colspan="7">прiзвище, iм'я та по-батьковi платника</td>
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td class="b-b-2" colspan="7">
            <?php echo $profile->getLocation(), ', ', $profile->getPhone(), ', ', $profile->getMobilePhone() ?>
        </td>
    </tr>

    <tr class="desc">
        <td>&nbsp;</td>
        <td colspan="7" class="b-b-2">адреса платника, телефон</td>
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td class="b-b-2 b-r-2" colspan="6">Призначення платежу</td>
        <td class="b-b-2">Сума</td>
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td class="b-b-2 b-r-2 small" colspan="6">
            <?php echo $invoice->getDescription() ?>
        </td>
        <td class="b-b-2 b-r-2" rowspan="2">
            <span class="small"><?php echo format_currency($invoice->getAmount()) ?></span>
        </td>
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td class="b-b-2 b-r-2" colspan="6">
            <span class="left small">рах. №<?php echo $invoice->getId() ?> вiд <?php echo format_date($invoice->getCreatedAt()) ?></span>
            БЕЗ ПДВ
        </td>
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td class="b-r-2" colspan="4">
            <span class="left i b">Платник</span>
        </td>
        <td class="b-b-2 b-r-2" colspan="2">Всього</td>
        <td class="b-b-2 b-r-2"><?php echo format_currency($invoice->getAmount()) ?></td>
    </tr>

</table>