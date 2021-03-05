<?php

namespace Flyzard\NestedGallery;

use Laravel\Nova\Panel;

class NestedGalleryPanel extends Panel
{
    /**
     * Nested form.
     * 
     * @var NestedGallery
     */
    protected $nestedGallery;

    /**
     * Constructor.
     */
    public function __construct(NestedGallery $nestedGallery)
    {
        $this->nestedGallery = $nestedGallery;

        $this->nestedGallery->asPanel($this);

        parent::__construct(__('Update Related :resource', ['resource' => $this->nestedGallery->name]), [$this->nestedGallery]);
    }

    /**
     * Getter.
     */
    public function __get($key)
    {
        return property_exists($this, $key) ? parent::__get($key) : $this->nestedGallery->$key;
    }

    /**
     * Setter.
     */
    public function __set($key, $value)
    {
        property_exists($this, $key) ? parent::__set($key, $value) : $this->nestedGallery->$key = $value;
    }

    /**
     * Caller.
     */
    public function __call($method, $arguments)
    {
        return method_exists($this, $method) ? parent::__call($method, $arguments) : call_user_func([$this->nestedGallery, $method], ...$arguments);
    }
}
