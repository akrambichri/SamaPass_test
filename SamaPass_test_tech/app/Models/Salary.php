<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;


/**
 * Class Profile
 * @package App\Models
 * @version Nov 21, 2020, 6:35 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection
 * @property string employee
 * @property integer amount
 */
class Salary extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Notifiable;


    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $fillable = [
        'employee',
        'amount'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'employee' => 'required|email:rfc',
        'amount' => 'required|numeric',
    ];

    public function routeNotificationForMail($notification){
        return $this->employee;
    }
}
