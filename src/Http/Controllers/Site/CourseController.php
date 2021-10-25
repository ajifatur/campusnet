<?php

namespace Ajifatur\Campusnet\Http\Controllers\Site;

use Auth;
use Illuminate\Http\Request;
use Ajifatur\Campusnet\Models\Course;

class CourseController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get courses
        $courses = Course::has('category')->has('user')->paginate(12);

        // View
        return view('campusnet::site/course/index', [
            'courses' => $courses
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function detail($slug)
    {
        // Get the course
        $course = Course::has('user')->where('slug','=',$slug)->firstOrFail();

        // View
        return view('campusnet::site/course/detail', [
            'course' => $course
        ]);
    }

    /**
     * Display the activity of resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function activity($slug)
    {
        // Get the course
        $course = Course::has('user')->where('slug','=',$slug)->firstOrFail();

        // View
        return view('campusnet::site/course/activity', [
            'course' => $course
        ]);
    }

    /**
     * Register.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // Get the course
        $course = Course::find($request->id);

        // Check learners in the course
        if(!in_array(Auth::user()->id, $course->learners()->pluck('user_id')->toArray())) {
            $course->learners()->attach(Auth::user()->id);
        }

        // Redirect
        return redirect()->route('site.course.activity', ['slug' => $course->slug]);
    }
}
