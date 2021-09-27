<?php

namespace Ajifatur\Campusnet\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Ajifatur\Campusnet\Models\Course;
use Ajifatur\Campusnet\Models\Category;

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get the vacancy
        $vacancy = Vacancy::findOrFail($id);

        // View
        return view('admin/vacancy/edit', [
            'vacancy' => $vacancy
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
            'position' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()){
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
            // Get company
            $company = Position::find($request->position)->company;

            // Update the vacancy
            $vacancy = Vacancy::find($request->id);
            $vacancy->company_id = $company ? $company->id : 0;
            $vacancy->position_id = $request->position;
            $vacancy->start_date = generate_date_format($request->start_date, 'y-m-d');
            $vacancy->end_date = generate_date_format($request->end_date, 'y-m-d');
            $vacancy->save();

            // Redirect
            return redirect()->route('admin.vacancy.index')->with(['message' => 'Berhasil mengupdate data.']);
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
        // Get the vacancy
        $vacancy = Vacancy::find($request->id);

        // Delete the vacancy
        $vacancy->delete();

        // Redirect
        return redirect()->route('admin.vacancy.index')->with(['message' => 'Berhasil menghapus data.']);
    }

    /**
     * Show the registration form.
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function registrationForm($code)
    {
        // Get religions
        $religions = Religion::all();

        // Get relationships
        $relationships = Relationship::all();

        // View
        return view('admin/vacancy/register', [
            'religions' => $religions,
            'relationships' => $relationships,
        ]);
    }
}
