<?php

namespace backend\modules\marketplace\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Webhook;

/**
 * WebhookSearch represents the model behind the search form about `common\models\Webhook`.
 */
class WebhookSearch extends Webhook
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'supplier_buyer_id', 'status'], 'integer'],
            [['url', 'token'], 'safe'],
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
        $query = Webhook::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'supplier_buyer_id' => $this->supplier_buyer_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['ilike', 'url', $this->url])
            ->andFilterWhere(['ilike', 'token', $this->token]);

        return $dataProvider;
    }
}
