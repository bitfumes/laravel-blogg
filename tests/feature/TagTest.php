<?php

namespace Bitfumes\Blogg\Tests\Feature;

use Bitfumes\Blogg\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TagTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function api_can_give_all_tags()
    {
        $this->createTag(5);
        $res = $this->getJson(route('tag.index'))
        ->assertOk()
        ->assertJsonStructure(['data']);
    }

    /** @test */
    public function api_can_give_single_tag()
    {
        $tag = $this->createtag();
        $this->getJson(route('tag.show', $tag->name))->assertJsonStructure(['data']);
    }

    /** @test */
    public function api_can_store_new_tag()
    {
        $this->loggedInUser();
        $this->postJson(route('tag.store'), ['name'=>'Laravel'])
        ->assertStatus(201);
        $this->assertDatabaseHas('tags', ['name'=>'laravel']);
    }

    /** @test */
    public function api_can_update_tag()
    {
        $this->loggedInUser();
        $tag = $this->createtag();
        $this->putJson(route('tag.update', $tag->name), ['name'=>'Updated Name'])
        ->assertStatus(202);
        $this->assertDatabaseHas('tags', ['name'=>'Updated Name']);
    }

    /** @test */
    public function api_can_delete_tag()
    {
        $this->loggedInUser();
        $tag = $this->createtag();
        $this->deleteJson(route('tag.destroy', $tag->name))->assertStatus(204);
        $this->assertDatabaseMissing('tags', ['name'=>$tag->name]);
    }
}
