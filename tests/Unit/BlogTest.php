<?php

namespace Bitfumes\Blogg\Tests\Unit;

use Bitfumes\Blogg\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Bitfumes\Blogg\Models\Blog;

class BlogTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_blog_has_one_user_who_has_created_it()
    {
        $blog = $this->createBlog();
        $this->assertEquals(1, $blog->user->count());
    }

    /** @test */
    public function a_blog_know_its_path()
    {
        $blog     = $this->createBlog();
        $category = $blog->category;
        $this->assertEquals($blog->path(), asset("api/blog/{$category->slug}/{$blog->slug}"));
    }

    /** @test */
    public function a_blog_has_published_query_scope()
    {
        $blog1 = $this->createPublishedBlog();
        $blog2 = $this->createBlog();
        $this->assertEquals(1, Blog::published()->count());
    }

    /** @test */
    public function a_blog_also_get_its_own_image_and_thumb_path()
    {
        $this->mediaLibraryConfigs();
        $blog = $this->createBlog();
        $this->assertNull($blog->image_path);

        $photo = \Illuminate\Http\Testing\File::image('photo.jpg');
        $blog->addMedia($photo)->toMediaCollection();
        $this->assertNotNull($blog->fresh()->image_path);
        $this->assertNotNull($blog->fresh()->thumb_path);
    }
}
