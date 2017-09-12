<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Setting;

class Currency extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['title', 'code', 'symbol', 'precision'];

    /**
     * Get the setting of the currency.
     */
    public function setting()
    {
        return $this->hasOne('App\Setting');
    }
}
