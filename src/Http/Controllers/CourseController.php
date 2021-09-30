<?php

namespace Ajifatur\Campusnet\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Ajifatur\Campusnet\Models\Category;
use Ajifatur\Campusnet\Models\Course;
use Ajifatur\Campusnet\Models\Topic;
use Ajifatur\Campusnet\Models\Material;

class CourseController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get courses
        $courses = Course::all();

        // View
        return view('campusnet::admin/course/index', [
            'courses' => $courses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get categories
        $categories = Category::all();

        // View
        return view('campusnet::admin/course/create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:200',
            'category' => 'required',
            'description' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()){
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
            // Save the course
            $course = new Course;
            $course->category_id = $request->category;
            $course->user_id = 0;
            $course->name = $request->name;
            $course->description = $request->description;
            $course->slug = '';
            $course->image = '';
            $course->save();

            // Redirect
            return redirect()->route('admin.course.index')->with(['message' => 'Berhasil menambah data.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        // Get the course
        $course = Course::findOrFail($id);

        // View
        return view('campusnet::admin/course/detail', [
            'course' => $course
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get the course
        $course = Course::findOrFail($id);

        // Get categories
        $categories = Category::all();

        // View
        return view('campusnet::admin/course/edit', [
            'course' => $course,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:200',
            'category' => 'required',
            'description' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()){
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
            // Update the course
            $course = Course::find($request->id);
            $course->category_id = $request->category;
            $course->name = $request->name;
            $course->description = $request->description;
            $course->save();

            // Redirect
            return redirect()->route('admin.course.index')->with(['message' => 'Berhasil mengupdate data.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Get the course
        $course = Course::find($request->id);

        // Delete the course
        $course->delete();

        // Redirect
        return redirect()->route('admin.course.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
