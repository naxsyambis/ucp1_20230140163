<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'name',
        'quantity',
        'price'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategoris()
    {
        return $this->hasMany(Kategori::class);
    }
}