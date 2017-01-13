<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property integer $is_active
 * @property integer $sort_order
 * @property integer $producers_id
 * @property string $pkwiu
 * @property integer $vats_id
 * @property string $price_brutto_source
 * @property string $price_brutto
 * @property integer $stock
 * @property integer $rating_value
 * @property integer $rating_votes
 * @property integer $creation_date
 * @property integer $modification_date
 * @property string $symbol
 * @property string $ean
 * @property string $image
 * @property integer $is_archive
 * @property integer $sell_items
 *
 * @property OrdersPosition[] $ordersPositions
 * @property Producers $producers
 * @property Vats $vats
 * @property ProductsDescripton[] $productsDescriptons
 * @property Languages[] $languages
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active', 'vats_id', 'price_brutto_source', 'price_brutto', 'stock', 'is_archive', 'sell_items', 'sort_order'], 'required'],
            [['is_active', 'sort_order', 'producers_id', 'vats_id', 'stock', 'rating_value', 'rating_votes', 'creation_date', 'modification_date', 'is_archive', 'sell_items'], 'integer'],
            [['price_brutto_source', 'price_brutto'], 'number'],
            [['pkwiu'], 'string', 'max' => 15],
            [['symbol'], 'string', 'max' => 50],
            [['ean', 'image'], 'string', 'max' => 125],
            [['producers_id'], 'exist', 'skipOnError' => true, 'targetClass' => Producers::className(), 'targetAttribute' => ['producers_id' => 'id']],
            [['vats_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vats::className(), 'targetAttribute' => ['vats_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'is_active' => 'Aktywny',
            'sort_order' => 'Sortowanie',
            'producers_id' => 'Dostawca',
            'pkwiu' => 'PKWIU',
            'vats_id' => 'Vat',
            'price_brutto_source' => 'Cena brutto',
            'price_brutto' => 'Cena brutto po rabacie',
            'stock' => 'Ilość',
            'rating_value' => 'Rating Value',
            'rating_votes' => 'Rating Votes',
            'creation_date' => 'Utworzono',
            'modification_date' => 'Ostatnia zmiana',
            'symbol' => 'Symbol',
            'ean' => 'Ean',
            'image' => 'Obrazek główny',
            'is_archive' => 'Archiwalny',
            'sell_items' => 'Sprzedanych',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersPositions()
    {
        return $this->hasMany(OrdersPosition::className(), ['products_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducers()
    {
        return $this->hasOne(Producers::className(), ['id' => 'producers_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public  function getVats()
    {
        return $this->hasOne(Vats::className(), ['id' => 'vats_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsDescriptons()
    {
        return $this->hasOne(ProductsDescripton::className(), ['products_id' => 'id'])->onCondition(['products_descripton.languages_id' => 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasMany(Languages::className(), ['id' => 'languages_id'])->viaTable('products_descripton', ['products_id' => 'id']);
    }

    public function getProductsFilters()
    {
        return $this->hasMany(ProductsFilters::className(), ['products_id' => 'id']);
    }

    public function getProductsAttributes()
    {
        return $this->hasMany(ProductsAttributes::className(), ['products_id' => 'id']);
    }
    public function getOneAttribute($iAttributes_id = 4)
    {
        return $this->hasOne(ProductsAttributes::className(), ['products_id' => 'id'])->where(['attributes_id' => $iAttributes_id]);
    }
    
    public function getProductsImages()
    {
        return $this->hasMany(ProductsImages::className(), ['products_id' => 'id'])->orderBy(['name' => SORT_ASC],['FIELD(description, NULL, "Wnętrze", "Front domu", "Tył domu", "Bok 1", "Bok 2")' => SORT_ASC]);
    }
    public function getSimilar()
    {
        return $this->hasMany(Similar::className(), ['main_product_id' => 'id']);
    }
    public function getStorey()
    {
        return $this->hasMany(Storeys::className(), ['products_id' => 'id']);
    }
    public function getStoreyByType($iType)
    {
        return $this->hasMany(Storeys::className(), ['products_id' => 'id'])->where(['storey_type'=>$iType])->orderBy(['room_number'=>SORT_ASC]);
    }
    public function getStoreyByName($sName)
    {
        return $this->hasMany(Storeys::className(), ['products_id' => 'id'])->where(['storey_name'=>$sName])->orderBy(['room_number'=>SORT_ASC]);
    }

    public function validate($attributeNames = null, $clearErrors = true) {
        parent::validate($attributeNames, $clearErrors);
        return TRUE;
    }

       /**
    * @inheritdoc
    * @return ProductsQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new ProductsQuery(get_called_class());
    }
    public function CountCart()
    {
        $iCountCart = 0;
        if (Yii::$app->session->get('Cart')!== null)
        {
            foreach (Yii::$app->session->get('Cart') as $aCart)
            {
                $iCountCart += $aCart['iQty'];
            }
        }
        
        return $iCountCart;
    }

}
