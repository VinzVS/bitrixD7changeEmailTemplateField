<?php
ini_set('max_execution_time', 86400);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
// заменяемое значение
$changeFields = ['EMAIL_FROM' => 'info@ddpost.ru'];

global $APPLICATION;
$APPLICATION->SetTitle("замена почты");

$arFilter = array(
    "ACTIVE" => "Y",
);
$rsMess = CEventMessage::GetList($by = "site_id", $order = "desc", $arFilter);
$allMessage = [];
while ($arMess = $rsMess->GetNext()) {

    $allMessage[$arMess['ID']] = $changeFields;
}

$em = new CEventMessage;
foreach ($allMessage as $key => $val) {
    $strError = '';
    $arFields = $val;
    $res = $em->Update($key, $arFields);

    if (!$res) {
        $strError .= $em->LAST_ERROR . "<br>";
        $bVarsFromForm = true;
    } else {
        echo 'заменили id=' . $key . ' новым  значением <br>';
    }
}

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");