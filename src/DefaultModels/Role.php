<?php

namespace Ajifatur\Campusnet\DefaultModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'is_admin', 'num_order'
    ];

    /**
     * Get the users for the role.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * The permissions that belong to the role.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id');
    }
}
