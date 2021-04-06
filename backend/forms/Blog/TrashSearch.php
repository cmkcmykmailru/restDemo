<?php

namespace backend\forms\Blog;

use grigor\blog\module\post\api\PostInterface;
use grigor\blogManagement\BlogManagementContract;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TrashSearch extends Model
{
    public $id;
    public $title;
    public $status;
    public $category_id;

    public function rules(): array
    {
        return [
            ['status', 'integer'],
            [['id', 'category_id'], 'string'],
            [['title'], 'string'],
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
        $query = $contract->createPostQuery();
        $query->andWhere(['trash' => PostInterface::TRASH])->with('category');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }

    public function categoriesList(): array
    {
        $contract = \Yii::$container->get(BlogManagementContract::class);
        return $contract->getAvailableCategories();
    }

}
