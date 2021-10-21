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