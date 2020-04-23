<?php

namespace Bitfumes\Blogg\Tests\Feature;

use Bitfumes\Blogg\Tests\TestCase;

class UserBlogTest extends TestCase
{
    public function setup(): void
    {
        parent::setup();
        $user = $this->createUser();
        $this->actingAs($user);
        $this->tagIds = $this->createTag(2)->pluck('id');
    }

    /** @test */
    public function user_can_get_its_own_blogs_only()
    {
        $blogs = $this->createBlog(2, ['user_id' => auth()->id()]);
        $this->createBlog();
        $res = $this->post(route('user.blog'));
        $this->assertEquals(2, count($res->json()['data']));
    }
}
