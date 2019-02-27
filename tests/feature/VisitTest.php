<?php

namespace Bitfumes\Blogg\Tests\Feature;

use Bitfumes\Blogg\Tests\TestCase;

class VisitTest extends TestCase
{
    public function setup():void
    {
        parent::setUp();
        $this->mediaLibraryConfigs();
        $this->tagIds = $this->createTag(2)->pluck('id');
    }

    /** @test */
    public function when_blog_is_visited_then_it_will_be_recorded()
    {
        $blog = $this->createPublishedBlog();
        $res  = $this->postJson($blog->path())->json();
        $this->assertEquals(1, $blog->visit('testing_blogs')->count());
    }
}
