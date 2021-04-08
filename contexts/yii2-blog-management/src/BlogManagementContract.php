<?php

namespace grigor\blogManagement;

use Exception;
use grigor\blog\module\category\api\CategoryInterface;
use grigor\blog\module\post\api\PostInterface;
use grigor\blogManagement\services\forms\CategoryForm;
use grigor\blogManagement\services\forms\PostForm;
use grigor\blogManagement\services\forms\TagForm;
use yii\data\DataProviderInterface;
use grigor\generator\annotation as API;
use yii\db\ActiveQueryInterface;

interface BlogManagementContract
{
    /**
     * @API\Route(
     *     url="/v1/blog/posts/<id:[\w\-]+>",
     *     methods={"POST"},
     *     alias="post/create",
     * )
     * @API\Response(statusCode="201")
     * @param PostForm $form
     * @return PostInterface
     */
    public function createPost(PostForm $form): PostInterface;

    /**
     * @API\Route(
     *     url="/v1/blog/posts/<id:[\w\-]+>",
     *     methods={"PUT"},
     *     alias="post/edit"
     * )
     * @API\Response(statusCode="200")
     */
    public function editPost(string $id, PostForm $form): void;

    /**
     * @API\Route(
     *     url="/v1/blog/posts/remove/<id:[\w\-]+>",
     *     methods={"DELETE"},
     *     alias="post/remove"
     * )
     * @API\Response(statusCode="204")
     * @param string $id
     */
    public function removePost(string $id): void;

    /**
     * @API\Route(
     *     url="/v1/blog/posts/trash/<id:[\w\-]+>",
     *     methods={"PUT"},
     *     alias="post/trash"
     * )
     * @API\Response(statusCode="200")
     * @param string $id
     */
    public function trashPost(string $id): void;

    /**
     * @API\Route(
     *     url="/v1/blog/posts/restore/<id:[\w\-]+>",
     *     methods={"PUT"},
     *     alias="post/restore"
     * )
     * @API\Response(statusCode="200")
     * @param string $id
     */
    public function restorePostFromTrash(string $id): void;

    /**
     * @API\Route(
     *     url="/v1/blog/posts/publish/<id:[\w\-]+>",
     *     methods={"PUT"},
     *     alias="post/activate"
     * )
     * @API\Response(statusCode="200")
     * @param string $id
     */
    public function activatePost(string $id): void;

    /**
     * @API\Route(
     *     url="/v1/blog/posts/draft/<id:[\w\-]+>",
     *     methods={"PUT"},
     *     alias="post/draft"
     * )
     * @API\Response(statusCode="200")
     * @param string $id
     */
    public function draftPost(string $id): void;

    public function createPostQuery(): ActiveQueryInterface;

    public function createCategory(CategoryForm $form): CategoryInterface;

    public function editCategory(string $id, CategoryForm $form): void;

    public function removeCategory(string $id): void;

    public function createCategoryQuery(): ActiveQueryInterface;

    public function getAvailableCategories(bool $root = false, string $rootName = 'No category', ?CategoryInterface $category = null): array;

    public function editTag(string $id, TagForm $form): void;

    public function removeTag(string $id): void;

    public function createTagQuery(): ActiveQueryInterface;

    public function getDefinitionOf(string $className): string;

    /**
     * @API\Route(
     *     url="/v1/blog/posts/count",
     *     methods={"GET"},
     *     alias="post/count",
     * )
     * @throws Exception
     */
    public function postsCount(): int;

    /**
     * @API\Route(
     *     url="/v1/blog/posts/all/<offset:[\d\-]+>/<limit:[\d\-]+>",
     *     methods={"GET"},
     *     alias="post/range",
     * )
     * @throws Exception
     */
    public function getAllPostsByRange($offset, $limit): array;

    /**
     * @API\Route(
     *     url="/v1/blog/posts",
     *     methods={"GET"},
     *     alias="post/all",
     * )
     * @API\Serializer("api\serializers\SerializePost")
     * @throws Exception
     */
    public function getAllPosts(): DataProviderInterface;

    /**
     * @API\Route(
     *     url="/v1/blog/posts/by/category/<id:[\w\-]+>",
     *     methods={"GET"},
     *     alias="post/bycategory",
     * )
     * @API\Serializer("api\serializers\SerializePost")
     * @throws Exception
     */
    public function getAllPostsByCategory(string $id): DataProviderInterface;

    /**
     * @API\Route(
     *     url="/v1/blog/posts/by/tag/<id:[\w\-]+>",
     *     methods={"GET"},
     *     alias="post/bytag",
     * )
     * @API\Serializer("api\serializers\SerializePost")
     * @throws Exception
     */
    public function getAllPostsByTag(string $id): DataProviderInterface;

    /**
     * @API\Route(
     *     url="/v1/blog/posts/last/<limit:[\d\-]+>",
     *     methods={"GET"},
     *     alias="post/last",
     * )
     * @API\Serializer("api\serializers\SerializePost")
     * @throws Exception
     */
    public function getLastPost($limit): array;

    /**
     * @API\Route(
     *     url="/v1/blog/posts/popular/<limit:[\d\-]+>",
     *     methods={"GET"},
     *     alias="post/popular",
     * )
     * @API\Serializer("api\serializers\SerializePost")
     * @throws Exception
     */
    public function getPopularPost($limit): array;

    /**
     * @API\Route(
     *     url="/v1/blog/posts/<id:[\w\-]+>",
     *     methods={"GET"},
     *     alias="post/find"
     * )
     * @API\Serializer("api\serializers\SerializePost")
     * @param string $id
     * @return PostInterface|null
     */
    public function findPost(string $id): ?PostInterface;

    /**
     * @API\Route(
     *     url="/v1/blog/categories",
     *     methods={"GET"},
     *     alias="categories/all"
     * )
     * @API\Serializer("api\serializers\SerializeCategory")
     */
    public function findAllCategories(): DataProviderInterface;

    /**
     * @API\Route(
     *     url="/v1/blog/categories/<id:[\w\-]+>",
     *     methods={"GET"},
     *     alias="categories/find"
     * )
     * @API\Serializer("api\serializers\SerializeCategory")
     * @param string $id
     * @return CategoryInterface|null
     */
    public function findCategory(string $id): ?CategoryInterface;
}