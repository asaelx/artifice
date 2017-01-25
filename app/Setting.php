<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Picture;
use App\Currency;

class Setting extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'title',
        'owner',
        'email',
        'phone',
        'store_url',
        'address',
        'observations',
        'subject',
        'message',
        'tax',
        'discount_code',
        'currency_id',
        'sidebar_logo_id',
        'estimate_logo_id'
    ];

    /**
     * Get the logo of the Sidebar.
     */
    public function sidebar_logo()
    {
        return $this->belongsTo('App\Picture', 'sidebar_logo_id');
    }

    /**
     * Get the logo of the Estimate PDF.
     */
    public function estimate_logo()
    {
        return $this->belongsTo('App\Picture', 'estimate_logo_id');
    }

    /**
     * Get the currency of the Settings.
     */
    public function currency()
    {
        return $this->belongsTo('App\Currency');
    }
}
