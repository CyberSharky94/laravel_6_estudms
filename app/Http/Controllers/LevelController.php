<?php

namespace App\Http\Controllers;

use App\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
{
    private function rules()
    {
        // Rules
        $rules = [
            'level_name' => 'required',
            'level_number' => 'required',
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
        $title = "Student Level Management";
        $limit_per_page = 10;
        $levels = Level::latest()->paginate($limit_per_page);
        return view('levels.index', compact(
            'title',
            'levels'
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
        $title = "Create New Level";
        $return_route = 'level.index';

        return view('levels.create', compact(
            'title', 
            'return_route'
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

        Level::create($request->all());

        return redirect()->route('level.index')->with('success', 'Level has been created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Level  $Level
     * @return \Illuminate\Http\Response
     */
    public function show(Level $level)
    {
        //
        $title = "View Level";
        $return_route = 'level.index';

        return view('levels.show', compact(
            'title', 
            'return_route',
            'level'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Level  $Level
     * @return \Illuminate\Http\Response
     */
    public function edit(Level $level)
    {
        //
        $title = "Update Level";
        $return_route = 'level.index';

        return view('levels.edit', compact(
            'title', 
            'return_route',
            'level'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Level  $Level
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Level $level)
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

        $level->update($request->all());

        return redirect()->route('level.index')->with('success', 'Level <b>'.$level->level_name.'</b> has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Level  $Level
     * @return \Illuminate\Http\Response
     */
    public function destroy(Level $level)
    {
        //
        $level_name = $level->level_name;

        $level->delete();

        return redirect()->route('level.index')->with('success', 'Level <b>'.$level_name.'</b> has been deleted successfully');
    }
}
