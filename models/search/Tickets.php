<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tickets as TicketsModel;

/**
 * Tickets represents the model behind the search form of `app\models\Tickets`.
 */
class Tickets extends TicketsModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'number', 'queu_count', 'terminal_id', 'service_type_id', 'status', 'call_user_id', 'book_id'], 'integer'],
            [['letter', 'kanchi_date', 'kanchi_time', 'date', 'call_time'], 'safe'],
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
        $query = TicketsModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
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
            'number' => $this->number,
            'queu_count' => $this->queu_count,
            'kanchi_date' => $this->kanchi_date,
            'kanchi_time' => $this->kanchi_time,
            'terminal_id' => $this->terminal_id,
            'service_type_id' => $this->service_type_id,
            'status' => $this->status,
            'date' => $this->date,
            'call_user_id' => $this->call_user_id,
            'call_time' => $this->call_time,
            'book_id' => $this->book_id,
        ]);

        $query->andFilterWhere(['like', 'letter', $this->letter]);

        return $dataProvider;
    }
}
