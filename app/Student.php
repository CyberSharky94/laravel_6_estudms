<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $fillable = [
        'stu_name',
        'stu_dob',
        'stu_phone',
        'status',
        'si_id',
        'current_class_id',
    ];

    /**
     * Get the (current) Class associated with the Student.
     */
    public function class()
    {
        $class = $this->hasOne('App\Classes', 'id', 'current_class_id');

        return $class;
    }

    /**
     * Get the StudentImage associated with the Student.
     */
    public function student_image()
    {
        $student_image = $this->hasOne('App\StudentImage', 'id', 'si_id');

        return $student_image;
    }

    /**
     * Get the StudentClass(es) associated with the Student.
     */
    public function student_class()
    {
        $student_class = $this->hasMany('App\StudentClass', 'stu_id', 'id');

        return $student_class;
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
