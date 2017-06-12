<?php
namespace app\models;
/*  
    Projekt    : projekttop.pl
    Created on : 2017-05-25, 10:38:35
    Author     : Mariusz Skonieczny, mariuszskonieczny@hotmail.com
*/




use yii\base\Model;
use yii\web\UploadedFile;

class Upload extends Model
{
    /**
     * @var UploadedFile
     */
    public $importFile;
    public $importPatch = '../../xml/import/';

    public function rules()
    {
        return [
            [['importFile'], 'file', 'extensions' => 'csv', 'skipOnEmpty' => true],
        ];
    }
    public function attributeLabels()
      {
        return ['importFile'=>'Wskaż plik do importu'];
        }
    public function upload()
    {
        if ($this->validate()) {
            $this->importFile->saveAs($this->importPatch . $this->importFile->baseName . '.' . $this->importFile->extension);
            $sFile = $this->importPatch . $this->importFile->baseName . '.' . $this->importFile->extension;
            return $sFile;
        } else {
            return false;
        }
    }
}
?>