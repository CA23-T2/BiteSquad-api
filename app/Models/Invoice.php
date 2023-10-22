<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'pdf_link',
    ];

//    public function user()
//    {
//        return $this->belongsTo(User::class, 'user_id', 'user_id');
//    }
}
