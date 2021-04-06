<?php

namespace backend\forms\Blog;

use grigor\blogManagement\BlogManagementContract;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TagsAjaxSearch extends Model
{
    public $search;

    public function rules(): array
    {
        return [
            ['search', 'string'],
        ];
    }

    /**
     * @param array $params
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function search(array $params): array
    {
        $contract = \Yii::$container->get(BlogManagementContract::class);
        $query = $contract->createTagQuery()->select('name');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_ASC]
            ]
        ]);

        $this->load($params, '');

        if (!$this->validate()||empty($this->search)) {
            return [];
        }

        return array_map(function($item){return ['value' => $item['name'], 'text' =>$item['name']];},$query->andFilterWhere(['like', 'name', $this->search])->asArray()->all());
    }
}