<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    protected $fillable = ['sku','name','slug','description','price','old_price','stock','status','category_id'];
    public function images() { return $this->hasMany(ProductImage::class); }
    public function variants() { return $this->hasMany(ProductVariant::class); }
    public function category() { return $this->belongsTo(Category::class); }
}
