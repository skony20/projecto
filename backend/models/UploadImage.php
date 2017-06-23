<?php
namespace app\models;
/*  
    Projekt    : projekttop.pl
    Created on : 2017-05-25, 10:38:35
    Author     : Mariusz Skonieczny, mariuszskonieczny@hotmail.com
*/



use Yii;
use yii\imagine\Image;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadImage extends Model
{
    /**
     * @var UploadedFile
     */
    public $importFile;
    public $importPatch = '../../images/';
    public $iImageThumb = 80;
    public $iImageInfo = 300;

    public function rules()
    {
        return [
            [['importFile'], 'file', 'extensions' => 'jpg, png', 'skipOnEmpty' => true],
        ];
    }
    public function attributeLabels()
      {
        return ['importFile'=>'Wskaż plik do importu'];
        }
    public function upload($p_iPrdId, $p_sName, $p_sDesc, $p_iType, $p_sOrginal)
    {
        if ($this->validate()) 
        {
            $this->saveImage($p_sOrginal, $p_iPrdId, $p_sName);
            
            return TRUE;
        } else {
            return false;
        }
    }
    private function addImage ($p_iPrdId, $p_sName, $p_sDesc, $p_iType)
    {
        $iPrdId = ((int)($p_iPrdId));
        $sName = $p_sName;
        $sDesc = $p_sDesc;
        $iType = ((int)($p_iType));
        $oPrdImage = new ProductsImages();
        $oPrdImage->products_id = $iPrdId;
        $oPrdImage->name = $sName;
        $oPrdImage->description = $sDesc;
        $oPrdImage->image_type_id = $iType;
        $oPrdImage->save(false);
    }
    
    private function saveImage($p_sOrginal, $p_iPrdId, $p_sName)
    {
        $sOrginal = $p_sOrginal;
        $iPrdId = $p_iPrdId;
        $sName = $p_sName;
        $sPatch = Yii::getAlias('@images');
        
        $oImage = new Image();
        
        $sPatch = Yii::getAlias('@images');
        $sBigPatch = $sPatch.'/'.$iPrdId.'/big/';
        $sInfoPatch = $sPatch.'/'.$iPrdId.'/info/';
        $sThumbPatch = $sPatch.'/'.$iPrdId.'/thumbs/';
        
        if (!file_exists($sPatch.'/'.$iPrdId))
        {
            mkdir($sPatch.'/'.$iPrdId, 0777);
            mkdir($sPatch.'/'.$iPrdId.'/thumbs', 0777);    
            mkdir($sPatch.'/'.$iPrdId.'/big', 0777);
            mkdir($sPatch.'/'.$iPrdId.'/info', 0777);
        }
        
        copy($sOrginal, $sBigPatch.$sName);
        $aImageSixe =getimagesize($sBigPatch.$sName); 
        if ($aImageSixe[0] >= $aImageSixe[1])
        {
            $iWidthThumbSize = $aImageSixe[0]/($aImageSixe[0]/$this->iImageThumb);
            $iHeightThumbSize = ceil($aImageSixe[1]/($aImageSixe[0]/$this->iImageThumb));
            $iWidthInfoSize = $aImageSixe[0]/($aImageSixe[0]/$this->iImageInfo);
            $iHeightInfoSize = ceil($aImageSixe[1]/($aImageSixe[0]/$this->iImageInfo));
        }
        else 
        {   
            $iWidthThumbSize = $aImageSixe[0]/($aImageSixe[1]/$this->iImageThumb);
            $iHeightThumbSize = ceil($aImageSixe[1]/($aImageSixe[1]/$this->iImageThumb));
            $iWidthInfoSize = $aImageSixe[0]/($aImageSixe[1]/$this->iImageInfo);
            $iHeightInfoSize = ceil($aImageSixe[1]/($aImageSixe[1]/$this->iImageInfo));
        }
        
        $oImage->thumbnail($sBigPatch.$sName, $iWidthThumbSize, $iHeightThumbSize)->save($sThumbPatch.$sName, ['quality' => 90]);
        $oImage->thumbnail($sBigPatch.$sName, $iWidthInfoSize, $iHeightInfoSize)->save($sInfoPatch.$sName, ['quality' => 90]);
        
    }  
}
?>