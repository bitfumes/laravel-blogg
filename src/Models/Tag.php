<?php

namespace Bitfumes\Blogg\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function blogs()
    {
        return $this->morphedByMany(Blog::class, 'taggable');
    }

    public static function store($data)
    {
        $data['name'] = strtolower(trim($data['name']));
        return Self::create($data);
    }

    public function getRouteKeyName()
    {
        return 'name';
    }
}
