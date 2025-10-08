<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subchapter extends Model
{
    protected $fillable = ['chapter_id','title','is_free','price'];
    protected $casts = ['is_free' => 'boolean'];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function isFree():bool
    {
        if($this->chapter && $this->chapter->isFree()) {return true;}
        return $this->is_free;
    }
}
