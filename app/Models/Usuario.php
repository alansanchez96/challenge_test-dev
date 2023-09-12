<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'usuarios';

    protected $fillable = ['uid', 'first_name', 'last_name', 'email', 'password', 'address', 'phone', 'phone_2', 'postal_code', 'birth_date', 'gender'];
}
