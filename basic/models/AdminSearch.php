<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Admin;
use yii\data\Pagination;

/**
 * AdminSearch represents the model behind the search form about `app\models\Admin`.
 */
class AdminSearch extends Admin
{
    /**
     * @inheritdoc
     */
    public static $describe = "描述";
    public function rules()
    {
        return [
            [['id', 'permission', 'age'], 'integer'],
            [['username', 'password', 'name', 'sex', 'pmail', 'phone'], 'safe'],
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
        $query = Admin::find();
        $pagination = new Pagination([
            'defaultPageSize' => 14,
            'totalCount' => $query->count(),
        ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>$pagination,
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'permission' => $this->permission,
            'age' => $this->age,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'pmail', $this->pmail])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}
