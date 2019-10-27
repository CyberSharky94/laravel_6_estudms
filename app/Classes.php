<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Classes extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    //
    protected $fillable = [
        'class_name',
        'level_id',
        'status',
    ];

    /**
     * Get the Level associated with the Class.
     */
    public function level()
    {
        $level = $this->hasOne('App\Level', 'id', 'level_id');

        return $level;
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
