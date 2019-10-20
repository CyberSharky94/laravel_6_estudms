<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentImage extends Model
{
    protected $table = 'student_images';

    // Table columns associated with the model
    protected $fillable = [
        'si_filename',
        'si_filepath',
        'si_fullpath',
        'si_extension',
        'stu_id',
        'status',
    ];

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
