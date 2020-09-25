<?php
namespace api\components;

class LocalizationHelper {
    public static $locales = [
        'en_US' => 'en',
        'de_DE' => 'de',
        'es_ES' => 'es',
        'fr_FR' => 'fr',
        'ru_RU' => 'ru'
    ];

    public static function getLocaleName($attrName, $baseName = 'name'){
        $attrName = str_replace($baseName, '', $attrName);
        $attrName = trim($attrName, '_');
        $attrName = isset(self::$locales[$attrName]) ? self::$locales[$attrName] : $attrName;
        return implode('_', [$baseName, $attrName]);
    }
}