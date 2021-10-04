<?php

namespace Ajifatur\Campusnet\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Ajifatur\Campusnet\Models\Course;

class MediaController extends \App\Http\Controllers\Controller
{
    /**
     * Upload the resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        // Get files in the directory
        $files = [];
        foreach(File::allFiles(public_path('assets/media')) as $file) {
            array_push($files, $file->getRelativePathname());
        }

        // Check the file in the directory
        $file_name = $_FILES['content']['name'];
        $i = 1;
        while(in_array($file_name, $files)) {
            // Recreate file name
            $i++;
            $file_info = file_info($_FILES['content']['name']);
            $file_name = $file_info['nameWithoutExtension'].' ('.$i.').'.$file_info['extension'];
        }

        // Upload file
        move_uploaded_file($_FILES['content']['tmp_name'], public_path('assets/media/'.$file_name));

        // Return
        return response()->json([
            'filename' => $file_name
        ]);
    }
}
