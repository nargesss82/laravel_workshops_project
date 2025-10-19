<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    use HasFactory;

    protected $fillable=['teacher_id','title','description','status'];

    public function teacher()
    {
        return $this->belongsTo(User::class,'teacher_id');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function enrollments()    // هرکارگاه میتونه چندتا ثبتنامی داشته باشه ولی هر ثبتنام مربوط به یه کارگاهه
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()  //هرکارگاه میتونه چندتا دانش اموز داشته باشه
    {
        return $this->belongsToMany(User::class,'enrollments');
    }

    public function isActive():bool
    {
        return $this->status==='active';
    }
}
