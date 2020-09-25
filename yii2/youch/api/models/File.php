<?php

namespace api\models;

use common\models\File as CommonFile;

class File extends CommonFile {
    public function fields() {
        return [
            'id',
            'path',
            'created_at',
            'updated_at'
        ];
    }

    public function getPath(){
        if($this->file_url) {
            return implode('', [$this->file_base_url, $this->file_url]);
        }
        return null;
    }
}
