<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Client;
use App\User;
use App\EstimateDetail;
use App\Email;

class Estimate extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'folio',
        'status',
        'currency_id',
        'expiration',
        'notes',
        'observations',
        'subtotal',
        'discount',
        'save',
        'total',
        'client_id',
        'user_id'
    ];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function estimate_details()
    {
        return $this->hasMany('App\EstimateDetail');
    }

    public function emails()
    {
        return $this->hasMany('App\Email');
    }
}
