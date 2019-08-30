<?php

namespace Bitfumes\Blogg\Tests\Feature;

use Bitfumes\Blogg\Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BlogTest extends TestCase
{
    use DatabaseMigrations;

    public function setup():void
    {
        parent::setUp();
        $this->tagIds = $this->createTag(2)->pluck('id');
    }

    /** @test */
    public function api_give_all_blog()
    {
        $blog = $this->createPublishedBlog(23);
        $this->loggedInUser();
        $blog[0]->likeIt();
        // DB::enableQueryLog();
        $res  = $this->post(route('blog.index'))
        ->assertSuccessful()
        ->assertJsonStructure(['data', 'meta', 'links']);
        // dd(DB::getQueryLog());
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
        $this->createBlog(20, ['published'=>true, 'category_id' => $category->id]);
        $this->createBlog(2, ['published'=>true]);
        // DB::enableQueryLog();
        $res = $this->postJson(route('blog.show.bycategory', $category->slug))->assertOk();
        // dd(DB::getQueryLog());
        $res->assertJsonStructure(['data', 'meta', 'links']);
        $this->assertEquals(20, $res->json()['meta']['total']);
    }

    /** @test */
    public function api_can_fetch_blog_by_tag()
    {
        $tag         = $this->createTag();
        $blogWithTag = $this->createPublishedBlog();
        $blogWithTag->tags()->sync($tag);
        $this->createPublishedBlog();
        // DB::enableQueryLog();
        $res = $this->postJson(route('blog.show.bytag', $tag->name))->assertOk();
        // dd(DB::getQueryLog());
        $res->assertJsonStructure(['data', 'meta', 'links']);
        $this->assertEquals(1, $res->json()['meta']['total']);
    }

    /** @test */
    public function api_can_give_single_blog_details()
    {
        $blog = $this->createPublishedBlog();
        // DB::enableQueryLog();
        $this->post($blog->path())
        ->assertOk()
        ->assertJsonStructure([
            'data' => ['title', 'path', 'body', 'image', 'published_at'],
        ]);
        // dd(DB::getQueryLog());
    }

    /** @test */
    public function an_authorized_user_can_store_blog_and_tags()
    {
        $this->loggedInUser();
        // DB::enableQueryLog();
        $res = $this->post(route('blog.store'), [
            'title'          => 'New Title',
            'body'           => 'This is a body',
            'category_id'    => $this->createCategory()->id,
            'image'          => 'asf',
            'tag_ids'        => $this->tagIds,
        ])->assertStatus(201);
        // dd(DB::getQueryLog());
        $this->assertDatabaseHas('blogs', ['slug'=>'new-title']);
        $this->assertDatabaseHas('taggables', ['tag_id'=>$this->tagIds->random()]);
    }

    /** @test */
    public function while_storing_blog_it_also_store_image()
    {
        Storage::fake();
        $image             = \Illuminate\Http\Testing\File::image('image.jpg');
        $image             = base64_encode(file_get_contents($image));

        $this->loggedInUser();
        $res = $this->post(route('blog.store'), [
            'title'          => 'New Title',
            'body'           => 'This is a body',
            'image'          => "data:image/png;base64,{$image}",
            'category_id'    => $this->createCategory()->id,
            'tag_ids'        => $this->tagIds,
        ])->assertStatus(201)->json();
        Storage::disk('public')->assertExists($res['image'] . '.jpg');
        $this->assertDatabaseHas('blogs', ['title' =>'New Title']);
        $this->removeImage($res['image']);
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
            'tag_ids'        => $this->tagIds,
            'image'          => 'sdf',
        ])->assertStatus(202);
        $this->assertDatabaseHas('blogs', ['slug' => 'new-title']);
    }

    /** @test */
    public function an_authorized_user_can_update_blog_image_with_old_image_removed()
    {
        $this->loggedInUser();
        Storage::fake();

        $image             = \Illuminate\Http\Testing\File::image('image.jpg');
        $image             = 'data:image/png;base64,' . base64_encode(file_get_contents($image));

        $res = $this->post(route('blog.store'), [
            'title'          => 'New Title',
            'body'           => 'This is a body',
            'image'          => $image,
            'category_id'    => $this->createCategory()->id,
            'tag_ids'        => $this->tagIds,
        ])->assertStatus(201)->json();
        $oldPath           = $res['image'];
        Storage::disk('public')->assertExists($res['image'] . '.jpg');

        $res               = $this->putJson(route('blog.update', 'new-title'), [
            'id'             => 1,
            'title'          => 'New Title',
            'body'           => 'This is a body',
            'image'          => $image,
            'category_id'    => $this->createCategory()->id,
            'tag_ids'        => $this->tagIds,
        ])->assertSuccessful()->json();

        Storage::disk('public')->assertExists($res['image'] . '.jpg');
        Storage::disk('public')->assertMissing($oldPath . '.jpg');
        $this->removeImage($res['image']);
    }

    /** @test */
    public function an_authorized_user_can_delete_a_blog_with_image_on_storage()
    {
        $this->loggedInUser();
        Storage::fake();

        $image             = \Illuminate\Http\Testing\File::image('image.jpg');
        $image             = 'data:image/png;base64,' . base64_encode(file_get_contents($image));

        $blog = $this->post(route('blog.store'), [
            'title'          => 'New Title',
            'body'           => 'This is a body',
            'image'          => $image,
            'category_id'    => $this->createCategory()->id,
            'tag_ids'        => $this->tagIds,
        ])->assertStatus(201)->json();
        $oldPath           = $blog['image'];

        $this->deleteJson(route('blog.destroy', ['category'=>$blog['category']['slug'], 'blog'=> $blog['slug']]))->assertStatus(204);
        Storage::disk('public')->assertMissing($blog['image'] . '.jpg');
        $this->assertDatabaseMissing('blogs', ['title'=>$blog['title']]);
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
