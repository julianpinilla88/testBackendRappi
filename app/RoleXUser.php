<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleXUser extends Model
{
    protected $primaryKey = 'id_role_xuser';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'role_xuser';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_role', 'id_user', 'create_date', 'modified_date'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
