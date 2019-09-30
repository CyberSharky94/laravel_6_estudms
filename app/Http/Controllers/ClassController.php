<?php

namespace App\Http\Controllers;

use App\Classes;
use App\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    private function rules()
    {
        // Rules
        $rules = [
            'class_name' => 'required',
            'level_id' => 'required',
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
        $title = "Class Management";
        $limit_per_page = 10;
        $classes = Classes::latest()->paginate($limit_per_page);
        return view('classes.index', compact(
            'title',
            'classes',
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
        $title = "Create New Class";
        $return_route = 'class.index';

        // Get Level List
        $level_list = Level::pluck('level_name', 'id');

        return view('classes.create', compact(
            'title', 
            'return_route',
            'level_list',
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

        Classes::create($request->all());

        return redirect()->route('class.index')->with('success', 'Class has been created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Classes  $class
     * @return \Illuminate\Http\Response
     */
    public function show(Classes $class)
    {
        //
        $title = "View Class";
        $return_route = 'class.index';

        return view('classes.show', compact(
            'title', 
            'return_route',
            'class',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Classes  $class
     * @return \Illuminate\Http\Response
     */
    public function edit(Classes $class)
    {
        //
        $title = "Update Class";
        $return_route = 'class.index';

        // Get Level List
        $level_list = Level::pluck('level_name', 'id');

        return view('classes.edit', compact(
            'title', 
            'return_route',
            'class',
            'level_list',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Classes  $class
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classes $class)
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

        $class->update($request->all());

        return redirect()->route('class.index')->with('success', 'Class <b>'.$class->role_name.'</b> has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Classes  $class
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classes $class)
    {
        //
        $class_name = $class->class_name;

        $class->delete();

        return redirect()->route('class.index')->with('success', 'Class <b>'.$class_name.'</b> has been deleted successfully');
    }
}
