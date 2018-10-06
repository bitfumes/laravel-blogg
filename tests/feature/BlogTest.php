<?php

namespace Bitfumes\Blogg\Tests\Feature;

use Bitfumes\Blogg\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Bitfumes\Blogg\Http\Resources\BlogResource;
use Bitfumes\Blogg\Models\Blog;

class BlogTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function api_give_all_blog()
    {
        $blog = BlogResource::collection($this->createBlog(3));
        $res = $this->get(route('blog.index'))
        ->assertOk()
        ->assertJsonStructure(['data', 'meta', 'links']);
    }

    /** @test */
    public function it_only_fetch_published_blogs()
    {
        $blog = $this->createPublishedBlog(10);
        $this->createBlog(3);
        $res = $this->get(route('blog.index'))->assertOk();
        $this->assertEquals(10, $res->baseResponse->getData()->meta->total);
    }

    /** @test */
    public function api_can_give_single_blog_details()
    {
        $blog = $this->createPublishedBlog();
        $this->get(route('blog.show', $blog->slug))
        ->assertOk()
        ->assertJsonStructure([
            'data' => ['title', 'path']
        ]);
    }

    /** @test */
    public function an_authorized_user_can_store_blog()
    {
        $this->loggedInUser();
        $res = $this->post(route('blog.store'), [
            'title'       => 'New Title',
            'body'        => 'This is a body',
            'category_id' => $this->createCategory()->id
        ])->assertStatus(201);
        $this->assertDatabaseHas('blogs', ['slug'=>'new-title']);
    }

    /** @test */
    public function an_authorized_user_can_store_blog_along_with_image_if_given()
    {
        $this->mediaLibraryConfigs();
        $photo = \Illuminate\Http\Testing\File::image('photo.jpg');
        $this->loggedInUser();
        $res = $this->post(route('blog.store'), [
            'title'       => 'New Title',
            'body'        => 'This is a body',
            'category_id' => $this->createCategory()->id,
            'image'       => $photo
        ])->assertStatus(201);
        $blog = Blog::find(1);
        // dd($blog->getMedia()[0]->getUrl('thumb'));
        $this->assertDatabaseHas('media', ['model_id'=>1]);
    }

    /** @test */
    public function an_authorized_user_can_update_blog_details()
    {
        $this->loggedInUser();
        $blog = $this->createBlog();
        $this->put(route('blog.update', $blog->slug), [
            'title'       => 'New Title',
            'body'        => $blog->body,
            'category_id' => $blog->category->id
        ])->assertStatus(202);
        $this->assertDatabaseHas('blogs', ['slug' => 'new-title']);
    }

    /** @test */
    public function an_authorized_user_can_delete_a_blog()
    {
        $this->loggedInUser();
        $this->mediaLibraryConfigs();
        $blog = $this->createBlog();
        $this->deleteJson(route('blog.destroy', $blog->slug))->assertStatus(204);
        $this->assertDatabaseMissing('blogs', ['title'=>$blog->title]);
    }
}
