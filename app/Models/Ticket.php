<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Config;

class Ticket extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $guarded = [];

    // public function events(){
    //        return $this->belongsTo(Event::class,'event_id', 'id');
    // //     // return Event::withoutGlobalScopes('tickets','venues')->get();
    // }

    // public function events() {
    //     return $this->belongsToMany(Ticket::class, 'tickets', 'ticket_id', 'event_id','venue_id');
    // }

    public function events(){
        return $this->belongsTo(Event::class,'event_id','id');
    }

    protected $casts = [
        'sale_start_date' => 'datetime',
        'sale_end_date' => 'datetime',
    ];

    protected $attributes = [
        'status' => true,
    ];
    
    public function price(): Attribute
    {
        $prefix = Config::get('app.currency');
        return Attribute::make(
            get: fn ($value) => $prefix.number_format($value, 0, ',', '.'),
            // set: fn ($value) => str_replace('.', 'Rp.', $value),
        );
    }
}
