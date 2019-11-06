<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone_number',
    ];

    public static $createRules = [
        'name'   => 'required|string',
        'email'   => 'required|email',
        'phone_number'   => 'required|regex:/^[0-9 ]+$/|min:10|max:11',
        'ticket' => 'required'
    ];

    public static $createRulesMessages = [
        'name.required' => 'The name field is required.',
        'email.required' => 'The email field is required.',
        'ticket.required' => 'Please choose your ticket.',
        "phone_number.regex" => "The Phone number field must contain only numbers.",
        "phone_number.min" => "The Phone number must be of minimum 10 digits.",
        "phone_number.max" => "The Phone number must be of maximum 11 digits.",
    ];
    public function UserTickets() {
        return $this->belongsTo('App\Models\UserTickets', 'user_id', 'id');
    }
}
