<?php

namespace Bitfumes\Blogg\Traits;

use Bitfumes\Blogg\Models\Blog;

trait HasBlogs
{
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
