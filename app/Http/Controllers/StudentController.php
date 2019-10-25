<?php

namespace App\Http\Controllers;

use App\Classes;
use App\Level;
use App\Student;
use App\StudentClass;
use App\StudentImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    private function rules()
    {
        // Rules
        $rules = [
            'stu_name' => 'required',
            'stu_dob' => 'required',
            'stu_phone' => 'required',
            'level_id' => 'required',
            'current_class_id' => 'required',
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
    public function index(Request $request)
    {
        $title = "Student Management";

        $students = new Student(); // Init Student model

        $levels = Level::all(); // Level list

        // Searching Process
        $url_data = $request->query(); // Assign GET data

        if(!empty($url_data['search_stu_name']))
        {
            $students = $students->where('stu_name', 'ilike', '%'.$url_data['search_stu_name'].'%');
        }
        if(!empty($url_data['search_level']))
        {
            $students = $students->join('classes', 'students.current_class_id', '=', 'classes.id')
                                 ->where('classes.level_id', $url_data['search_level']);
        }
        // END: Searching Process

        // Table Pagination Process
        if(!empty($url_data['limit']))
        {
            $limit_per_page = $url_data['limit'];
        } else {
            $limit_per_page = 10;
        }

        $students = $students->paginate($limit_per_page);
        // END: Table Pagination Process

        return view('students.index', compact(
            'title',
            'students',
            'levels',
            'limit_per_page'
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
        $title = "Add New Student";
        $return_route = 'student.index';

        // Get Level List
        $level_list = Level::pluck('level_name', 'id');

        return view('students.create', compact(
            'title', 
            'return_route',
            'level_list'
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

        // If validation pass ----------v

        // Prepare data
        $data = $request->all();

        $student = Student::create($request->all()); // Add new Student

        // Add new StudentClass based on Student->id and Classes->id
        $student_class = StudentClass::create([
            'stu_id' => $student->id,
            'class_id' => $request->current_class_id,
            'year' => date('Y'),
            'status' => $request->status,
        ]);

        if($request->hasfile('student_image')) // Check if file exist
        {
            $file = $request->file('student_image'); // Get file from request

            $file_info['getClientOriginalName'] = $file->getClientOriginalName(); // Get Original File Name
            $file_info['getClientOriginalExtension'] = $file->getClientOriginalExtension(); // Get File Extension
            $file_info['getRealPath'] = $file->getRealPath(); // Get File Real Path
            $file_info['getMimeType'] = $file->getMimeType(); // Get File Mime Type

            $new_filename = 'student_image_'.date('Ymd_his').'.'.$file_info['getClientOriginalExtension']; // Generate new filename
            $file_path = '/public/student_images/'; // Assign Storage path

            $uploaded_file_data = $file->storeAs($file_path, $new_filename); // Move file to Storage location

            // Add new StudentImage record if upload success
            if(!empty($uploaded_file_data))
            {
                $student_image = StudentImage::create([
                    'si_filename' => $new_filename,
                    'si_filepath' => $file_path,
                    'si_fullpath' => $file_path.$new_filename,
                    'si_extension' => $file_info['getClientOriginalExtension'],
                    'stu_id' => $student->id,
                    'status' => 1,
                ]);
            }
        }

        return redirect()->route('student.index')->with('success', 'Student has been added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
        $title = "View Student";
        $return_route = 'student.index';

        $student_classes = $student->student_class;

        return view('students.show', compact(
            'title', 
            'return_route',
            'student',
            'student_classes'
        ))->with('i', 0);
    }

    public function ajax_show(Request $request)
    {
        if($request->ajax())
        {
            $student = Student::find($request->stu_id);
        
            $title = "View Student";
            $return_route = 'student.index';

            $student_classes = $student->student_class;
            $student_image = $student->student_image;

            $is_ajax = true;

            return view('students.show_ajax', compact(
                'title', 
                'return_route',
                'student',
                'student_classes',
                'student_image',
                'is_ajax'
            ))->with('i', 0);

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
        $title = "Update Student";
        $return_route = 'student.index';

        // Init variables
        $current_class_id = $student->current_class_id;
        $current_level_id = $student->class->level->id;

        // Get Level List
        $level_list = Level::pluck('level_name', 'id');

        // Get Class List By Current Level
        $classes = Classes::where('level_id', $current_level_id)->get();
        $class_list = $classes->pluck('class_name', 'id');

        return view('students.edit', compact(
            'title', 
            'return_route',
            'student',
            'current_level_id',
            'level_list',
            'class_list'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
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

        // If validation pass ----------v
        $student->update($request->all()); // Update Student record

        // Get Existing Student Class Data for Current Year
        $student_class = StudentClass::where('year', date('Y'))->first();
        if(!empty($student_class))
        {
            // If exist
            $student_class->class_id = $request->current_class_id;
            $student_class->save();

        } else {

            // If not exist
            $student_class = StudentClass::create([
                'stu_id' => $student->id,
                'class_id' => $request->current_class_id,
                'year' => date('Y'),
                'status' => $request->status,
            ]);

        }

        if($request->hasfile('student_image'))  // Check if file exist
        {
            $file = $request->file('student_image'); // Get file from request

            $file_info['getClientOriginalName'] = $file->getClientOriginalName(); // Get Original File Name
            $file_info['getClientOriginalExtension'] = $file->getClientOriginalExtension(); // Get File Extension
            $file_info['getRealPath'] = $file->getRealPath(); // Get File Real Path
            $file_info['getMimeType'] = $file->getMimeType(); // Get File Mime Type

            $new_filename = 'student_image_'.date('Ymd_his').'.'.$file_info['getClientOriginalExtension']; // Generate new filename
            $file_path = '/public/student_images/'; // Assign Storage path

            $uploaded_file_data = $file->storeAs($file_path, $new_filename); // Move file to Storage location

            // If Upload success
            if(!empty($uploaded_file_data))
            {
                $student_image = $student->student_image; // Get StudentImage record for the Student
                if(!empty($student_image))
                {
                    // Update Existing Image 
                    $student_image->si_filename = $new_filename;
                    $student_image->si_filepath = $file_path;
                    $student_image->si_fullpath = $file_path.$new_filename;
                    $student_image->si_extension = $file_info['getClientOriginalExtension'];
                    $student_image->update();
                } else {
                    // Store New Image if Not Exist
                    $student_image = StudentImage::create([
                        'si_filename' => $new_filename,
                        'si_filepath' => $file_path,
                        'si_fullpath' => $file_path.$new_filename,
                        'si_extension' => $file_info['getClientOriginalExtension'],
                        'stu_id' => $student->stu_id,
                        'status' => 1,
                    ]);
                }
            }
        }

        return redirect()->route('student.index')->with('success', 'Student <b>'.$student->stu_name.'</b> has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $stu_name = $student->stu_name;

        // == Delete all related foreign class objects

        // Model: StudentClass
        $student_classes = $student->student_class;
        $student_classes_id = $student_classes->pluck('id');
        StudentClass::destroy($student_classes_id);

        // Model: Delete StudentImage
        $student_image = $student->student_image;
        if(!empty($student_image))
        {
            $student_image_id = $student_image->pluck('id');
            StudentImage::destroy($student_image_id);
        }

        // == END: Delete all related foreign class objects

        $student->delete();

        return redirect()->route('student.index')->with('success', 'Student <b>'.$stu_name.'</b> has been deleted successfully');
    }

    // AJAX Methods Section

    public function ajaxGetClassList(Request $request)
    {
        if($request->ajax() and !empty($request->level_id))
        {
            $level_id = $request->level_id;
            $classes = Classes::where('level_id', $level_id)->get();

            if($classes->isNotEmpty())
            {
                $class_list = $classes->pluck('class_name', 'id');
                $html = '<option class="class_id_item" value="" selected disabled>Choose Class</option>';
                foreach ($class_list as $class_id => $class_name) {
                    $html .= '<option class="class_id_item" value="'.$class_id.'">'.$class_name.'</option>';
                }
            } else {
                $html = '<option class="class_id_item" value="" selected disabled>No Class Available</option>';
            }

            return $html;
        }
    }
}
