<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Estimate;
use App\Picture;
use App\Brand;
use App\Category;
use App\EstimateDetail;

class Product extends Model
{
    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'dimensions',
        'code',
        'stock',
        'regular_price',
        'sale_price',
        'brand_id',
        'category_id'
    ];

    public function estimate_details()
    {
        return $this->hasMany('App\EstimateDetail');
    }

    public function pictures()
    {
        return $this->belongsToMany('App\Picture')
                    ->withTimestamps();
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
