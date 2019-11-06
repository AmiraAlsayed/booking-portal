<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketsCategories extends Model
{
    protected $table = 'ticket_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'currency'
    ];

    public static $createRules = [
        'name'   => 'required|unique:ticket_categories,name',
        'price'   => 'required|number',
        'currency' => 'string|unique:ticket_categories,currency'
    ];

    public static $createRulesMessages = [
        'name.required' => 'The name field is required.',
        'name.unique' => 'The ticket name must be unique.',
        'price.required' => 'The email field is required.',
        'price.number' => 'The ticket price must be number.',
        'currency.unique' => 'The currency must be unique.',
    ];

    public function UserTickets() {
        return $this->belongsTo('App\Models\UserTickets', 'ticket_id', 'id');
    }
}
