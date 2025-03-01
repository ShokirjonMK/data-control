<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Supplier]].
 *
 * @see \common\models\Supplier
 */
class SupplierQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Supplier[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Supplier|array|null
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
