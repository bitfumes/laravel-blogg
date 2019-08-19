<?php

namespace Bitfumes\Blogg\Tests\Unit;

use Bitfumes\Blogg\Models\Blog;
use Bitfumes\Blogg\Tests\TestCase;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BlogTest extends TestCase
{
    use DatabaseMigrations;

    public function setup():void
    {
        parent::setUp();
    }

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
    public function a_blog_know_its_like_counts()
    {
        $this->loggedInUser();
        $blog     = $this->createBlog();
        $blog->likeIt();
        $this->assertEquals(1, $blog->fresh()->countLikes());
    }

    /** @test */
    public function a_blog_has_published_query_scope()
    {
        $blog1 = $this->createPublishedBlog();
        $blog2 = $this->createBlog();
        $this->assertEquals(1, Blog::published()->count());
    }

    /** @test */
    public function a_blog_can_give_markdown_parsed_body()
    {
        $blog = $this->createBlog(1, ['body' => 'Hello']);
        $body = Markdown::convertToHtml($blog[0]->body);
        $this->assertEquals('<p>Hello</p>
', $body);
    }
}
