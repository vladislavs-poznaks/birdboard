<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_project()
    {
        $project = Project::factory()->create();

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('created_project', $activity->first()->description);
            $this->assertEquals(1, $activity->count());

            $this->assertNull($activity->changes);
        });
    }

    /** @test */
    public function updating_a_project()
    {
        $project = Project::factory()->create();
        $originalTitle = $project->title;

        $project->update([
            'title' => 'Changed'
        ]);

        tap($project->activity->last(), function ($activity) use ($originalTitle) {
            $this->assertEquals('updated_project', $activity->description);
            $this->assertEquals(2, $activity->count());

            $expected = [
                'before' => ['title' => $originalTitle],
                'after' => ['title' => 'Changed'],
            ];

            $this->assertEquals($expected, $activity->changes);
        });
    }

    /** @test */
    public function creating_a_task()
    {
        $project = Project::factory()->create();
        $project->tasks()->create([
            'body' => 'Some task'
        ]);

        $this->assertEquals(2, $project->activity->count());

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('Some task', $activity->subject->body);
        });
    }

    /** @test */
    public function completing_a_task()
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

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }

    /** @test */
    public function incompleting_a_task()
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

        $this->actingAs($project->owner)
            ->put(route('tasks.update', [
                'project' => $project,
                'task' => $task
            ]), [
                'completed' => false
            ]);

        $this->assertEquals(4, $project->activity->count());
        $this->assertEquals('incompleted_task', $project->activity->last()->description);
    }

    /** @test */
    public function deleting_a_task()
    {
        $project = Project::factory()->create();
        $task = $project->tasks()->create([
            'body' => 'Some task'
        ]);

        $task->delete();

        $this->assertEquals(3, $project->activity->count());
    }
}
