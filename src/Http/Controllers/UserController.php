<?php

namespace Ajifatur\Campusnet\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\Helpers\DateTime as DateTimeExt;
use Ajifatur\Campusnet\Models\User;
use Ajifatur\Campusnet\Models\Role;

class UserController extends \App\Http\Controllers\Controller
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

        // Get users
        $users = User::all();

        // View
        return view('campusnet::admin/user/index', [
            'users' => $users
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

        // Get roles
        $roles = Role::all();

        // View
        return view('campusnet::admin/user/create', [
            'roles' => $roles
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
            'birthdate' => 'required',
            'gender' => 'required',
            'phone_number' => 'required|numeric',
            'email' => 'required|email|unique:users',
            'username' => 'required|alpha_dash|min:4|unique:users',
            'password' => 'required|min:6',
            'role' => 'required',
            'status' => 'required'
        ]);
        
        // Check errors
        if($validator->fails()){
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
            // Save the user
            $user = new User;
            $user->role_id = $request->role;
            $user->name = $request->name;
            $user->birthdate = DateTimeExt::change($request->birthdate);
            $user->gender = $request->gender;
            $user->phone_number = $request->phone_number;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->status = $request->status;
            $user->photo = '';
            $user->email_verified = 1;
            $user->last_visit = null;
            $user->save();

            // Redirect
            return redirect()->route('admin.user.index')->with(['message' => 'Berhasil menambah data.']);
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

        // Get the user
        $user = User::findOrFail($id);

        // Get roles
        $roles = Role::all();

        // View
        return view('campusnet::admin/user/edit', [
            'user' => $user,
            'roles' => $roles,
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
            'birthdate' => 'required',
            'gender' => 'required',
            'phone_number' => 'required|numeric',
            'email' => [
                'required', 'email', Rule::unique('users')->ignore($request->id, 'id')
            ],
            'username' => [
                'required', 'alpha_dash', 'min:4', Rule::unique('users')->ignore($request->id, 'id')
            ],
            'password' => $request->password != '' ? 'min:6' : '',
            'role' => 'required',
            'status' => 'required'
        ]);
        
        // Check errors
        if($validator->fails()){
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else{
            // Update the user
            $user = User::find($request->id);
            $user->role_id = $request->role;
            $user->name = $request->name;
            $user->birthdate = DateTimeExt::change($request->birthdate);
            $user->gender = $request->gender;
            $user->phone_number = $request->phone_number;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = $request->password != '' ? bcrypt($request->password) : $user->password;
            $user->status = $request->status;
            $user->save();

            // Redirect
            return redirect()->route('admin.user.index')->with(['message' => 'Berhasil mengupdate data.']);
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
        
        // Get the user
        $user = User::find($request->id);

        // Delete the user
        $user->delete();

        // Redirect
        return redirect()->route('admin.user.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
