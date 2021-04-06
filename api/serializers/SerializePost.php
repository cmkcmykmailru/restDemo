<?php

namespace api\serializers;

use grigor\blog\module\category\api\CategoryInterface;
use grigor\blog\module\post\api\PostInterface;
use grigor\blog\module\tag\api\TagInterface;

class SerializePost
{
    public function __invoke(PostInterface $post): array
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'description' => $post->description,
            'content' => json_decode($post->content),
            'meta' => json_decode($post->meta_json),
            'tags' => array_map(function (TagInterface $tag) {
                    return [
                        'id' => $tag->id,
                        'name' => $tag->name,
                        '_links' => [
                            'self' => ['href' => \Yii::$app->getUrlManager()->createAbsoluteUrl(['tags/find', 'id' => $tag->id])],
                        ],
                    ];
                }, $post->tags),
            'categories' => [
                'main' => [
                    'id' => $post->category_id,
                    'name' => $post->category->name,
                    '_links' => [
                        'self' => ['href' => \Yii::$app->getUrlManager()->createAbsoluteUrl(['categories/find', 'id' => $post->category->id])],
                    ],
                ],
                'other' => array_map(function (CategoryInterface $category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        '_links' => [
                            'self' => ['href' => \Yii::$app->getUrlManager()->createAbsoluteUrl(['categories/find', 'id' => $category->id])],
                        ],
                    ];
                }, $post->categories),
            ],
        ];
    }
}