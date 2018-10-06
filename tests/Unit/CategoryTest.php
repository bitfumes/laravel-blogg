<?php

namespace Bitfumes\Blog\Tests\Unit;

use Bitfumes\Blogg\Tests\TestCase;

class CategoryTest extends TestCase
{
    /** @test */
    public function a_category_has_many_blog()
    {
        $category = $this->createCategory();
        $blog1 = $this->createBlog(1, ['category_id'=>$category->id]);
        $blog2 = $this->createBlog(1, ['category_id'=>$category->id]);
        $this->assertEquals(2, $category->blogs->count());
    }
}
