<?php

namespace UniSharp\Sluggable;

class SlugGenerator
{
    protected $separator;

    public function __construct($separator)
    {
        $this->separator = $separator;
    }

    public function generate($source)
    {
        return preg_replace(
            "/({$this->separator})+/",
            '$1',
            strtolower(preg_replace('/[^A-Za-z0-9]/', $this->separator, $source))
        );
    }
}
