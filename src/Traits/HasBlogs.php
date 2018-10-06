<?php

namespace Bitfumes\Blogg\Traits;

use Bitfumes\Blogg\Models\Blog;

trait HasBlogs
{
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function createBlog($request)
    {
        $blog = $this->blogs()->create($request->except('image'));
        if ($request->has('image')) {
            $blog->addMedia($request->image)
                ->sanitizingFileName(function ($fileName) {
                    return strtolower(str_replace(['#', '/', '\\', ' '], '-', $fileName));
                })
                ->toMediaCollection();
        }
        return $blog;
    }
}
