<?php

namespace UniSharp\Sluggable;

use Illuminate\Database\Eloquent\Builder;

trait Sluggable
{
    protected $slugKey = 'slug';
    protected $slugSeparator = '-';
    protected $slugGenerator = SlugGenerator::class;

    public static function bootSluggable()
    {
        static::creating(function ($model) {
            $model->setAttribute($model->getSlugKeyName(), $model->generateSlug());
        });
    }

    public function getSlugKeyName()
    {
        return $this->slugKey;
    }

    public function getSlugKey()
    {
        return $this->getAttribute($this->getSlugKeyName());
    }

    public function getSlugSeparator()
    {
        return $this->slugSeparator;
    }

    public function getSlugGenerator()
    {
        return new $this->slugGenerator($this->getSlugSeparator());
    }

    public function generateSlug()
    {
        return $this->getSlugGenerator()->generate($this->getSlugSource());
    }

    abstract public function getSlugSourceName();

    public function getSlugSource()
    {
        return $this->getAttribute($this->getSlugSourceName());
    }

    public function scopeWhereSlug(Builder $query, $slug)
    {
        return $query->where($this->getSlugKeyName(), $slug);
    }

    public static function findBySlug($slug, $columns = ['*'])
    {
        return static::whereSlug($slug)->first($columns);
    }

    public static function findBySlugOrFail($slug, $columns = ['*'])
    {
        return static::whereSlug($slug)->firstOrFail($columns);
    }
}
