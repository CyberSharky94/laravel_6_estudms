<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function getAllStudents()
    {
        $students = Student::all();

        return $students;
    }
}
