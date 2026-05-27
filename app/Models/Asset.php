<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'name',
        'purchase_date',
        'purchase_price',
        'purchase_transaction_id',
        'sale_date',
        'sale_price',
        'sale_transaction_id',
        'status'
    ];

    /**
     * Get the transaction associated with the purchase of this asset.
     */
    public function purchaseTransaction()
    {
        return $this->belongsTo(Transaction::class, 'purchase_transaction_id');
    }

    /**
     * Get the transaction associated with the sale of this asset.
     */
    public function saleTransaction()
    {
        return $this->belongsTo(Transaction::class, 'sale_transaction_id');
    }
}
