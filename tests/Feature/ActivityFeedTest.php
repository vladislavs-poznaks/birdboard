<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_project_records_activity()
    {
        $project = Project::factory()->create();

        $this->assertEquals(1, $project->activity->count());

        $this->assertEquals('created', $project->activity->first()->description);
    }

    /** @test */
    public function updating_a_project_records_activity()
    {
        $project = Project::factory()->create();
        $project->update([
            'title' => 'Changed'
        ]);

        $this->assertEquals(2, $project->activity->count());
        $this->assertEquals('updated', $project->activity->last()->description);
    }

    /** @test */
    public function creating_a_task_records_project_activity()
    {
        $project = Project::factory()->create();
        $project->tasks()->create([
            'body' => 'Some task'
        ]);

        $this->assertEquals(2, $project->activity->count());
        $this->assertEquals('created_task', $project->activity->last()->description);
    }

    /** @test */
    public function completing_a_task_records_project_activity()
    {
        $project = Project::factory()->create();
        $task = $project->tasks()->create([
            'body' => 'Some task'
        ]);

        $this->actingAs($project->owner)
            ->put(route('tasks.update', [
                'project' => $project,
                'task' => $task
            ]), [
                'completed' => true
            ]);

        $this->assertEquals(3, $project->activity->count());
        $this->assertEquals('completed_task', $project->activity->last()->description);
    }
}
