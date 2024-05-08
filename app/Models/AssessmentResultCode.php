<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; use App\Core\Traits\SpatieLogsActivity;

class AssessmentResultCode extends Model
{
    use HasFactory;
    use SpatieLogsActivity;
    
    protected $fillable = ['result_code', 'result_code_description', 'pass_fail'];
}
