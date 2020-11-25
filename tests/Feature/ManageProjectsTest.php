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
//        $attributes = Project::factory()
//            ->raw();

        $this->post('/projects', $project->toArray())->assertRedirect('/login');

        $this->get('/projects')->assertRedirect('/login');

        $this->get('/projects/create')->assertRedirect('/login');

        $this->get(route('projects.show', $project))
            ->assertRedirect(route('login'));

    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get('/projects/create')->assertStatus(200);

        $project = Project::factory()->make([
            'owner_id' => $user->id
        ]);

        $this->post('/projects', [
            'title' => $project->title,
            'description' => $project->description
        ])->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', [
            'owner_id' => $user->id,
            'title' => $project->title,
            'description' => $project->description
        ]);

        $this->get('/projects')->assertSee($project->title);
    }

    /** @test */
    public function a_user_can_view_a_project()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $project = Project::factory()->create([
            'owner_id' => $user->id
        ]);

        $this->get(route('projects.show', $project))
            ->assertStatus(200)
            ->assertSee($project->title)
            ->assertSee($project->description);

    }

    /** @test */
    public function authenticated_user_can_not_view_a_project_of_others()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $project = Project::factory()->create();

        $this->get(route('projects.show', $project))
            ->assertStatus(403)
            ->assertDontSee($project->title)
            ->assertDontSee($project->description);

    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $project = Project::factory()->create([
            'owner_id' => $user->id
        ]);

        $this->post('/projects', [
            'title' => '',
            'description' => $project->description
        ])->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $project = Project::factory()->create([
            'owner_id' => $user->id
        ]);

        $this->post('/projects', [
            'title' => $project->title,
            'description' => ''
        ])->assertSessionHasErrors('description');
    }
}