<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Page\Asset;
CJSCore::Init(['bx','jquery']);

$model = "CContactTable";
$sTableID = $model::getTableName();
$sort = [
    "by" => isset($_REQUEST['by']) ? strtoupper($_REQUEST['by']) : "EMAIL",
    "order" => isset($_REQUEST['order']) ? strtoupper($_REQUEST['order']) : "ASC",
];
$oSort = new CAdminSorting($sTableID, $sort['by'], $sort['order']);
$lAdmin = new CAdminList($sTableID, $oSort);

$fInfo = [
    "LAST_NAME" => ["name" => "Фамилия", "type" => "string"],
    "FIRST_NAME" => ["name" => "Имя", "type" => "string"],
    "MIDDLE_NAME" => ["name" => "Отчество", "type" => "string"],
    "SKYPE" => ["name" => "Скайп", "type" => "string"],
    "EMAIL" => ["name" => "Email", "type" => "string"],
    "PHONE" => ["name" => "Телефон", "type" => "string"],
];

$filter = CAdminHelper::GetFilterValues($fInfo);

/* Обработка запросов */
if (($arIDs = $lAdmin->GroupAction())) {
    switch ($_REQUEST['action']) {
        case "delete":
            if(isset($_REQUEST['action_target']) && $_REQUEST['action_target'] === 'selected') {
                $arIDs = $model::getIDs();
            }
            $model::Delete(["ID" => $arIDs]);
            break;
    }
}

/* Получаем данные */
$rsData = $model::GetAllRs($filter, [$sort['by'] => $sort['order']]);
$rsData = new CAdminResult($rsData, $sTableID);
$rsData->NavStart();
$lAdmin->NavText($rsData->GetNavPrint());

/* Добавляем информацию по хедеру */
$needHeader = ["ID", "LAST_NAME", "FIRST_NAME", "MIDDLE_NAME", "SKYPE", "EMAIL", "PHONE"];
$header = $model::getAdminListHeader($needHeader);
$lAdmin->AddHeaders($header);

/* Формируем строки для таблицы */
while($arRes = $rsData->Fetch()) {
	$row = &$lAdmin->AddRow($arRes['ID'], $arRes);
	$row->AddViewField("LAST_NAME", "<a href='rm_contact_edit.php?ID=".$arRes["ID"]."'>".$arRes["LAST_NAME"]."</a>");
	$row->AddViewField("FIRST_NAME", "<a href='rm_contact_edit.php?ID=".$arRes["ID"]."'>".$arRes["FIRST_NAME"]."</a>");
	$row->AddViewField("MIDDLE_NAME", "<a href='rm_contact_edit.php?ID=".$arRes["ID"]."'>".$arRes["MIDDLE_NAME"]."</a>");

        $arActions = [
            [
                "ICON" => "edit",
                "TEXT" => "Редактировать",
                "ACTION" => $lAdmin->ActionRedirect("rm_contact_edit.php?ID=" . $arRes['ID'])
            ]
        ];

        $arActions[] = [
            "ICON" => "delete",
            "TEXT" => "Удалить",
            "ACTION" => "if (confirm('Удалить?')) " . $lAdmin->ActionDoGroup($arRes['ID'], "delete")
        ];
	$row->AddActions($arActions);
}

/* Добавляем групповые действия */
$lAdmin->AddGroupActionTable(["delete" => "Удалить"]);
/* Добавляем кнопки в меню */
$lAdmin->AddAdminContextMenu([
    [
		"TEXT" => "Добавить контакт",
		"LINK" => "rm_contact_edit.php",
		"ICON" => "btn_new",
	],
]);
$lAdmin->CheckListMode();

$APPLICATION->SetTitle("Список контактов");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
$oFilter = new CAdminFilter($sTableID . "_filter", []);
?>

<form name="form1" method="GET" action="<?=$APPLICATION->GetCurPage()?>">

<?php
$oFilter->Begin();
echo CAdminHelper::createFormFields($fInfo, $filter);
$oFilter->Buttons();
?>
    <script>
        var filterParams = {
            "name": '<?= $sTableID."_filter"; ?>',
            "table": '<?= $sTableID; ?>',
            "curPage": '<?= $APPLICATION->GetCurPage(); ?>'
        };
    </script>
    <input
        type="button"
        id="item_find"
        class="adm-btn"
        onclick="<?= $sTableID."_filter" ?>.OnSet('<?= $sTableID ?>', '<?= $APPLICATION->GetCurPage() ?>', this);"
        value="Найти"
    />
    <input
        type="button"
        id="item_clear"
        class="adm-btn"
        onclick="<?= $sTableID."_filter" ?>.ClearParameters();<?= $sTableID."_filter" ?>.OnSet('<?= $sTableID ?>', '<?= $APPLICATION->GetCurPage() ?>', this);"
        value="Отменить"
    />
<?php
$oFilter->End();
?>
</form>
<style>td.adm-filter-item-right, .adm-filter-add-tab { display:none; }</style>
<?php
/* Отображаем таблицу */
$lAdmin->DisplayList();
require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_admin.php");
?>