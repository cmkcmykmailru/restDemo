<?php

namespace grigor\tests;

use grigor\blog\module\post\Post;
use grigor\blogManagement\services\forms\TagsForm;
use PHPUnit\Framework\TestCase;

class TagsFormTest extends TestCase
{
    public function testInitial()
    {
        $form = new TagsForm(null, [
            'tags' => [
                'name1',
                'name2',
                'name3',
            ]
        ]);
        self::assertIsArray($form->tags);
        self::assertCount(3, $form->tags);
        self::assertEquals(true, $form->validate());
        self::assertContains('name1', $form->tags);
        self::assertContains('name2', $form->tags);
        self::assertContains('name3', $form->tags);
    }

    public function testIncorrect()
    {
        $form = new TagsForm(null, [
            'tags' => [
                1,
                2,
            ]
        ]);
        self::assertEquals(false, $form->validate());
    }

    public function testCorrect()
    {
        $post = $this->createMock(Post::class);
        $post->method('__get')->with('tags')->willReturn([
            ['name' => 'name1'],
            ['name' => 'name2'],
            ['name' => 'name3']
        ]);

        $form = new TagsForm($post);
        self::assertEquals(true, $form->validate());
        self::assertContains('name1', $form->tags);
        self::assertContains('name2', $form->tags);
        self::assertContains('name3', $form->tags);
    }

    /**
     * может быть пустой
     */
    public function testEmpty()
    {
        $form = new TagsForm();
        self::assertEquals(true, $form->validate());
    }
}