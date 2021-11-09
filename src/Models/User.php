<?php

namespace Ajifatur\Campusnet\Models;

class User extends \Ajifatur\FaturHelper\Models\User
{
    /**
     * Get the courses for the user.
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Get the socmeds for the user.
     */
    public function socmeds()
    {
        return $this->hasMany(Socmed::class);
    }

    /**
     * The course history that belong to the course.
     */
    public function course_history()
    {
        return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id');
    }
}
