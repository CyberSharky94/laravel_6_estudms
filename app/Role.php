<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable = [
        'role_name',
        'role_level',
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
