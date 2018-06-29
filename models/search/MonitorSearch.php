<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Monitor;

/**
 * MonitorSearch represents the model behind the search form of `app\models\Monitor`.
 */
class MonitorSearch extends Monitor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'configuration_view_id', 'terminal_monitor_group_id'], 'integer'],
            [['number'], 'safe'],
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
        $query = Monitor::find();

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
            'configuration_view_id' => $this->configuration_view_id,
            'terminal_monitor_group_id' => $this->terminal_monitor_group_id,
        ]);

        $query->andFilterWhere(['like', 'number', $this->number]);

        return $dataProvider;
    }
}
