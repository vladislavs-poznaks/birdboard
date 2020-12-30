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
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'notes'
    ];

    public $old = [];

    public function getExcerptAttribute()
    {
        return Str::limit($this->description);
    }

    public function recordActivity($description)
    {
        $this->activity()->create([
            'description' => $description,
            'changes' => $this->activityChanges($description),
        ]);
    }

    public function activityChanges($description)
    {
        if ($description === 'updated') {
            return [
                'before' => Arr::except(array_diff($this->old, $this->getAttributes()), 'updated_at'),
                'after' => Arr::except(array_diff($this->getAttributes(), $this->old), 'updated_at'),
            ];
        }
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
}
