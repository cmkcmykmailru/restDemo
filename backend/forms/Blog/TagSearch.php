<?php

namespace backend\forms\Blog;

use grigor\blogManagement\BlogManagementContract;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TagSearch extends Model
{
    public $name;
    public $slug;

    public function rules(): array
    {
        return [
            [['name', 'slug'], 'string'],
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

        $contract = \Yii::$container->get(BlogManagementContract::class);
        $query = $contract->createTagQuery();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['name' => SORT_ASC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug]);

        return $dataProvider;
    }
}
