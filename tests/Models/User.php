<?php

namespace HFarm\Encryptable\Tests\Models;

use HFarm\Encryptable\Encryptable;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
    ];

    /**
     * The attributes that should sbe cast.
     *
     * @var array
     */
    protected $casts = [
        'first_name' => Encryptable::class,
        'last_name' => Encryptable::class,
    ];
}
