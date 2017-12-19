<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Estimate;
use App\Product;

class EstimateDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['quantity', 'discount', 'total', 'show_dimensions', 'product_id'];

    public function estimate()
    {
        return $this->belongsTo('App\Estimate');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
