<?php

namespace grigor\blogManagement\services;

use grigor\blog\module\category\api\CategoryInterface;
use grigor\blog\module\category\api\CategoryManageServiceInterface;
use grigor\blog\module\category\api\CategoryReadRepositoryInterface;
use grigor\blog\module\category\api\commands\CategoryCommand;
use grigor\blog\module\post\api\commands\CategoriesCommand;
use grigor\blog\module\post\api\commands\PostCommand;
use grigor\blog\module\post\api\commands\TagsCommand;
use grigor\blog\module\post\api\PostInterface;
use grigor\blog\module\post\api\PostManageServiceInterface;
use grigor\blog\module\post\api\PostReadRepositoryInterface;
use grigor\blog\module\tag\api\commands\TagCommand;
use grigor\blog\module\tag\api\TagInterface;
use grigor\blog\module\tag\api\TagManageServiceInterface;
use grigor\blogManagement\BlogManagementContract;
use grigor\blogManagement\services\forms\CategoryForm;
use grigor\blogManagement\services\forms\PostForm;
use grigor\blogManagement\services\forms\TagForm;
use grigor\library\commands\MetaCommand;
use grigor\library\contexts\AbstractContract;
use yii\data\DataProviderInterface;
use yii\db\ActiveQueryInterface;

class BlogManagementService extends AbstractContract implements BlogManagementContract
{

    public function createPost(PostForm $form): PostInterface
    {
        $command = new PostCommand(
            $form->title,
            $form->content,
            new CategoriesCommand($form->categories->main, $form->categories->others),
            new MetaCommand($form->meta->title, $form->meta->description),
            new TagsCommand($form->tags->tags),
            null,
            $form->description
        );

        return $this->container()->get(PostManageServiceInterface::class)->create($command);
    }

    public function createPostQuery(): ActiveQueryInterface
    {
        $class = $this->container()->getDefinitionOf(PostInterface::class);
        return $class::find();
    }

    public function createCategoryQuery(): ActiveQueryInterface
    {
        $class = $this->container()->getDefinitionOf(CategoryInterface::class);
        return $class::find();
    }

    public function editPost(string $id, PostForm $form): void
    {
        $command = new PostCommand(
            $form->title,
            $form->content,
            new CategoriesCommand($form->categories->main, $form->categories->others),
            new MetaCommand($form->meta->title, $form->meta->description),
            new TagsCommand($form->tags->tags),
            $id,
            $form->description);
        $this->container()->get(PostManageServiceInterface::class)->edit($command);
    }

    public function removePost(string $id): void
    {
        $this->container()->get(PostManageServiceInterface::class)->remove($id);
    }

    public function trashPost(string $id): void
    {
        $this->container()->get(PostManageServiceInterface::class)->trash($id);
    }

    public function restorePostFromTrash(string $id): void
    {
        $this->container()->get(PostManageServiceInterface::class)->restoreFromTrash($id);
    }

    public function activatePost(string $id): void
    {
        $this->container()->get(PostManageServiceInterface::class)->activate($id);
    }

    public function draftPost(string $id): void
    {
        $this->container()->get(PostManageServiceInterface::class)->draft($id);
    }

    public function createCategory(CategoryForm $form): CategoryInterface
    {
        $command = new CategoryCommand(
            $form->name,
            $form->slug,
            $form->title,
            $form->parentId,
            new MetaCommand($form->meta->title, $form->meta->description),
            null,
            $form->description);
        return $this->container()->get(CategoryManageServiceInterface::class)->create($command);
    }

    public function editCategory(string $id, CategoryForm $form): void
    {
        $command = new CategoryCommand(
            $form->name,
            $form->slug,
            $form->title,
            $form->parentId,
            new MetaCommand($form->meta->title, $form->meta->description),
            $id,
            $form->description);
        $this->container()->get(CategoryManageServiceInterface::class)->edit($command);
    }

    public function removeCategory(string $id): void
    {
        $this->container()->get(CategoryManageServiceInterface::class)->remove($id);
    }

    public function createTagQuery(): ActiveQueryInterface
    {
        $class = $this->container()->getDefinitionOf(TagInterface::class);
        return $class::find();
    }

    public function editTag(string $id, TagForm $form): void
    {
        $command = new TagCommand($form->name, $form->slug, $id);
        $this->container()->get(TagManageServiceInterface::class)->edit($command);
    }

    public function removeTag(string $id): void
    {
        $this->container()->get(TagManageServiceInterface::class)->remove($id);
    }

    public function getAvailableCategories(bool $root = false, string $rootName = 'No category', ?CategoryInterface $category = null): array
    {
        return $this->container()->get(CategoryReadRepositoryInterface::class)->getAvailableCategories($root, $rootName, $category);
    }

    public function postsCount(): int
    {
        return $this->container()->get(PostReadRepositoryInterface::class)->count();
    }

    public function getAllPostsByRange($offset, $limit): array
    {
        return $this->container()->get(PostReadRepositoryInterface::class)->getAllByRange($offset, $limit);
    }

    public function getAllPosts(): DataProviderInterface
    {
        return $this->container()->get(PostReadRepositoryInterface::class)->getAll();
    }

    public function getAllPostsByCategory(string $id): DataProviderInterface
    {
        return $this->container()->get(PostReadRepositoryInterface::class)->getAllByCategory($id);
    }

    public function getAllPostsByTag(string $id): DataProviderInterface
    {
        return $this->container()->get(PostReadRepositoryInterface::class)->getAllByTag($id);
    }

    public function getLastPost($limit): array
    {
        return $this->container()->get(PostReadRepositoryInterface::class)->getLast($limit);
    }

    public function getPopularPost($limit): array
    {
        return $this->container()->get(PostReadRepositoryInterface::class)->getPopular($limit);
    }

    public function findPost(string $id): ?PostInterface
    {
        return $this->container()->get(PostReadRepositoryInterface::class)->find($id);
    }

    public function findAllCategories(): DataProviderInterface
    {
        return $this->container()->get(CategoryReadRepositoryInterface::class)->findAll();
    }

    public function findCategory(string $id): ?CategoryInterface
    {
        return $this->container()->get(CategoryReadRepositoryInterface::class)->find($id);
    }

}