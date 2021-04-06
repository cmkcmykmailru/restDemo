<?php

namespace backend\forms\Blog;

use grigor\blogManagement\BlogManagementContract;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CategorySearch extends Model
{
    public $id;
    public $name;
    public $slug;
    public $title;

    public function rules(): array
    {
        return [
            [['id'], 'string', 'max' => 36],
            [['name', 'slug', 'title'], 'string'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function search(array $params): ActiveDataProvider
    {
        $contract = \ Yii::$container->get(BlogManagementContract::class);
        $query = $contract->createCategoryQuery();
        $query->andWhere(['!=', 'slug', 'root']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_ASC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
