<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Employee;

class EmployeeSearch extends Employee
{
    // Add any additional attributes here for searching, if needed.
    public $id;
    public $name;
    public $lastname;
    public $birthday;
    public $access_level;

    public function rules()
    {
        return [
            // Define validation rules for attributes, if needed.
            [['id', 'name', 'lastname', 'birthday', 'access_level'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Employee::find();

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
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'birthday', $this->birthday])
            ->andFilterWhere(['access_level' => $this->access_level]);

        return $dataProvider;
    }
}
