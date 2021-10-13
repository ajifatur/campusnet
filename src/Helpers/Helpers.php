<?php

use Ajifatur\Campusnet\Models\Role;
use Ajifatur\Campusnet\Models\Permission;

// Has access
if(!function_exists('has_access')){
    function has_access($permission_code, $role, $isAbort = true){
        // Get the permission
        $permission = Permission::where('code','=',$permission_code)->first();

        // If the permission is not exist
        if(!$permission) {
            if($isAbort) abort(403);
            else return false;
        }

        // Check role permission
        if(in_array($role, $permission->roles()->pluck('role_id')->toArray())) {
            return true;
        }
        else {
            if($isAbort) abort(403);
            else return false;
        }
    }
}

// Role
if(!function_exists('role')) {
    function role($key) {
        // Get the role by ID
        if(is_int($key)) {
            $role = Role::find($key);
            return $role ? $role->name : null;
        }
        // Get the role by key
        elseif(is_string($key)) {
            $role = Role::where('code','=',$key)->first();
            return $role ? $role->id : null;
        }
        else return null;
    }
}

// Slug
if(!function_exists('slug')){
    function slug($string){
        $result = strtolower($string);
        $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
        $result = preg_replace("/\s+/", " ",$result);
        $result = str_replace(" ", "-", $result);
        return $result;
    }
}

// File info
if(!function_exists('file_info')) {
    function file_info($filename) {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $nameWithoutExtension = basename($filename, '.'.$extension);
        return [
            'name' => $filename,
            'nameWithoutExtension' => $nameWithoutExtension,
            'extension' => $extension
        ];
    }
}

// Quill HTML
if(!function_exists('quill_html')) {
    function quill_html($html, $path_to_image) {
        // Mengambil gambar dari tag "img"
        $dom = new \DOMDocument;
        @$dom->loadHTML($html);
        $images = $dom->getElementsByTagName('img');

        foreach($images as $key=>$image) {
            // Mengambil isi atribut "src"
            $code = $image->getAttribute('src');

			// Mencari gambar yang bukan URL
            if(filter_var($code, FILTER_VALIDATE_URL) == false){
                // Upload foto
                list($type, $code) = explode(';', $code);
                list(, $code)      = explode(',', $code);
                $code = base64_decode($code);
                $mime = str_replace('data:', '', $type);
                $image_name = date('Y-m-d-H-i-s').' ('.($key+1).')';
                $image_name = $image_name.'.'.mime_to_ext($mime)[0];
                file_put_contents($path_to_image.$image_name, $code);

                // Mengganti atribut "src"
                $image->setAttribute('src', URL::to('/').'/'.$path_to_image.$image_name);
            }
        }
        
        // Return
        return $dom->saveHTML();
    }
}