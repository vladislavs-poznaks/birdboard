<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->signIn();

        $project = Project::factory()->create([
            'owner_id' => auth()->id()
        ]);

        $this->post(route('projects.show', $project) . '/tasks', [
            'body' => 'Test Body'
        ])
            ->assertRedirect(route('projects.show', $project));

    }

    /** @test */
    public function a_task_can_be_seen_on_project_page()
    {
        $this->signIn();

        $project = Project::factory()->create([
            'owner_id' => auth()->id()
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id
        ]);

        $this->get(route('projects.show', $project))
            ->assertSee($task->body);
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn();

        $project = Project::factory()->create([
            'owner_id' => auth()->id()
        ]);

        $this->post(route('tasks.store', $project), [
            'body' => '',
        ])->assertSessionHasErrors('body');
    }
}