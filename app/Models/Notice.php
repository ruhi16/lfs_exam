<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $table = 'notices';

    protected $guarded = ['id'];

    // protected $fillable = [
    //     'title',
    //     'desc',
    //     'dop',
    //     'doe',
    //     'fileaddr',
    //     'is_active'
    // ];
    
}
