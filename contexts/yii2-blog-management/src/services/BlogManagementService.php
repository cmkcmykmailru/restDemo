<?php

namespace grigor\blogManagement\services;

use grigor\blog\module\category\api\CategoryInterface;
use grigor\blog\module\category\api\CategoryManageServiceInterface;
use grigor\blog\module\category\api\CategoryReadRepositoryInterface;
use grigor\blog\module\category\api\dto\CategoryDto;
use grigor\blog\module\post\api\dto\CategoriesDto;
use grigor\blog\module\post\api\dto\PostDto;
use grigor\blog\module\post\api\dto\TagsDto;
use grigor\blog\module\post\api\PostInterface;
use grigor\blog\module\post\api\PostManageServiceInterface;
use grigor\blog\module\post\api\PostReadRepositoryInterface;
use grigor\blog\module\post\api\TrashManageServiceInterface;
use grigor\blog\module\tag\api\dto\TagDto;
use grigor\blog\module\tag\api\TagInterface;
use grigor\blog\module\tag\api\TagManageServiceInterface;
use grigor\blogManagement\BlogManagementContract;
use grigor\blogManagement\services\forms\CategoryForm;
use grigor\blogManagement\services\forms\PostForm;
use grigor\blogManagement\services\forms\TagForm;
use grigor\library\contexts\AbstractContract;
use grigor\library\dto\Meta;
use grigor\library\helpers\DefinitionHelper;
use RuntimeException;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class BlogManagementService extends AbstractContract implements BlogManagementContract
{

    public function createPost(PostForm $form): PostInterface
    {
        $dto = new PostDto($form->title,
            $form->content,
            new CategoriesDto($form->categories->main, $form->categories->others),
            new Meta($form->meta->title, $form->meta->description),
            new TagsDto($form->tags->tags),
            null,
            $form->description);
        return $this->container()->get(PostManageServiceInterface::class)->create($dto);
    }

    public function createPostQuery(): ActiveQuery
    {
        $this->container();
        return \Yii::createObject(ActiveQuery::class,
            [DefinitionHelper::getDefinition(PostInterface::class)]);
    }

    public function createCategoryQuery(): ActiveQuery
    {
        $this->container();
        return \Yii::createObject(ActiveQuery::class,
            [DefinitionHelper::getDefinition(CategoryInterface::class)]);
    }

    public function editPost(string $id, PostForm $form): void
    {
        $dto = new PostDto(
            $form->title,
            $form->content,
            new CategoriesDto($form->categories->main, $form->categories->others),
            new Meta($form->meta->title, $form->meta->description),
            new TagsDto($form->tags->tags),
            $id,
            $form->description);
        $this->container()->get(PostManageServiceInterface::class)->edit($dto);
    }

    public function removePost(string $id): void
    {
        $this->container()->get(TrashManageServiceInterface::class)->remove($id);
    }

    public function trashPost(string $id): void
    {
        $this->container()->get(TrashManageServiceInterface::class)->trash($id);
    }

    public function restorePostFromTrash(string $id): void
    {
        $this->container()->get(TrashManageServiceInterface::class)->restoreFromTrash($id);
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
        $dto = new CategoryDto(
            $form->name,
            $form->slug,
            $form->title,
            $form->parentId,
            new Meta($form->meta->title, $form->meta->description),
            null,
            $form->description);
        return $this->container()->get(CategoryManageServiceInterface::class)->create($dto);
    }

    public function editCategory(string $id, CategoryForm $form): void
    {
        $dto = new CategoryDto(
            $form->name,
            $form->slug,
            $form->title,
            $form->parentId,
            new Meta($form->meta->title, $form->meta->description),
            $id,
            $form->description);
        $this->container()->get(CategoryManageServiceInterface::class)->edit($dto);
    }

    public function removeCategory(string $id): void
    {
        $this->container()->get(CategoryManageServiceInterface::class)->remove($id);
    }

    public function getDefinitionOf(string $className): string
    {
        $this->container();
        $definitions = \Yii::$container->getDefinitions();

        if (!\Yii::$container->has($className)) {
            throw new RuntimeException('Class ' . $className . ' is not registered correctly.');
        }

        return $definitions[$className]['class'];
    }

    public function createTagQuery(): ActiveQuery
    {
        $this->container();
        return \Yii::createObject(ActiveQuery::class, [DefinitionHelper::getDefinition(TagInterface::class)]);
    }

    public function editTag(string $id, TagForm $form): void
    {
        $dto = new TagDto($form->name, $form->slug, $id);
        $this->container()->get(TagManageServiceInterface::class)->edit($dto);
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