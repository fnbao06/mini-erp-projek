<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['trans_date','desc','amount','category_id'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function purchaseAsset()
    {
        return $this->hasOne(Asset::class, 'purchase_transaction_id');
    }

    public function saleAsset()
    {
        return $this->hasOne(Asset::class, 'sale_transaction_id');
    }
}
