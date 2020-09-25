<?php
namespace common\models\forms;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadForm is the model behind the upload form.
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $file;

    /**
     * @var UploadedFile[] file attribute
     */
    public $files;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'gif, jpg, png, jpeg'],
            [['files'], 'file', 'skipOnEmpty' => true, 'extensions' => 'gif, jpg, png, jpeg', 'maxFiles' => 10],
        ];
    }

    public function saveImage($path, $is_multi = false){
        if($is_multi) {
            $images = [];
            foreach ($this->files as $index => $file) {
                $filename = implode('.', [md5(time() . $index), $file->extension]);
                $file->saveAs($_SERVER['DOCUMENT_ROOT'] . $path . $filename);
                if(file_exists($_SERVER['DOCUMENT_ROOT'].$path.$filename)) {
                    $images[] = ['base_url' => $path, 'file_name' => $filename];
                }
            }
            return $images;
        } else {
            $filename = implode('.', [md5(time()), $this->file->extension]);
            $this->file->saveAs($_SERVER['DOCUMENT_ROOT'] . $path . $filename);
            if(file_exists($_SERVER['DOCUMENT_ROOT'].$path.$filename)) {
                return [
                    'base_url' => $path,
                    'file_name' => $filename
                ];
            } else {
                $this->addError('file', 'File is not uploaded');    
            }
        }
    }
}