<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ServiceType;

/**
 * ServiceTypeSearch represents the model behind the search form of `app\models\ServiceType`.
 */
class ServiceTypeSearch extends ServiceType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'group_id', 'active_passive'], 'integer'],
            [['name', 'queu_start_time', 'queu_end_time', 'service_letter'], 'safe'],
            [['one_queu_time'], 'number'],
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
        $query = ServiceType::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'one_queu_time' => $this->one_queu_time,
            'queu_start_time' => $this->queu_start_time,
            'queu_end_time' => $this->queu_end_time,
            'group_id' => $this->group_id,
            'active_passive' => $this->active_passive,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'service_letter', $this->service_letter]);

        return $dataProvider;
    }
}
