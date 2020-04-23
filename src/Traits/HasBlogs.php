<?php

namespace Bitfumes\Blogg\Traits;

use Bitfumes\Blogg\Models\Blog;
use Illuminate\Support\Facades\Auth;

trait HasBlogs
{
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function isSuperAdmin()
    {
        if (Auth::getDefaultDriver() === 'admin') {
            return auth('admin')->check();
        }
        return false;
    }
}
