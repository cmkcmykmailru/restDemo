<?php

namespace grigor\blogManagement\services\forms;

use grigor\blog\module\post\api\PostInterface;
use grigor\blogManagement\BlogManagementContract;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CategoriesForm extends Model
{
    public $main;
    public $others = [];

    public function __construct(PostInterface $post = null, $config = [])
    {
        if ($post) {
            $this->main = $post->category_id;
            $this->others = ArrayHelper::getColumn($post->categoryAssignments, 'category_id');
        }
        parent::__construct($config);
    }

    public function categoriesList(): array
    {
        $contract = \Yii::$container->get(BlogManagementContract::class);
        return $contract->getAvailableCategories();
    }

    public function rules(): array
    {
        return [
            ['main', 'required'],
            ['main', 'string'],
            ['others', 'each', 'rule' => ['string']],
            ['others', 'default', 'value' => []],
        ];
    }
}