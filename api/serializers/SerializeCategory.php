<?php

namespace api\serializers;

use grigor\blog\module\category\api\CategoryInterface;

class SerializeCategory
{
    public function __invoke(CategoryInterface $category): array
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'title' => $category->title,
            'description' => json_decode($category->description),
            'meta' => json_decode($category->meta_json),
            '_links' => [
                'all' => ['href' => \Yii::$app->getUrlManager()->createAbsoluteUrl(['categories/all'])],
            ],
        ];
    }
}