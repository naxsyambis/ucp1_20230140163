<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Kategori - Mewakili tabel 'kategoris' di database.
 */
class Kategori extends Model
{
    protected $fillable = ['name'];

    /** Product::class: Menghubungkan ke model Product.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}