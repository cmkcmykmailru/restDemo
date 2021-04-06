<?php

namespace backend\helpers;

use grigor\blog\module\post\api\PostInterface;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class PostHelper
{
    public static function statusList(): array
    {
        return [
            PostInterface::STATUS_DRAFT => 'Draft',
            PostInterface::STATUS_ACTIVE => 'Active',
        ];
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case PostInterface::STATUS_DRAFT:
                $class = 'label label-default';
                break;
            case PostInterface::STATUS_ACTIVE:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}