<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'stock',
        'description',
        'barcode',
    ];

    public function invoiceDetails(): HasMany
    {
        return $this->hasMany(InvoiceDetail::class);
    }
}
