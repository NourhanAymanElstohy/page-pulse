<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interval extends Model
{
    use HasFactory;
    protected $guarded = [];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function book()
    {
        return $this->belongsTo(Book::class);
    }
}
