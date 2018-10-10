<?php

namespace Bitfumes\Blogg\Tests\Feature;

use Bitfumes\Blogg\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LikeTest extends TestCase
{
    use DatabaseMigrations;
    protected $blog;

    public function setup()
    {
        parent::setUp();
        $this->loggedInUser();

        $this->blog = $blog = $this->createPublishedBlog();
        ;
    }

    /** @test */
    public function a_blog_can_be_liked()
    {
        $this->postJson(route('blog.like', $this->blog->slug))
        ->assertStatus(201);
        $this->assertDatabaseHas('likes', ['likeable_id'=>$this->blog->id]);
    }

    /** @test */
    public function a_blog_can_be_unliked()
    {
        $this->postJson(route('blog.like', $this->blog->slug));
        $this->assertDatabaseHas('likes', ['likeable_id'=>$this->blog->id]);
        $this->postJson(route('blog.unlike', $this->blog->slug))
        ->assertStatus(201);
        $this->assertDatabaseMissing('likes', ['likeable_id'=>$this->blog->id]);
    }
}
