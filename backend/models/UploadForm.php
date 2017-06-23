<?php
namespace app\models;

use yii\base\Model;
use yii\imagine\Image;
use Imagine\Image\Box;
use app\models\Post;
use Yii;
use Imagine;

class UploadForm extends Model
{
    public $importFile;
    public $imageFiles;
    public $image;
    public $id;
    public $sFileName;
    public $sPath = '../../images/';
    public $sThumb = 'thumbs'; //80x80
    public $iThumbSize = 80;
    public $sInfo = 'info'; //300x300
    public $iInfoSize = 300;
    public $sBig = 'big'; //min 10224
    public $iBigSize = 1024;


    public function upload()
    {
            return false;
    }

    public function rules()
    {
        return [
            [['importFile'], 'file', 'extensions' => 'jpg, png', 'skipOnEmpty' => true],
        ];
    }
    public function saveImages()
    {


        $this->CaMDir($this->id);
//        $oPost = new Post();
//        $aPost = $oPost->findOne($this->id);
        $sNiceName = $this->id;
        $sPath = $this->sPath.$this->id;
        //$files = $this->readDir($sPath);

        $files = get_object_vars($this->imageFiles);
        $sFileName = $sNiceName;
        $ext = substr($files['name'], strrpos($files['name'], '.') + 1);
        move_uploaded_file($files['tempName'], $sPath.'/'.$sFileName.'.'.$ext);
        $this->resizeImage($sPath, $sFileName, $ext);




        return TRUE;

    }

    public function CaMDir($id)
    {
        //check and make dir with subdir
        $sPath = $this->sPath.$id;
        if (!is_dir($sPath))
        {
            //@mkdir($sPath, 0777, TRUE);
            @mkdir($sPath.'/'.$this->sThumb, 0777, TRUE);
            @mkdir($sPath.'/'.$this->sInfo, 0777, TRUE);
            @mkdir($sPath.'/'.$this->sBig, 0777, TRUE);
        }
        return TRUE;
    }
    public function resizeImage($sPath, $sFileName, $ext)
    {
        Image::frame($sPath.'/'.$sFileName . '.' . $ext, 0)->thumbnail(new Box($this->iThumbSize, $this->iThumbSize))->save($sPath.'/' .$this->sThumb.'/' .$sFileName . '.' . $ext, ['quality' => 100]);
        Image::frame($sPath.'/'.$sFileName . '.' . $ext, 0)->thumbnail(new Box($this->iInfoSize, $this->iInfoSize))->save($sPath.'/' .$this->sInfo.'/' .$sFileName . '.' . $ext, ['quality' => 100]);
        Image::frame($sPath.'/'.$sFileName . '.' . $ext, 0)->thumbnail(new Box($this->iBigSize, $this->iBigSize))->save($sPath.'/' .$this->sBig.'/' .$sFileName . '.' . $ext, ['quality' => 100]);
        unlink($sPath.'/'.$sFileName . '.' . $ext);

    }
    public function resizeImageXml($sPath, $sFileName, $aDir)
    {
        Image::frame($sPath.'/'.$aDir .'/big/'.$sFileName, 0)->thumbnail(new Box($this->iThumbSize, $this->iThumbSize))->save($sPath.'/'.$aDir.'/'.$this->sThumb.'/' .$sFileName, ['quality' => 100]);

        Image::frame($sPath.'/'.$aDir .'/big/'.$sFileName, 0)->thumbnail(new Box($this->iInfoSize, $this->iInfoSize))->save($sPath.'/'.$aDir.'/'.$this->sInfo.'/' .$sFileName, ['quality' => 100]);

    }
    public function resizeAll()
    {
        $sPath = Yii::getAlias('@images', TRUE);

        $aDirs = $this->readDir($sPath);

        foreach ($aDirs['files'] as $aDir)
        {
            $aFiles = $this->readDir($sPath.'/'.$aDir.'/big');
            foreach ($aFiles['files'] as $sFiles)
            {
                $sFile = $sPath;
                $aCheckDir = $this->readDir($sPath.'/'.$aDir.'/info');
                if (count($aFiles['files']) != count($aCheckDir['files']))
                {
                    $this->resizeImageXml($sFile, $sFiles, $aDir);
                }

            }

        }

    }
    public function readDir($sPath)
    {
        $oFiles = scandir($sPath);
        $aFiles = array_diff($oFiles, array('.','..'));
        if (!is_dir($sPath))
        {
            $aFiles = '';
        }
        return array('files'=>$aFiles);
    }

}