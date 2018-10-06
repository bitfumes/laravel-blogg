<?php

namespace Bitfumes\Blogg\Tests\Unit;

use Bitfumes\Blogg\Tests\TestCase;
use Bitfumes\Blogg\Tests\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_ca_have_many_traits()
    {
        $user = factory(User::class)->create();
        $blogs = $this->createBlog(10, ['user_id'=>$user->id]);
        $this->assertEquals($user->blogs->count(), 10);
    }
}
