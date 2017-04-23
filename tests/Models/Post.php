<?php

namespace Tests\Models;

use UniSharp\Sluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Sluggable;

    protected $fillable = ['title', 'content'];

    public function getSlugSourceName()
    {
        return 'title';
    }
}
