<?php

namespace Bitfumes\Blogg\Tests;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Bitfumes\Blogg\Traits\HasBlogs;

class User extends Authenticatable
{
    use HasBlogs;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
