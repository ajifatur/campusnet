<?php

namespace Ajifatur\Campusnet\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Ajifatur\Campusnet\Helpers\Date;
use Ajifatur\Campusnet\Models\Course;
use Ajifatur\Campusnet\Models\Topic;
use Ajifatur\Campusnet\Models\Material;
use Ajifatur\Campusnet\Models\Type;
use Ajifatur\Campusnet\Models\Assignment;

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
        // Check the access
        has_access(generate_method(__METHOD__), Auth::user()->role_id);

        // Get the course
        $course = Course::findOrFail($course_id);

        // Get the topic
        $topic = Topic::findOrFail($topic_id);

        // Get types
        $types = Type::all();

        // View
        return view('campusnet::admin/material/create', [
            'course' => $course,
            'topic' => $topic,
            'types' => $types,
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
        // Content
        if($request->type_code == 'text'):
            $content_validator = ['content' => ''];
            $content = htmlentities(quill_html($request->content, 'assets/images/quill/'));
        elseif($request->type_code == 'uploaded-video'):
            $content_validator = ['content' => 'required'];
            $content = $request->content;
        elseif($request->type_code == 'youtube-video'):
            $content_validator = ['content' => 'required'];
            $content = $request->content;
        elseif($request->type_code == 'file'):
            $content_validator = ['content' => 'required'];
            $content = $request->content;
        elseif($request->type_code == 'assignment'):
            $content_validator = ['content.*' => 'required'];
        else:
            $content_validator = ['content' => ''];
            $content = $request->content;
        endif;

        // Validation
        $validator = Validator::make($request->all(), array_merge([
            'name' => 'required|max:200',
            'type' => 'required',
        ], $content_validator));
        
        // Check errors
        if($validator->fails()){
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
            // Get the latest material
            $latest_material = Material::where('topic_id','=',$request->topic_id)->orderBy('num_order','desc')->first();

            // If the content type is assignment
            if($request->type_code == 'assignment') {
                // Split date
                $date = Date::split($request->content['time']);

                // Save the assignment
                $assignment = new Assignment;
                $assignment->name = $request->content['name'];
                $assignment->description = $request->content['description'];
                $assignment->start_at = array_key_exists(0, $date) ? $date[0] : null;
                $assignment->end_at = array_key_exists(1, $date) ? $date[1] : null;
                $assignment->save();

                // Get the assignment id
                $content = $assignment->id;
            }

            // Save the material
            $material = new Material;
            $material->topic_id = $request->topic_id;
            $material->type_id = $request->type;
            $material->name = $request->name;
            $material->content = $content;
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
        // Check the access
        has_access(generate_method(__METHOD__), Auth::user()->role_id);

        // Get the course
        $course = Course::findOrFail($course_id);

        // Get the topic
        $topic = Topic::where('course_id','=',$course_id)->findOrFail($topic_id);

        // Get the material
        $material = Material::where('topic_id','=',$topic_id)->findOrFail($material_id);

        // Get the assignment
        $assignment = Assignment::find($material->content);

        // View
        return view('campusnet::admin/material/edit', [
            'course' => $course,
            'topic' => $topic,
            'material' => $material,
            'assignment' => $assignment,
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
        // Content
        if($request->type_code == 'text'):
            $content_validator = ['content' => ''];
            $content = htmlentities(quill_html($request->content, 'assets/images/quill/'));
        elseif($request->type_code == 'uploaded-video'):
            $content_validator = ['content' => 'required'];
            $content = $request->content;
        elseif($request->type_code == 'youtube-video'):
            $content_validator = ['content' => 'required'];
            $content = $request->content;
        elseif($request->type_code == 'file'):
            $content_validator = ['content' => 'required'];
            $content = $request->content;
        elseif($request->type_code == 'assignment'):
            $content_validator = ['content.*' => 'required'];
        else:
            $content_validator = ['content' => ''];
            $content = $request->content;
        endif;

        // Validation
        $validator = Validator::make($request->all(), array_merge([
            'name' => 'required|max:200',
        ], $content_validator));
        
        // Check errors
        if($validator->fails()){
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
            // If the content type is assignment
            if($request->type_code == 'assignment') {
                // Split date
                $date = Date::split($request->content['time']);
                
                // Update the assignment
                $assignment = Assignment::find($request->content['id']);
                $assignment->name = $request->content['name'];
                $assignment->description = $request->content['description'];
                $assignment->start_at = array_key_exists(0, $date) ? $date[0] : null;
                $assignment->end_at = array_key_exists(1, $date) ? $date[1] : null;
                $assignment->save();

                // Get the assignment id
                $content = $assignment->id;
            }

            // Update the material
            $material = Material::find($request->id);
            $material->name = $request->name;
            $material->content = $content;
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
        // Check the access
        has_access(generate_method(__METHOD__), Auth::user()->role_id);
        
        // Get the material
        $material = Material::find($request->id);

        // Delete the material
        $material->delete();

        // Redirect
        return redirect()->route('admin.course.detail', ['id' => $material->topic->course_id])->with(['message' => 'Berhasil menghapus data.']);
    }

    /**
     * Sort the resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        // Loop materials
        if(count($request->get('ids')) > 0) {
            foreach($request->get('ids') as $key=>$id) {
                $material = Material::find($id);
                if($material) {
                    $material->num_order = $key + 1;
                    $material->save();
                }
            }

            echo 'Berhasil mengurutkan data.';
        }
        else echo 'Terjadi kesalahan dalam mengurutkan data.';
    }
}
