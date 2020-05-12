<?php

namespace Bitfumes\Blogg\Policies;

use Bitfumes\Blogg\Tests\User;
use Bitfumes\Blogg\Models\Blog;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    public function create($user)
    {
        return true;
    }

    public function update(User $user, Blog $blog)
    {
        return $user->id == $blog->user_id;
    }

    public function edit(User $user, Blog $blog)
    {
        return $user->id == $blog->user_id;
    }

    public function delete($user, Blog $blog)
    {
        return $user->id == $blog->user_id;
    }
}
