<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Mengaktifkan fitur timestamps otomatis (created_at dan updated_at).
     */
    public $timestamps = true;

    /**
     * Mendefinisikan kolom mana saja yang boleh diisi secara massal (mass assignment).
     */
    protected $fillable = [
        'user_id',     
        'category_id', 
        'name',       
        'quantity',    
        'price'       
    ];

    /**
     * Menunjukkan bahwa satu produk dimiliki oleh satu User (Owner).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Menunjukkan bahwa satu produk termasuk dalam satu kategori tertentu.
     * 'category_id' digunakan sebagai foreign key di tabel products.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'category_id');
    }
}