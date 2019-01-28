<?php

namespace Bitfumes\Blog\Tests\Unit;

use Bitfumes\Blogg\Tests\TestCase;
use Bitfumes\Blogg\Models\Tag;

class TagTest extends TestCase
{
    /** @test */
    public function a_tag_has_many_blog()
    {
        $tag      = $this->createTag();
        $blog1    = $this->createBlog();
        $blog1->tags()->attach($tag);

        $blog2    = $this->createBlog();
        $blog2->tags()->attach($tag);

        $this->assertEquals(2, $tag->blogs->count());
    }

    /** @test */
    public function tag_knows_blog_count_assocciated_with_it()
    {
        $tag   = $this->createTag();
        $blog1 = $this->createBlog();
        $blog1->tags()->attach($tag);

        $this->assertEquals(1, $tag->blogs->count());
    }

    /** @test */
    public function a_blog_has_many_tags()
    {
        $tag1 = $this->createTag();
        $tag2 = $this->createTag();
        $blog = $this->createBlog();
        $blog->tags()->attach([$tag1->id, $tag2->id]);
        $this->assertEquals(2, $blog->tags->count());
    }

    /** @test */
    public function tag_is_deleted_on_deletion_of_blog()
    {
        $this->mediaLibraryConfigs();
        $blog         = $this->createBlog();
        $tags         = $this->createTag(2, []);
        $blog->tags()->attach($tags);
        $this->assertDatabaseHas('taggables', ['taggable_id'=>$blog->id]);
        $blog->delete();
        $this->assertDatabaseMissing('taggables', ['taggable_id'=>$blog->id]);
    }

    /** @test */
    public function tag_is_trimmed_before_saving()
    {
        Tag::store(['name'=>'  Laravel is Best ']);
        $this->assertDatabaseHas('tags', ['name'=>'laravel is best']);
    }
}
