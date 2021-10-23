<?php

namespace Ajifatur\Campusnet\Http\Controllers\Site;

use Auth;
use Illuminate\Http\Request;
use Ajifatur\Campusnet\Models\Category;
use Ajifatur\Campusnet\Models\Course;

class HomeController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get categories
        $categories = Category::limit(6)->get();

        // Get courses
        $courses = Course::limit(4)->get();

        // View
        return view('campusnet::site/index', [
            'categories' => $categories,
            'courses' => $courses
        ]);
    }
}
