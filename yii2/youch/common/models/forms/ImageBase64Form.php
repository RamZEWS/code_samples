<?php
namespace common\models\forms;

use Yii;
use yii\base\Model;
use common\models\City;

/**
 * Login form
 */
class ImageBase64Form extends Model
{
    public $base64string;
    public $field;

    public static $mimes = [
        'image/gif' => 'gif',
        'image/jpeg' => 'jpeg',
        'image/pjpeg' => 'jpeg',
        'image/png' => 'png',
        'image/svg+xml' => 'svg',
        'image/tiff' => 'tiff',
        'image/vnd.microsoft.icon' => 'ico',
        'image/vnd.wap.wbmp' => 'wbmp',
        'image/webp' => 'webp'
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['base64string', 'field'], 'string'],
            [['base64string'], 'required']
        ];
    }

    public function saveImage($upload_dir){
        if ($this->validate()) {
            list($type, $data) = explode(';', $this->base64string);
            list(, $data) = explode(',', $data);
            list(, $type) = explode(':', $type);
            if(isset(self::$mimes[$type])) {
                $ext = self::$mimes[$type];
                $data = base64_decode($data);

                $filename = implode('.', [md5(time()), $ext]);
                file_put_contents($_SERVER['DOCUMENT_ROOT'].$upload_dir.$filename, $data);
                
                if(file_exists($_SERVER['DOCUMENT_ROOT'].$upload_dir.$filename)) {
                    return [
                        'base_url' => $upload_dir,
                        'file_name' => $filename
                    ];
                } else {
                    $this->addError($this->field, 'File is not uploaded');    
                }
            } else {
                $this->addError($this->field, 'File type is unknown');
            }
        }
        return false;
    }
}
