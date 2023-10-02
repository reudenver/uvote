<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Election extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'election_course')->withTimestamps();
    }

    public function partylists()
    {
        return $this->belongsToMany(PartyList::class, 'election_party_list')->withTimestamps();
    }
}
