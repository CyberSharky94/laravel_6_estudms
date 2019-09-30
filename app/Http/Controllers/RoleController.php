<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    private function rules()
    {
        // Rules
        $rules = [
            'role_name' => 'required',
            'role_level' => 'required',
            'status' => 'required',
        ];

        return $rules;
    }

    private function rules_message()
    {
        $custom_message = [
            // // Custom Messages
            // 'role_name.required' => 'Ruangan Nama perlu diisi',
            // 'role_level.required' => 'Ruangan Butiran perlu diisi',
            // 'status.required' => 'Ruangan Harga perlu diisi',
        ];

        return $custom_message;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = "Role Management";
        $limit_per_page = 10;
        $roles = Role::latest()->paginate($limit_per_page);
        return view('roles.index', compact(
            'title',
            'roles',
            ))->with('i', (request()->input('page', 1) - 1) * $limit_per_page);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "Create New Role";
        $return_route = 'role.index';

        return view('roles.create', compact(
            'title', 
            'return_route',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make(
            $request->all(), $this->rules(), $this->rules_message(),
        );

        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        Role::create($request->all());

        return redirect()->route('role.index')->with('success', 'Role has been created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $Role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
        $title = "View Role";
        $return_route = 'role.index';

        return view('roles.show', compact(
            'title', 
            'return_route',
            'role',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $Role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
        $title = "Update Role";
        $return_route = 'role.index';

        return view('roles.edit', compact(
            'title', 
            'return_route',
            'role',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $Role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
        $validator = Validator::make(
            $request->all(), $this->rules(), $this->rules_message(),
        );

        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $role->update($request->all());

        return redirect()->route('role.index')->with('success', 'Role <b>'.$role->role_name.'</b> has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $Role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
        $role_name = $role->role_name;

        $role->delete();

        return redirect()->route('role.index')->with('success', 'Role <b>'.$role_name.'</b> has been deleted successfully');
    }
}
