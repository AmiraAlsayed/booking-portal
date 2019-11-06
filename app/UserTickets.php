<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTickets extends Model
{
    protected $table = 'user_tickets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'ticket_id',
    ];

    public static $createRules = [
        'user_id'   => 'required|exists:users,id',
        'ticket_id'   => 'required|exists:ticket_categories,id'
    ];

    public static $createRulesMessages = [
        'user_id.required' => 'The name field is required.',
        'user_id.exists' => 'The id of the user provided does not exist.',
        'ticket_id.required' => 'The email field is required.',
        'ticket_id.exists' => 'The id of the ticket provided does not exist.',
    ];

    public function users() {
        return $this->belongsTo('App\Models\UserTickets', 'id', 'user_id');
    }

    public function tickets() {
        return $this->belongsTo('App\Models\UserTickets', 'id', 'ticket_id');
    }
}
