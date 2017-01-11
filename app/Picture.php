<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Setting;
use App\Product;

class Picture extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['original_name', 'url'];

    /**
     * Get the setting of the logo.
     */
    public function sidebar_logo_setting()
    {
        return $this->hasOne('App\Setting', 'sidebar_logo_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product')
                    ->withTimestamps();
    }
}
