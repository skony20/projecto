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
            [['is_active', 'vats_id', 'price_brutto_source', 'price_brutto', 'stock', 'is_archive', 'sell_items'], 'required'],
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
            'id' => Yii::t('app', 'ID'),
            'is_active' => Yii::t('app', 'Is Active'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'producers_id' => Yii::t('app', 'Dostawca'),
            'pkwiu' => Yii::t('app', 'PKWIU'),
            'vats_id' => Yii::t('app', 'Vat'),
            'price_brutto_source' => Yii::t('app', 'Cena brutto'),
            'price_brutto' => Yii::t('app', 'Cena brutto po rabacie'),
            'stock' => Yii::t('app', 'Ilość'),
            'rating_value' => Yii::t('app', 'Rating Value'),
            'rating_votes' => Yii::t('app', 'Rating Votes'),
            'creation_date' => Yii::t('app', 'Creation Date'),
            'modification_date' => Yii::t('app', 'Modification Date'),
            'symbol' => Yii::t('app', 'Symbol'),
            'ean' => Yii::t('app', 'Ean'),
            'image' => Yii::t('app', 'Image'),
            'is_archive' => Yii::t('app', 'Is Archive'),
            'sell_items' => Yii::t('app', 'Sell Items'),
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
        
        return $this->hasMany(ProductsDescripton::className(), ['products_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasMany(Languages::className(), ['id' => 'languages_id'])->viaTable('products_descripton', ['products_id' => 'id']);
    }
    
    public function validate($attributeNames = null, $clearErrors = true) {
        parent::validate($attributeNames, $clearErrors);
        return TRUE;
    }
    
}
