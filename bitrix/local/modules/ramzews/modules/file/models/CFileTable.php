<?php

class CFileTable extends CModel
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'b_file';
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
            'TIMESTAMP_X' => ['data_type' => 'datetime', 'required' => true, 'title' => "Дата изменения"],
            'MODULE_ID' => ['data_type' => 'string', 'title' => "Модуль"],
            'HEIGHT' => ['data_type' => 'integer', 'title' => "Высота"],
            'WIDTH' => ['data_type' => 'integer', 'title' => "Ширина"],
            'FILE_SIZE' => ['data_type' => 'integer', 'title' => "Размер файла"],
            'CONTENT_TYPE' => ['data_type' => 'string', 'title' => "Тип контента"],
            'SUBDIR' => ['data_type' => 'string', 'title' => "Поддериктория"],
            'FILE_NAME' => ['data_type' => 'string', 'title' => "Название файла"],
            'ORIGINAL_NAME' => ['data_type' => 'string', 'title' => "Оригинальное название"],
            'DESCRIPTION' => ['data_type' => 'string', 'title' => "Описание"],
            'HANDLER_ID' => ['data_type' => 'string', 'title' => "HANDLER_ID"],
            'EXTERNAL_ID' => ['data_type' => 'string', 'title' => "EXTERNAL_ID"],
        ];
    }
}