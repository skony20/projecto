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
use app\models\ProductsDescripton;

class UploadImage extends Model
{
    /**
     * @var UploadedFile
     */
    public $importFile;
    public $storey_type;
    public $image_type_id;
    public $description;
    public $importPatch = '../../images/';
    public $iImageThumb = 80;
    public $iImageInfo = 300;

    public function rules()
    {
        return [
            [['importFile'], 'file', 'extensions' => 'jpg, png', 'skipOnEmpty' => true],
            [['storey_type', 'image_type_id'], 'integer'],
            [['description'], 'string', 'max' => 200],
            
        ];
    }
    public function attributeLabels()
      {
        return ['importFile'=>'Wskaż plik do importu', 'storey_type'=>'Piętro', 'image_type_id'=>'Rodzaj zdjęcia'];
        }
    public function upload($p_iPrdId, $p_sDesc, $p_iType, $p_aOrginal, $p_iStoreyType)
    {
        
        if ($this->validate()) 
        {
            $this->CaMDir($p_iPrdId);
            $aOrgFileName = explode('.', $p_aOrginal->name);
            $sFilename = $this->getFileName($p_iPrdId).'.'.$aOrgFileName[1];
            $this->saveImage($p_aOrginal->tempName, $p_iPrdId, $sFilename);
            $this->addImage($p_iPrdId, $sFilename, $p_sDesc, $p_iType, $p_iStoreyType);
            
            return TRUE;
        } else {
            return false;
        }
    }
    private function addImage ($p_iPrdId, $p_sName, $p_sDesc, $p_iType = '', $p_iStory_Type= '')
    {
        $iPrdId = ((int)($p_iPrdId));
        $sName = $p_sName;
        $sDesc = $p_sDesc;
        $iType = ((int)($p_iType));
        $oPrdImage = new ProductsImages();
        $oPrdImage->products_id = $iPrdId;
        $oPrdImage->name = $sName;
        $oPrdImage->storey_type = $p_iStory_Type;
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
    private function CaMDir($p_iId)
    {
        //check and make dir with subdir
        $sPath = $this->importPatch.$p_iId;
        if (!is_dir($sPath))
        {
            //@mkdir($sPath, 0777, TRUE);
            @mkdir($sPath.'/'.$this->sThumb, 0777, TRUE);
            @mkdir($sPath.'/'.$this->sInfo, 0777, TRUE);
            @mkdir($sPath.'/'.$this->sBig, 0777, TRUE);
        }
        return TRUE;
    }
    private function getFileName($p_iId)
    {
        $oProductDescription = new ProductsDescripton();
        $aProductDescription = $oProductDescription->findOne(['products_id'=>$p_iId]);
        $sPath = $this->importPatch.$p_iId.'/big';
        $oFiles = scandir($sPath);
        
        //$aFiles = array_diff($oFiles, array('.','..'));
        $aFiles= $oFiles;
        $iFileNumber = 0;
        $a = 2;
        if (count($aFiles)>0)
        {
            for ($a>0;$a<count($aFiles);$a++)
            {
                $aFileName = explode('.', $aFiles[$a]);
                
                $sFileName = $aFileName[0];
                $sFileNumber = explode('_', $sFileName);
                if ($sFileNumber[1] >  $iFileNumber)
                {
                    $iFileNumber = $sFileNumber[1];   
                }
            }
            $iFileNumber = $iFileNumber+1;
            return $aProductDescription->nicename_link.'_'.$iFileNumber;
        }
    }
    
    
}
?>