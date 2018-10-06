<?php

namespace Bitfumes\Blogg\Tests\Feature;

use Bitfumes\Blogg\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function api_can_give_all_category()
    {
        $this->createCategory(5);
        $this->getJson(route('category.index'))
        ->assertOk()
        ->assertJsonStructure(['data']);
    }

    /** @test */
    public function api_can_give_single_category()
    {
        $category = $this->createCategory();
        $this->getJson(route('category.show', $category->slug))->assertJsonStructure(['data']);
    }

    /** @test */
    public function api_can_store_new_category()
    {
        $this->loggedInUser();
        $this->postJson(route('category.store'), ['name'=>'Laravel'])
        ->assertStatus(201);
        $this->assertDatabaseHas('categories', ['name'=>'Laravel']);
    }

    /** @test */
    public function api_can_update_category()
    {
        $this->loggedInUser();
        $category = $this->createCategory();
        $this->putJson(route('category.update', $category->slug), ['name'=>'Updated Name'])
        ->assertStatus(202);
        $this->assertDatabaseHas('categories', ['slug'=>'updated-name']);
    }

    /** @test */
    public function api_can_delete_category()
    {
        $this->loggedInUser();
        $category = $this->createCategory();
        $this->deleteJson(route('category.destroy', $category->slug))->assertStatus(204);
        $this->assertDatabaseMissing('categories', ['slug'=>$category->slug]);
    }
}
