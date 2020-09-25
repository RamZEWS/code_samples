<?php

namespace api\models;


use common\models\Address as CommonAddress;
/**
 * Address model
 */
class Address extends CommonAddress {

    public function fields() {
        return [
            'name',
            'city',
            'google_id',
            'lat',
            'lng'
        ];
    }

    public function __get($name) {
        if (in_array($name, ['created_at', 'updated_at'])){
            return date('c', $this->getAttribute($name));
        }
        return parent::__get($name);
    }
}
