<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectsTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_can_not_add_tasks_to_projects()
    {
        $project = Project::factory()->create();

        $this->post(route('tasks.store', $project), [
            'body' => 'Test Body',
        ])->assertRedirect('login');

    }

    /** @test */
    public function only_the_owner_of_a_project_can_add_tasks_to_it()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->post(route('tasks.store', $project), [
            'body' => 'Test Body',
        ])
            ->assertStatus(403);
    }

    /** @test */
    public function only_the_owner_of_a_project_can_update_a_task()
    {
        $this->signIn();

        $project = ProjectFactory::withTasks(1)->create();

        $this->put(route('tasks.update', [$project, $project->tasks->first()]), [
            'body' => 'Changed task',
            'completed' => true
        ])
            ->assertStatus(403);
    }

    /** @test */
    public function a_project_can_have_tasks()
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->create();

        $this->post(route('projects.show', $project) . '/tasks', [
            'body' => 'Test Body'
        ])
            ->assertRedirect(route('projects.show', $project));

    }

    /** @test */
    public function a_project_task_can_be_updated()
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        $this->put(route('tasks.update', [$project, $project->tasks->first()]), [
            'body' => 'Changed task',
            'completed' => true
        ])
            ->assertRedirect(route('projects.show', $project));

        $this->assertDatabaseHas('tasks', [
            'id' => $project->tasks->first()->id,
            'body' => 'Changed task',
            'completed' => true
        ]);
    }

    /** @test */
    public function a_task_can_be_seen_on_project_page()
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        $this->get(route('projects.show', $project))
            ->assertSee($project->tasks->first()->body);
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->create();

        $this->post(route('tasks.store', $project), [
            'body' => '',
        ])
            ->assertSessionHasErrors('body');
    }
}
