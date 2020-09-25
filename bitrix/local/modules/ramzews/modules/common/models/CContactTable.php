<?php

class CContactTable extends CModel
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'rm_contact';
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return [
            'ID' => ['data_type' => 'integer', 'primary' => true, 'autocomplete' => true, 'title' => "ID"],
            'FIRST_NAME' => ['data_type' => 'string', 'title' => "Имя"],
            'LAST_NAME' => ['data_type' => 'string', 'title' => "Фамилия"],
            'MIDDLE_NAME' => ['data_type' => 'string', 'title' => "Отчество"],
            'FIRST_NAME_EN' => ['data_type' => 'string', 'title' => "First name"],
            'LAST_NAME_EN' => ['data_type' => 'string', 'title' => "Second name"],
            'MIDDLE_NAME_EN' => ['data_type' => 'string', 'title' => "Middle name"],
            'PHONE' => ['data_type' => 'string', 'title' => "Телефон"],
            'POST' => ['data_type' => 'string', 'title' => "Должность"],
            'POST_EN' => ['data_type' => 'string', 'title' => "Post"],
            'SKYPE' => ['data_type' => 'string', 'title' => "Скайп"],
            'EMAIL' => ['data_type' => 'string', 'title' => "Email"],
            'MOBILE_PHONE' => ['data_type' => 'string', 'title' => "Мобильный телефон"],
            'ABOUT' => ['data_type' => 'text', 'title' => "О себе"],
            'ABOUT_EN' => ['data_type' => 'text', 'title' => "About"],
            'TERRITORY' => ['data_type' => 'string', 'title' => "Территория"],
            'TERRITORY_EN' => ['data_type' => 'string', 'title' => "Territory"],
            'PHOTO_ID' => ['data_type' => 'integer', 'title' => "Фото"],
            'SORT' => ['data_type' => 'integer', 'title' => "Сортировка"],
            'CREATED_AT' => ['data_type' => 'datetime', 'title' => "Дата создания"],

            "PHOTO" => ['data_type' => 'CFile', 'reference' => ['=this.PHOTO_ID' => 'ref.ID']],
        ];
    }

    public static function OnBeforeUpdate (\Bitrix\Main\Entity\Event $event)
    {
		$item = self::Get($event->getParameter("primary"));
		$fields = $event->getParameter("fields");

        if ($fields && $fields["PHOTO_ID"] && $item["PHOTO_ID"]) {
			$path = CFile::GetPath($item["PHOTO_ID"]);
			if (file_exists($_SERVER["DOCUMENT_ROOT"].$path)) {
            	CFile::Delete($item["PHOTO_ID"]);
			}
            return true;
        }
        return false;
    }
}