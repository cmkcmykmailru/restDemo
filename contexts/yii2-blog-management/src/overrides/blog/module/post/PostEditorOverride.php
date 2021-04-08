<?php

namespace grigor\blogManagement\overrides\blog\module\post;

use grigor\blog\module\post\api\dto\PostDto;
use grigor\blog\module\post\api\PostEditorInterface;
use grigor\blog\module\post\api\PostInterface;

/**
 * Class PostEditorOverride
 * Пример переопределения зависимости модуля
 * @package grigor\blogManagement\overrides\blog\module\post
 */
class PostEditorOverride implements PostEditorInterface
{
    public function edit(PostInterface $post, PostDto $dto): void
    {
        $post->category_id = $dto->categories->main;
        $post->title = $dto->title;
        $post->description = $dto->description;
        $post->content = $dto->content;
        $post->meta = $dto->meta;
    }
}
