<?php

namespace grigor\blogManagement\services\forms;

use elisdn\compositeForm\CompositeForm;
use grigor\blog\module\post\api\PostInterface;
use grigor\blogManagement\BlogManagementContract;
use grigor\library\forms\MetaForm;
use yii\helpers\ArrayHelper;

/**
 * @property MetaForm $meta
 * @property CategoriesForm $categories
 * @property TagsForm $tags
 */
class PostForm extends CompositeForm
{
    public $title;
    public $description;
    public $content;

    public function __construct(PostInterface $post = null, $config = [])
    {
        if ($post) {
            $this->title = $post->title;
            $this->description = $post->description;
            $this->content = $post->content;
            $this->categories = new CategoriesForm($post);
            $this->meta = new MetaForm($post->meta);
            $this->tags = new TagsForm($post);
        } else {
            $this->meta = new MetaForm();
            $this->tags = new TagsForm();
            $this->categories = new CategoriesForm();
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['title', 'content'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['description', 'content'], 'string'],
        ];
    }

    protected function internalForms(): array
    {
        return ['meta', 'tags', 'categories'];
    }

    public function categoriesList(): array
    {
        $contract = \Yii::$container->get(BlogManagementContract::class);
        return $contract->getAvailableCategories();
    }
}