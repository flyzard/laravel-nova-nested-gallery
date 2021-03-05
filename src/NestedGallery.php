<?php

namespace Flyzard\NestedGallery;

use Laravel\Nova\Contracts\RelatableField;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\ResourceRelationshipGuesser;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class NestedGallery extends Field implements RelatableField
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nested-gallery';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var \Closure|bool
     */
    public $showOnIndex = false;

    /**
     * Indicates if the element should be shown on the detail view.
     *
     * @var \Closure|bool
     */
    public $showOnDetail = false;

    /**
     * The field's relationship resource class.
     *
     * @var string
     */
    public $resourceClass;

    /**
     * The field's relationship resource name.
     *
     * @var string
     */
    public $resourceName;

    /**
     * The field's relationship name.
     *
     * @var string
     */
    public $viaRelationship;

    /**
     * From resource uriKey.
     *
     * @var string
     */
    public $viaResource;

    /**
     * Key name.
     *
     * @var string
     */
    public $keyName;

    /**
     * Condition to display the nested form.
     */
    public $displayIfCallback;

    /**
     * Return context
     *
     * @var Panel|Field|NestedForm
     */
    protected $returnContext;

    /**
     * Create a new nested form.
     *
     * @param  string  $name
     * @param  string|null  $attribute
     * @param  string|null  $resource
     * @return void
     */
    public function __construct(string $name, $attribute = null, $resource = null)
    {

        parent::__construct($name, $attribute);
        $resource = $resource ?? ResourceRelationshipGuesser::guessResource($name);

        $this->resourceClass = $resource;
        $this->resourceName = $resource::uriKey();
        $this->viaRelationship = $this->attribute;
        $this->keyName = (new $this->resourceClass::$model)->getKeyName();
        $this->viaResource = app(NovaRequest::class)->route('resource');
        $this->returnContext = $this;

        // Nova ^3.3.x need this to fix cannot add relation on create mode
        $this->resolve(app(NovaRequest::class)->model());
    }

    /**
     * Resolve the form fields.
     *
     * @param $resource
     * @param $attribute
     *
     * @return void
     */
    public function resolve($resource, $attribute = null)
    {
        $this->withMeta([
            'viaResourceId' => $resource->{$resource->getKeyName()},
        ]);
    }

    /**
     * Create a new NestedGallery instance.
     */
    public static function make(...$arguments)
    {
        return new NestedGalleryPanel(new static(...$arguments));
    }

    /**
     * Set the panel instance.
     */
    public function asPanel(Panel $panel)
    {
        $this->returnContext = $panel;
    }

    /**
     * Prepare the field for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(
            parent::jsonSerialize(),
            [
                'resourceName' => $this->resourceName,
                'viaRelationship' => $this->viaRelationship,
                'viaResource' => $this->viaResource,
                'keyName' => $this->keyName,
                'displayIf' => isset($this->displayIfCallback) ? call_user_func($this->displayIfCallback) : null
            ]
        );
    }
}
