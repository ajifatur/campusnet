<?php

namespace Ajifatur\Campusnet\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Ajifatur\Campusnet\Models\Course;
use Ajifatur\Campusnet\Models\Topic;

class TopicController extends \App\Http\Controllers\Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $course_id
     * @return \Illuminate\Http\Response
     */
    public function create($course_id)
    {
        // Get the course
        $course = Course::findOrFail($course_id);

        // View
        return view('campusnet::admin/topic/create', [
            'course' => $course
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
            'description' => 'required'
        ]);
        
        // Check errors
        if($validator->fails()){
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
            // Get the latest topic
            $latest_topic = Topic::where('course_id','=',$request->course_id)->orderBy('num_order','desc')->first();

            // Save the topic
            $topic = new Topic;
            $topic->course_id = $request->course_id;
            $topic->name = $request->name;
            $topic->description = $request->description;
            $topic->num_order = $latest_topic ? $latest_topic->num_order + 1 : 1;
            $topic->save();

            // Redirect
            return redirect()->route('admin.course.detail', ['id' => $request->course_id])->with(['message' => 'Berhasil menambah data.']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $course_id
     * @param  int  $topic_id
     * @return \Illuminate\Http\Response
     */
    public function edit($course_id, $topic_id)
    {
        // Get the course
        $course = Course::findOrFail($course_id);

        // Get the topic
        $topic = Topic::where('course_id','=',$course_id)->findOrFail($topic_id);

        // View
        return view('campusnet::admin/topic/edit', [
            'course' => $course,
            'topic' => $topic,
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
            'description' => 'required'
        ]);
        
        // Check errors
        if($validator->fails()){
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
            // Update the topic
            $topic = Topic::find($request->id);
            $topic->name = $request->name;
            $topic->description = $request->description;
            $topic->save();

            // Redirect
            return redirect()->route('admin.course.detail', ['id' => $request->course_id])->with(['message' => 'Berhasil mengupdate data.']);
        }
    }

    /**
     * Remove the specified resource in storage.
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

    /**
     * Sort the resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        // Loop topics
        if(count($request->get('ids')) > 0) {
            foreach($request->get('ids') as $key=>$id) {
                $topic = Topic::find($id);
                if($topic) {
                    $topic->num_order = $key + 1;
                    $topic->save();
                }
            }

            echo 'Berhasil mengurutkan data.';
        }
        else echo 'Berhasil mengurutkan data.';
    }
}
