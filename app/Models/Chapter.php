<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable=['workshop_id','title','is_free'];
    protected $casts = ['is_free' => 'boolean'];

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }

    public function subChapters()
    {
        return $this->hasMany(SubChapter::class);
    }

    public function isFree():bool
    {
        return $this->is_free;
    }
}
