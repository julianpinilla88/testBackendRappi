<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstUser extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'est_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nom_est_user'];
}
