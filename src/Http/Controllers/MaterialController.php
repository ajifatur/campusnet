<?php

namespace Ajifatur\Campusnet\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Ajifatur\Campusnet\Models\Course;
use Ajifatur\Campusnet\Models\Topic;
use Ajifatur\Campusnet\Models\Material;

class MaterialController extends \App\Http\Controllers\Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $course_id
     * @param  int  $topic_id
     * @return \Illuminate\Http\Response
     */
    public function create($course_id, $topic_id)
    {
        // Get the course
        $course = Course::findOrFail($course_id);

        // Get the topic
        $topic = Topic::findOrFail($topic_id);

        // View
        return view('campusnet::admin/material/create', [
            'course' => $course,
            'topic' => $topic
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
        ]);
        
        // Check errors
        if($validator->fails()){
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
            // Get the latest material
            $latest_material = Material::where('topic_id','=',$request->topic_id)->orderBy('num_order','desc')->first();

            // Save the material
            $material = new Material;
            $material->topic_id = $request->topic_id;
            $material->type_id = 0;
            $material->name = $request->name;
            $material->content = '';
            $material->num_order = $latest_material ? $latest_material->num_order + 1 : 1;
            $material->save();

            // Redirect
            return redirect()->route('admin.course.detail', ['id' => $request->course_id])->with(['message' => 'Berhasil menambah data.']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $course_id
     * @param  int  $topic_id
     * @param  int  $material_id
     * @return \Illuminate\Http\Response
     */
    public function edit($course_id, $topic_id, $material_id)
    {
        // Get the course
        $course = Course::findOrFail($course_id);

        // Get the topic
        $topic = Topic::where('course_id','=',$course_id)->findOrFail($topic_id);

        // Get the material
        $material = Material::where('topic_id','=',$topic_id)->findOrFail($material_id);

        // View
        return view('campusnet::admin/material/edit', [
            'course' => $course,
            'topic' => $topic,
            'material' => $material,
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
        ]);
        
        // Check errors
        if($validator->fails()){
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
            // Update the material
            $material = Material::find($request->id);
            $material->name = $request->name;
            $material->save();

            // Redirect
            return redirect()->route('admin.course.detail', ['id' => $request->course_id])->with(['message' => 'Berhasil mengupdate data.']);
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
        // Get the topic
        $topic = Topic::find($request->id);

        // Delete the topic
        $topic->delete();

        // Redirect
        return redirect()->route('admin.course.detail', ['id' => $topic->course_id])->with(['message' => 'Berhasil menghapus data.']);
    }
}
