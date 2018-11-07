<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'iditems';
    protected $fillable = ['item_name', 'item_code', 'item_price','user_id'];
    protected $dates = ['created_at, updated_at, deleted_at'];
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
