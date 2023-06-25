<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\Country;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Query\Search\SearchableRelation;
use Laravel\Nova\Http\Requests\NovaRequest;


class Ticket extends Resource
{
    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        return '/resources/'.static::uriKey();
    }

    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        return '/resources/'.static::uriKey();
    }
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Ticket>
     */
    public static $model = \App\Models\Ticket::class;

    /**
     * Get the searchable columns for the resource.
     *
     * @return array
     */
    public static function searchableColumns()
    {
        return ['tittle', new SearchableRelation('events','id','event_id')];
    }
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'tittle';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'slug','tittle','events','tickets'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            // ID::make()->sortable(),
            Slug::make('Slug')
            ->from('tittle')
            ->rules('required')
            ->updateRules('required','unique:events,slug,{{resourceId}}')
            ->creationRules('unique:events,tittle,{{resourceId}}')
            ->withMeta(['extraAttributes' => ['readonly' => true]])
            ->showOnPreview()
            ->sortable()->hideFromIndex(),

            belongsTo::make('Events','events',Event::class)
                ->sortable()->searchable()->showOnPreview()
                ->help('Search the Events'),
                
            // BelongsTo::make('Events','events')->sortable()->showOnPreview(),
            Text::make('Ticket Tittle', 'tittle')
            ->rules('required')
            ->updateRules('required','unique:tickets,tittle,{{resourceId}}')
            ->creationRules('unique:tickets,tittle,{{resourceId}}')
            ->sortable()->showOnPreview()
            ->help('Type your Ticket Tittle'),
            Number::make('Price (Rp.)', 'price')->min(100)->step(100),
            // Money::make('Price')->locale('id-ID')->storedInMinorUnits(),
            // Number::make('price')->min(100)->max(1000)->step(100),
            // AdvancedNumber::make('Price')
            // ->prefix('Rp.')->sortable()->showOnPreview(),
            Number::make('Quantity')->min(1)
            ->sortable()->showOnPreview(),
            Markdown::make('Description'),
            Number::make('Buying Limit', 'customer_limit')->min(0)
            ->sortable()->showOnPreview(),
            DateTime::make('Sale Start Date', 'sale_start_date')
            ->displayUsing(fn ($value) => $value ? $value->format('d/m/Y, g:ia') : '')
            ->sortable()->showOnPreview(),
            DateTime::make('Sale End Date', 'sale_end_date')
            ->displayUsing(fn ($value) => $value ? $value->format('d/m/Y, g:ia') : '')
            ->sortable()->showOnPreview(),
            Boolean::make('Donation?', 'is_donation'),
            Boolean::make('Status'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
