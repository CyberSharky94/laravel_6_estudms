<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    // Table associated with the model
    protected $table = 'student_class';

    // Table columns associated with the model
    protected $fillable = [
        'stu_id',
        'class_id',
        'year',
        'status',
    ];

    /**
     * Get the Class associated with the StudentClass.
     */
    public function class()
    {
        $class = $this->hasOne('App\Classes', 'id', 'class_id');

        return $class;
    }

    /**
     * Get the Student associated with the StudentClass.
     */
    public function student()
    {
        $student = $this->hasOne('App\Student', 'id', 'stu_id');

        return $student;
    }

    public function getStatus()
    {
        if($this->status === 1)
        {
            return "Active";
        }
        else if($this->status === 0)
        {
            return "Inactive";
        }
    }

    public function changeDateFormat($date)
    {
        return date('d/m/Y', strtotime($date));
    }

    public function changeDateTimeFormat($date)
    {
        return date('d/m/Y H:i:s', strtotime($date));
    }
}
