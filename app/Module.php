<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $primaryKey = 'id_module';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'module';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nom_module'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
