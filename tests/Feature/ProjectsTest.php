<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function only_authenticated_users_can_create_a_project()
    {
        $attributes = Project::factory()
            ->raw();

        $this->post('/projects', $attributes)->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

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
