<?php

namespace Ajifatur\Campusnet\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\Campusnet\DefaultModels\Permission;
use Ajifatur\Campusnet\DefaultModels\Role;

class PermissionController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Check the access
        has_access(method(__METHOD__), Auth::user()->role_id);

        // Get permissions
        $permissions = Permission::orderBy('num_order','asc')->get();

        // Get roles
        $roles = Role::all();

        // View
        return view('campusnet::admin/permission/index', [
            'permissions' => $permissions,
            'roles' => $roles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check the access
        has_access(method(__METHOD__), Auth::user()->role_id);

        // View
        return view('campusnet::admin/permission/create');
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
            'code' => 'required|unique:permissions'
        ]);
        
        // Check errors
        if($validator->fails()){
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
            // Get the latest permission
            $latest_permission = Permission::orderBy('num_order','desc')->first();

            // Save the permission
            $permission = new Permission;
            $permission->name = $request->name;
            $permission->code = $request->code;
            $permission->num_order = $latest_permission ? $latest_permission->num_order + 1 : 1;
            $permission->save();

            // Redirect
            return redirect()->route('admin.permission.index')->with(['message' => 'Berhasil menambah data.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check the access
        has_access(method(__METHOD__), Auth::user()->role_id);

        // Get the permission
        $permission = Permission::findOrFail($id);

        // View
        return view('campusnet::admin/permission/edit', [
            'permission' => $permission
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
            'code' => [
                'required', Rule::unique('permissions')->ignore($request->id, 'id')
            ],
        ]);
        
        // Check errors
        if($validator->fails()){
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
            // Update the permission
            $permission = Permission::find($request->id);
            $permission->name = $request->name;
            $permission->code = $request->code;
            $permission->save();

            // Redirect
            return redirect()->route('admin.permission.index')->with(['message' => 'Berhasil mengupdate data.']);
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
        
        // Get the permission
        $permission = Permission::find($request->id);

        // Delete the permission
        $permission->delete();

        // Redirect
        return redirect()->route('admin.permission.index')->with(['message' => 'Berhasil menghapus data.']);
    }

    /**
     * Sort the resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        // Loop permissions
        if(count($request->get('ids')) > 0) {
            foreach($request->get('ids') as $key=>$id) {
                $permission = Permission::find($id);
                if($permission) {
                    $permission->num_order = $key + 1;
                    $permission->save();
                }
            }

            echo 'Berhasil mengurutkan data.';
        }
        else echo 'Terjadi kesalahan dalam mengurutkan data.';
    }

    /**
     * Change the resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function change(Request $request)
    {
        // Get the permission
        $permission = Permission::find($request->permission);

        // Change status
        if($permission) {
            $permission->roles()->toggle($request->role);
            echo 'Berhasil mengganti status hak akses.';
        }
        else {
            echo 'Terjadi kesalahan dalam mengganti status hak akses.';
        }
    }
}
