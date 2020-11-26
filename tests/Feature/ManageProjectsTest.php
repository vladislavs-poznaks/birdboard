<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guests_can_not_control_projects()
    {
        $project = Project::factory()->create();

        $this->post('/projects', $project->toArray())->assertRedirect('/login');

        $this->get('/projects')->assertRedirect('/login');

        $this->get('/projects/create')->assertRedirect('/login');

        $this->get(route('projects.show', $project))
            ->assertRedirect(route('login'));

    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $this->post('/projects', [
            'title' => 'Test Title',
            'description' => 'Test Description'
        ])->assertRedirect(route('projects.show', Project::first()));

        $this->assertDatabaseHas('projects', [
            'title' => 'Test Title',
            'description' => 'Test Description'
        ]);

        $this->get('/projects')->assertSee('Test Title');
    }

    /** @test */
    public function a_user_can_view_a_project()
    {
        $this->signIn();

        $project = Project::factory()->create([
            'owner_id' => auth()->id()
        ]);

        $this->get(route('projects.show', $project))
            ->assertStatus(200)
            ->assertSee($project->title);

    }

    /** @test */
    public function authenticated_user_can_not_view_a_project_of_others()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->get(route('projects.show', $project))
            ->assertStatus(403)
            ->assertDontSee($project->title)
            ->assertDontSee($project->description);

    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();

        $project = Project::factory()->create([
            'owner_id' => auth()->id()
        ]);

        $this->post('/projects', [
            'title' => '',
            'description' => $project->description
        ])->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();

        $project = Project::factory()->create([
            'owner_id' => auth()->id()
        ]);

        $this->post('/projects', [
            'title' => $project->title,
            'description' => ''
        ])->assertSessionHasErrors('description');
    }
}
