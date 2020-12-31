<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_invite_a_user()
    {
        $project = Project::factory()->create();

        $project->invite($user = User::factory()->create());

        $this->signIn($user);

        $this->post(route('tasks.store', $project), [
            'body' => 'Some task'
        ]);

        $this->assertDatabaseHas('tasks', [
            'project_id' => $project->id,
            'body' => 'Some task'
        ]);
    }
}
