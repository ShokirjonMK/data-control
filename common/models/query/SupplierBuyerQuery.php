<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\SupplierBuyer]].
 *
 * @see \common\models\SupplierBuyer
 */
class SupplierBuyerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\SupplierBuyer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\SupplierBuyer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function onlyActive(): ?self
    {
        return $this->andWhere(['deleted_at' => null]);
    }
}
