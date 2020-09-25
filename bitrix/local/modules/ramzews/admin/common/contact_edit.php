<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_admin_before.php');
?>
<script type="text/javascript" src="/local/templates/ctc/js/jquery.min.js"></script>
<?
$id = isset($_REQUEST["ID"]) ? (int) ($_REQUEST["ID"]) : null;

$message = null;
if($REQUEST_METHOD === "POST" && check_bitrix_sessid()) {
    // сохранение данных
    $arFields = CContactTable::prepareFields($_POST);
    if (isset($_POST["DELETE_FILE_PHOTO_ID"])) {
         $arFields["PHOTO_ID"] = null;
    } else {
        if ($photo_id = CContactTable::UploadFile("PHOTO_ID", true)) {
            $arFields["PHOTO_ID"] = $photo_id;
        }
    }

    if ($id) {
        CContactTable::Update($id, $arFields);
    } else {
        $arFields["CREATED_AT"] = new \Bitrix\Main\Type\DateTime(date("Y-m-d H:i:s"), "Y-m-d H:i:s");
        $res = CContactTable::Add($arFields);
        $id = $res->getId();
    }

    if (!$message && $id) {
        if(isset($_POST["save"])) {
            LocalRedirect("rm_contact_list.php");
        } else {
            LocalRedirect("rm_contact_edit.php?ID=".$id);
        }
    } else if ($e = $APPLICATION->GetException()) {
        $message = new CAdminMessage("Ошибка сохранения", $e);
    }
}

$item = $id ? CContactTable::Get(["ID" => $id]) : CContactTable::getEmpty();
$APPLICATION->SetTitle($id ? $item["NAME"] : "Новый контакт");

$aTab = [
    "DIV" => "edit1",
    "TAB" => $id ? $item["NAME"] : "Новый контакт",
    "ICON"=>"main_user_edit"
];
$tabControl = new CAdminTabControl("tabControl", [$aTab]);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");

$context = new CAdminContextMenu([
    [
        "TEXT" => "Вернуться к списку",
        "TITLE" => "Вернуться к списку",
        "LINK" => "rm_contact_list.php",
        "ICON" => "btn_list",
    ],
]);
$context->Show();

if ($message !== null) {
    echo $message->Show();
}

$fields = [
    "LAST_NAME" => ["name" => "Фамилия", "type" => "text"],
    "FIRST_NAME" => ["name" => "Имя", "type" => "text"],
    "MIDDLE_NAME" => ["name" => "Отчество", "type" => "text"],
    "POST" => ["name" => "Должность", "type" => "text"],
    "TERRITORY" => ["name" => "Территория", "type" => "text"],
    "SKYPE" => ["name" => "Скайп", "type" => "text"],
    "EMAIL" => ["name" => "Email", "type" => "text"],
    "PHONE" => ["name" => "Телефон", "type" => "text"],
    "MOBILE_PHONE" => ["name" => "Мобильный телефон", "type" => "text"],
    "ABOUT" => ["name" => "О себе", "type" => "textarea"],
    "PHOTO_ID" => ["name" => "Фотография", "type" => "file"],
    "SORT" => ["name" => "Сортировка", "type" => "text"],
];
?>
<form method="POST" action="<?= $APPLICATION->GetCurPage() ?>" name="post_form" enctype="multipart/form-data">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="ID" value="<?= $id ?>" />
    <?php
    $tabControl->Begin();
    $tabControl->BeginNextTab();
    echo CAdminHelper::createFormFields($fields, $item);
    $tabControl->Buttons(array());
    $tabControl->End();
    ?>
</form>
<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");