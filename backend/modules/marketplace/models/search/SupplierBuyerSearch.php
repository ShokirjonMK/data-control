<?php

namespace backend\modules\marketplace\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SupplierBuyer;

/**
 * SupplierBuyerSearch represents the model behind the search form about `common\models\SupplierBuyer`.
 */
class SupplierBuyerSearch extends SupplierBuyer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by', 'customer_status', 'parent_id'], 'integer'],
            [['group', 'code', 'name', 'full_name', 'name_eng'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SupplierBuyer::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'customer_status' => $this->customer_status,
            'parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['ilike', 'group', $this->group])
            ->andFilterWhere(['ilike', 'code', $this->code])
            ->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'full_name', $this->full_name])
            ->andFilterWhere(['ilike', 'name_eng', $this->name_eng]);

        return $dataProvider;
    }
}
