<?php

namespace Ajifatur\Campusnet\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Ajifatur\Helpers\File as FileExt;
use Ajifatur\Campusnet\Models\Media;
use Ajifatur\Campusnet\Models\User;

class MediaController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            // Get the user
            $user = User::find($request->query('user_id'));

            // Get media
            if($user->role_id == role('instructor'))
                $media = Media::where('user_id','=',$user->id)->orderBy('name','asc')->get();
            else
                $media = Media::orderBy('name','asc')->get();

            // Get files in the directory
            $files = [];
            foreach($media as $file) {
                if(File::exists(public_path('assets/media/'.$file->name))) {
                    if($request->query('type') == 'file')
                        array_push($files, ['id' => $file->id, 'name' => $file->name]);
                    elseif($request->query('type') == 'uploaded-video') {
                        $file_info = file_info($file->name);
                        if(in_array($file_info['extension'], ['mp4', 'mkv', 'mov', 'avi', 'flv', 'mpg', 'mpeg'])) array_push($files, ['id' => $file->id, 'name' => $file->name]);
                    }
                }
            }

            // Response
            return response()->json($files, 200);
        }
        else {
            // Check the access
            has_access(method(__METHOD__), Auth::user()->role_id);

            // Get media
            if(Auth::user()->role_id == role('instructor'))
                $media = Media::where('user_id','=',Auth::user()->id)->orderBy('name','asc')->get();
            else
                $media = Media::orderBy('name','asc')->get();

            // View
            return view('campusnet::admin/media/index', [
                'media' => $media
            ]);
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
        has_access(method(__METHOD__), Auth::user()->role_id);
        
        // Get the media
        $media = Media::find($request->id);

        // Delete the media
        File::delete(public_path('assets/media/'.$media->name));
        $media->delete();

        // Redirect
        return redirect()->route('admin.media.index')->with(['message' => 'Berhasil menghapus data.']);
    }

    /**
     * Upload the resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        // Set the file name
        $file_name = FileExt::setName($_FILES['content']['name'], Media::pluck('name')->toArray());

        // Upload the file
        move_uploaded_file($_FILES['content']['tmp_name'], public_path('assets/media/'.$file_name));

        // Save the file
        $file = new Media;
        $file->user_id = $_POST['user_id'];
        $file->name = $file_name;
        $file->save();

        // Return
        return response()->json([
            'filename' => $file_name,
            'id' => $file->id
        ]);
    }
}
