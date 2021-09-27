<?php

namespace Ajifatur\Campusnet\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'courses';

    /**
     * Fill the model with an array of attributes.
     *
     * @param  array  $attributes
     * @return $this
     *
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    protected $fillable = ['name', 'description', 'slug', 'image'];

    /**
     * Get the category that owns the course.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
    /**
     * Get the user that owns the course.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
