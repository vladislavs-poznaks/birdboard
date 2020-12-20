<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'body', 'completed'
    ];

    protected $casts = [
        'completed' => 'boolean'
    ];

    protected $touches = [
        'project'
    ];

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::created(function($task) {
            $task->project->recordActivity('created_task');
        });

        static::updated(function($task) {
            if($task->completed) {
                $task->project->recordActivity('completed_task');
            }
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
