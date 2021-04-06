<?php

namespace grigor\blogManagement\services\forms;

use elisdn\compositeForm\CompositeForm;
use grigor\blog\module\category\api\CategoryInterface;
use grigor\blogManagement\BlogManagementContract;
use grigor\library\forms\MetaForm;
use grigor\library\validators\SlugValidator;
use yii\helpers\ArrayHelper;

/**
 * @property MetaForm $meta;
 */
class CategoryForm extends CompositeForm
{
    public $name;
    public $slug;
    public $title;
    public $description;
    public $parentId;

    private $_category;

    public function __construct(CategoryInterface $category = null, $config = [])
    {
        if ($category) {
            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->title = $category->title;
            $this->description = $category->description;
            $this->parentId = $category->parent ? $category->parent->id : null;
            $this->meta = new MetaForm($category->meta);
            $this->_category = $category;
        } else {
            $this->meta = new MetaForm();
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        $contract = \Yii::$container->get(BlogManagementContract::class);
        return [
            [['name', 'slug', 'parentId'], 'required'],
            [['parentId'], 'string', 'max' => 36],
            [['name', 'slug', 'title'], 'string', 'max' => 255],
            [['description'], 'string'],
            ['slug', SlugValidator::class],
            [['name', 'slug'], 'unique', 'targetClass' => $contract->getDefinitionOf(CategoryInterface::class),
                'filter' => $this->_category ? ['<>', 'id', $this->_category->id] : null]
        ];
    }

    public function parentCategoriesList(): array
    {
        $contract = \Yii::$container->get(BlogManagementContract::class);
        return $contract->getAvailableCategories(true,'No category', $this->_category);
    }

    public function internalForms(): array
    {
        return ['meta'];
    }

}