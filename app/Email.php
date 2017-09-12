<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Estimate;

class Email extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'to',
        'subject',
        'message'
    ];

    public function estimate()
    {
        return $this->belongsTo('App\Estimate');
    }
}
