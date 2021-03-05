# Nova Nested Gallery

This package allows you to include a upload file field on the forms.

# Installation

```bash
composer require flyzard/nova-nested-gallery
```

# Attach a new relationship form to a resource

Simply add a NestedGallery into your fields. The first parameter must be an existing NovaResource class and the second parameter (optional) must be an existing HasOneOrMany relationship in your model.

```php
namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\Password;
// Add use statement here.
use Flyzard\NestedGallery\NestedGallery;

class User extends Resource
{
    ...
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Gravatar::make(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:6')
                ->updateRules('nullable', 'string', 'min:6'),

            // Add NestedGallery here.
            NestedGallery::make('ProductPhotos'),
        ];
    }
```
