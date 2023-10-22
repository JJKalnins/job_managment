<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Workitem;

class WorkitemSearch extends Workitem
{
    // Add any additional attributes here for searching, if needed.
    public $id;
    public $name;
    public $default_comment;

    public function rules()
    {
        return [
            // Define validation rules for attributes, if needed.
            [['id', 'name', 'default_comment'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Workitem::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Add filtering conditions based on the search form
        $query->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'default_comment', $this->default_comment]);

        return $dataProvider;
    }
}
