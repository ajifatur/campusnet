<?php

namespace Ajifatur\Campusnet\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Socmed extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'socmeds';

    /**
     * Fill the model with an array of attributes.
     *
     * @param  array  $attributes
     * @return $this
     *
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    protected $fillable = ['provider_id', 'provider_name'];

    /**
     * Get the user that owns the socmed.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
