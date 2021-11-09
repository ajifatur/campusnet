<?php

namespace Ajifatur\Campusnet\DefaultModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'num_order'
    ];

    /**
     * The roles that belong to the permission.
     */
    public function roles()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'permission_id', 'role_id');
    }
}
