<?php

namespace grigor\blogManagement\services\forms;

use grigor\blog\module\tag\api\TagInterface;
use grigor\blogManagement\BlogManagementContract;
use grigor\library\validators\SlugValidator;
use yii\base\Model;

class TagForm extends Model
{
    public $name;
    public $slug;

    private $_tag;
    private $strict;

    public function __construct(TagInterface $tag = null, bool $strict = true, $config = [])
    {
        $this->strict = $strict;
        if (!empty($tag)) {
            $this->name = $tag->name;
            $this->slug = $tag->slug;
            $this->_tag = $tag;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        $contract = \Yii::$container->get(BlogManagementContract::class);
        return array_filter([
            $this->strict ? [['name', 'slug'], 'required'] : false,
            !$this->strict ? [['name', 'slug'], 'validateEmpty'] : false,
            [['name', 'slug'], 'string', 'max' => 255],
            ['slug', SlugValidator::class],
            [['name', 'slug'], 'unique', 'targetClass' => $contract->getDefinitionOf(TagInterface::class), 'filter' => $this->_tag ? ['<>', 'id', $this->_tag->id] : null],
            [['name', 'slug'], 'safe'],
        ]);
    }

    public function validateEmpty($attribute, $params)
    {
        if (empty($this->name) && empty($this->slug)) {
            $this->addError($attribute, 'The value must not be empty.');
        }
    }

    /**
     * @return bool
     */
    public function isStrict(): bool
    {
        return $this->strict;
    }

}