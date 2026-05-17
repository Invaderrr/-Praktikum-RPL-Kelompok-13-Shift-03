<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminStocking extends Model
{
    protected $table = 'admin_stockking';

    protected $primaryKey = 'id_admin';

    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'foto',

    ];
}