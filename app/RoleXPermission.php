<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleXPermission extends Model
{
    protected $primaryKey = 'id_role_xpermission';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'role_xpermission';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_role','id_permission','id_module'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
