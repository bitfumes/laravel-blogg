<?php

namespace Bitfumes\Blogg\Tests\Feature;

use Bitfumes\Blogg\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Bitfumes\Blogg\Models\Blog;
use Bitfumes\Blogg\Http\Resources\BlogCollection;
use Illuminate\Support\Facades\Event;
use Bitfumes\Blogg\Events\UploadImageEvent;

class BlogTest extends TestCase
{
    use DatabaseMigrations;

    public function setup()
    {
        parent::setUp();
        $this->mediaLibraryConfigs();
        $this->tagIds = $this->createTag(2)->pluck('id');
    }

    /** @test */
    public function api_give_all_blog()
    {
        $blog = new BlogCollection($this->createPublishedBlog(3));
        // dd($blog->resolve());
        $res  = $this->post(route('blog.index'))
        ->assertOk()
        ->assertJsonStructure(['data', 'meta', 'links']);
    }

    /** @test */
    public function it_only_fetch_published_blogs()
    {
        $blog = $this->createPublishedBlog(10);
        $this->createBlog(3);
        $res = $this->post(route('blog.index'))->assertOk();
        $this->assertEquals(10, $res->baseResponse->getData()->meta->total);
    }

    /** @test */
    public function api_can_fetch_blog_by_category()
    {
        $category = $this->createCategory();
        $this->createBlog(2, ['published'=>true, 'category_id' => $category->id]);
        $this->createBlog(2, ['published'=>true]);
        $res = $this->postJson(route('blog.show.bycategory', $category->slug))->assertOk();
        $res->assertJsonStructure(['data', 'meta', 'links']);
        $this->assertEquals(2, $res->json()['meta']['total']);
    }

    /** @test */
    public function api_can_fetch_blog_by_tag()
    {
        $tag         = $this->createTag();
        $blogWithTag = $this->createPublishedBlog();
        $blogWithTag->tags()->sync($tag);
        $this->createPublishedBlog();
        $res = $this->postJson(route('blog.show.bytag', $tag->name))->assertOk();
        $res->assertJsonStructure(['data', 'meta', 'links']);
        $this->assertEquals(1, $res->json()['meta']['total']);
    }

    /** @test */
    public function api_can_give_single_blog_details()
    {
        $blog = $this->createPublishedBlog();
        $res  = $this->post($blog->path())
        ->assertOk()
        ->assertJsonStructure([
            'data' => ['title', 'path', 'body', 'image_path', 'thumb_path', 'published_at']
        ]);
    }

    /** @test */
    public function an_authorized_user_can_store_blog_and_tags()
    {
        $this->loggedInUser();
        $res = $this->post(route('blog.store'), [
            'title'          => 'New Title',
            'body'           => 'This is a body',
            'category_id'    => $this->createCategory()->id,
            'tag_ids'        => $this->tagIds
        ])->assertStatus(201);
        $this->assertDatabaseHas('blogs', ['slug'=>'new-title']);
        $this->assertDatabaseHas('taggables', ['tag_id'=>$this->tagIds->random()]);
    }

    /** @test */
    public function an_authorized_user_can_store_blog_along_with_image_if_given()
    {
        $photo = \Illuminate\Http\Testing\File::image('photo.jpg');
        $photo = 'data:image/png;base64,' . base64_encode(file_get_contents($photo));
        $this->loggedInUser();

        $res = $this->post(route('blog.store'), [
            'title'          => 'New Title',
            'body'           => 'This is a body',
            'category_id'    => $this->createCategory()->id,
            'image'          => $photo,
            'tag_ids'        => $this->tagIds
        ])->assertStatus(201);
        $blog = Blog::find(1);
        // dd($blog->getMedia()[0]->getUrl('thumb'));
        $this->assertDatabaseHas('media', ['model_id'=>1]);
    }

    /** @test */
    public function featured_image_is_uploaded_via_event()
    {
        $this->loggedInUser();

        Event::fake();
        $res = $this->post(route('blog.store'), [
            'title'          => 'New Title',
            'body'           => 'This is a body',
            'category_id'    => $this->createCategory()->id,
            'image'          => '$photo',
            'tag_ids'        => $this->tagIds,
            'slug'           => 'acb'
        ])->assertStatus(201);
        Event::assertDispatched(UploadImageEvent::class);
    }

    /** @test */
    public function an_authorized_user_can_update_blog_details()
    {
        $this->loggedInUser();
        $blog = $this->createBlog();
        $this->put(route('blog.update', $blog->slug), [
            'title'          => 'New Title',
            'body'           => $blog->body,
            'category_id'    => $blog->category->id,
            'tag_ids'        => $this->tagIds
        ])->assertStatus(202);
        $this->assertDatabaseHas('blogs', ['slug' => 'new-title']);
    }

    /** @test */
    public function an_authorized_user_can_delete_a_blog()
    {
        $this->loggedInUser();
        $blog = $this->createBlog();
        $this->deleteJson(route('blog.destroy', ['category'=>$blog->category, 'blog'=> $blog->slug]))->assertStatus(204);
        $this->assertDatabaseMissing('blogs', ['title'=>$blog->title]);
    }

    /** @test */
    public function an_authorized_can_provide_all_blogs_published_and_unpublished_both()
    {
        $this->loggedInUser();
        $this->createPublishedBlog(3);
        $blog = $this->createBlog();
        $res  = $this->post(route('blog.all'))->assertOk();
        $data = json_decode($res->getContent())->data;
        $this->assertEquals(4, count($data));
    }
}
