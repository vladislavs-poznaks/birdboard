<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
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
            'description' => 'Test Description',
            'notes' => 'General notes here.'
        ])
            ->assertRedirect(route('projects.show', Project::first()));

        $this->assertDatabaseHas('projects', [
            'title' => 'Test Title',
            'description' => 'Test Description',
            'notes' => 'General notes here.'
        ]);

        $this->get(route('projects.show', Project::first()))
            ->assertSee('Test Title')
            ->assertSee('General notes here.');
    }

    /** @test */
    public function a_user_can_see_all_the_projects_they_have_been_invited_to()
    {
        $user = $this->signIn();

        $project = tap(Project::factory()->create())->invite($user);

        $this->get(route('projects.index'))
            ->assertStatus(200)
            ->assertSee($project->title);
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->create();

        $this->get(route('projects.edit', $project))->assertStatus(200);

        $this->put(route('projects.update', $project), [
            'title' => 'Changed title here.',
            'description' => 'Changed description here.',
            'notes' => 'Changed notes here.'
        ])
            ->assertRedirect(route('projects.show', $project));

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => 'Changed title here.',
            'description' => 'Changed description here.',
            'notes' => 'Changed notes here.'
        ]);
    }

    /** @test */
    public function guests_cannot_delete_a_project()
    {
        $project = Project::factory()->create();

        $this->delete(route('projects.destroy', $project))
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('projects', [
            'title' => $project->title,
            'description' => $project->description,
        ]);
    }

    /** @test */
    public function a_user_cannot_delete_a_project_of_others()
    {
        $project = Project::factory()->create();

        $this->actingAs($this->signIn())->delete(route('projects.destroy', $project))
            ->assertStatus(403);

        $this->assertDatabaseHas('projects', [
            'title' => $project->title,
            'description' => $project->description,
        ]);
    }

    /** @test */
    public function a_user_can_delete_a_project()
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->create();

        $this->get(route('projects.edit', $project))
            ->assertStatus(200);

        $this->delete(route('projects.destroy', $project))
            ->assertRedirect(route('projects.index'));

        $this->assertDatabaseMissing('projects', [
            'title' => $project->title,
            'description' => $project->description,
        ]);
    }

    /** @test */
    public function a_user_can_update_just_projects_notes()
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->create();

        $this->get(route('projects.edit', $project))->assertStatus(200);

        $this->put(route('projects.update', $project), [
            'notes' => 'Changed notes here.'
        ])
            ->assertRedirect(route('projects.show', $project));

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'notes' => 'Changed notes here.'
        ]);
    }

    /** @test */
    public function a_user_can_view_a_project()
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->create();

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
    public function authenticated_user_can_not_update_a_project_of_others()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->put(route('projects.update', $project), [
            'title' => 'Changed title',
            'notes' => 'Changed notes here...'
        ])
            ->assertStatus(403);

        $this->assertDatabaseMissing('projects', [
            'id' => $project->id,
            'title' => 'Changed title',
            'notes' => 'Changed notes here...'
        ]);

    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->create();

        $this->post('/projects', [
            'title' => '',
            'description' => $project->description
        ])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->create();

        $this->post('/projects', [
            'title' => $project->title,
            'description' => ''
        ])
            ->assertSessionHasErrors('description');
    }
}
