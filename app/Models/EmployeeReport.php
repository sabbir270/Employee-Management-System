<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'check_in_time',
        'check_out_time',
        'date',
    ];



    // ...

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }


}
