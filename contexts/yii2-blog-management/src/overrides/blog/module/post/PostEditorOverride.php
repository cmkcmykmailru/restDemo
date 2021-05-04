<?php

namespace grigor\blogManagement\overrides\blog\module\post;

use grigor\blog\module\post\api\commands\PostCommand;
use grigor\blog\module\post\api\PostEditorInterface;
use grigor\blog\module\post\api\PostInterface;

/**
 * Class PostEditorOverride
 * Пример переопределения зависимости модуля
 * @package grigor\blogManagement\overrides\blog\module\post
 */
class PostEditorOverride implements PostEditorInterface
{
    public function edit(PostInterface $post, PostCommand $command): void
    {
        $post->category_id = $command->categories->main;
        $post->title = $command->title;
        $post->description = $command->description;
        $post->content = $command->content;
        $post->meta = $command->meta;
    }
}
