<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ProductsFilters]].
 *
 * @see ProductsFilters
 */
class ProductsFiltersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ProductsFilters[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProductsFilters|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
