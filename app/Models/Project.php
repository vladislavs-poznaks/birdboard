<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Class Project
 * @mixin Builder
 */
class Project extends Model
{
    use HasFactory, RecordsActivity;

    protected $fillable = [
        'title',
        'description',
        'notes'
    ];

    protected static $recordableEvents = ['created', 'updated'];

    public function getExcerptAttribute()
    {
        return Str::limit($this->description);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id' );
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function invite(User $user)
    {
        $this->members()->attach($user);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members');
    }
}
