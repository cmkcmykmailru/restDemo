<?php

namespace grigor\blogManagement\services\forms;

use grigor\blog\module\post\api\PostInterface;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * @property array $newNames
 */
class TagsForm extends Model
{
    public $tags = [];

    public function __construct(PostInterface $post = null, $config = [])
    {
        if ($post) {
            $this->tags = ArrayHelper::getColumn($post->tags, 'name');
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['tags', 'each', 'rule' => ['string']],
            ['tags', 'default', 'value' => []],
        ];
    }

}