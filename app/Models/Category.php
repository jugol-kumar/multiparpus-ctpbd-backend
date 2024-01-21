<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    protected $guarded= ['id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childrens(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->select(['id', 'parent_id', 'name', 'slug']);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parents(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }


    public function childrenRecursive(): HasMany
    {
        return $this->childrens()->with(['childrenRecursive']);
    }

    public function getPhotoAttribute($value){
        return $this->attributes['image'] = $value ? Storage::url($value) : NULL;
    }

    public function parentCategory(){
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function products(){
        return $this->hasMany(Product::class, 'category_id');
    }

}
