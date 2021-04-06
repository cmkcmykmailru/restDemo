<?php

namespace api\serializers;

use grigor\blog\module\tag\api\TagInterface;

class SerializeTag
{
    public function __invoke(TagInterface $tag): array
    {
        return [
            'id' => $tag->id,
            'name' => $tag->name,
            '_links' => [
                'all' => ['href' => \Yii::$app->getUrlManager()->createAbsoluteUrl(['categories/all'])],
            ],
        ];
    }
}