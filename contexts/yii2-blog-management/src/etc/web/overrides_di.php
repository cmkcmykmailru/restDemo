<?php

use grigor\blog\module\post\api\PostEditorInterface;
use grigor\blogManagement\overrides\blog\module\post\PostEditorOverride;

return [
    'definition' => [],
    'singleton' => [
        PostEditorInterface::class => PostEditorOverride::class,
    ]
];