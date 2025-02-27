<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\SupplierBuyerStatus]].
 *
 * @see \common\models\SupplierBuyerStatus
 */
class SupplierBuyerStatusQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\SupplierBuyerStatus[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\SupplierBuyerStatus|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
