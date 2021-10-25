<?php

namespace Ajifatur\Campusnet\Http\Controllers\Site;

use Auth;
use Illuminate\Http\Request;
use Ajifatur\Campusnet\Models\Category;
use Ajifatur\Campusnet\Models\Course;

class CategoryController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get categories
        $categories = Category::paginate(12);

        // View
        return view('campusnet::site/category/index', [
            'categories' => $categories
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
        // Get the category
        $category = Category::where('slug','=',$slug)->firstOrFail();

        // Get courses
        $courses = Course::where('category_id','=',$category->id)->paginate(12);

        // View
        return view('campusnet::site/category/detail', [
            'category' => $category,
            'courses' => $courses
        ]);
    }
}
