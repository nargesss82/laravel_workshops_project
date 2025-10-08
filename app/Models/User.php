<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use HasApiTokens,Notifiable;
    protected $fillable = ['name','phone','role'];
    protected $guarded = ['verification_code'];

    public function workshopsTaught()
    {
        return $this->hasMany(Workshop::class,'teacher_id');
    }
    public function enrollments()//این کاربر (دانش‌آموز) چند ثبت‌نام (Enrollment) دارد.
    {
        return $this->hasMany(Enrollment::class);
    }

    public function workshopsEnrolled()    //این کاربر (دانش‌آموز) در چند کارگاه شرکت کرده
    {
        return $this->belongsToMany(Workshop::class,'enrollments');
    }

    public  function isStudent():bool
    {
        return $this->role==='student';
    }
    public  function isTeacher():bool
    {
        return $this->role==='teacher';
    }
    public  function isAdmin():bool
    {
        return $this->role==='admin';
    }



}
