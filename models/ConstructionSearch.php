<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Construction;

class ConstructionSearch extends Construction
{
    // Add any additional attributes here for searching, if needed.
    public $id;
    public $location;
    public $sqsize;
    public $required_access_level;

    public function rules()
    {
        return [
            // Define validation rules for attributes, if needed.
            [['id', 'location', 'sqsize', 'required_access_level'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Construction::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Add filtering conditions based on the search form
        $query->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'sqsize', $this->sqsize])
            ->andFilterWhere(['like', 'required_access_level', $this->required_access_level]);

        return $dataProvider;
    }
}
