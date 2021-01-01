<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_a_project_owner_can_invite_a_user()
    {
        $project = Project::factory()->create();

        $userToInvite = User::factory()->create();

        $this->actingAs($user = User::factory()->create())
            ->post(route('invitations.store', $project), [
                'email' => $userToInvite->email
            ])
            ->assertStatus(403);

        $this->assertFalse($project->members->contains($userToInvite));
    }

    /** @test */
    public function project_members_can_not_invite_other_users()
    {
        $john = User::factory()->create();

        $project = ProjectFactory::ownedBy($john)->create();

        $sally = User::factory()->create();
        $nick = User::factory()->create();

        $project->invite($sally);

        $this->actingAs($sally)
            ->post(route('invitations.store', $project), [
                'email' => $nick->email
            ])
            ->assertStatus(403);

        $this->assertTrue($project->members->contains($sally));
        $this->assertFalse($project->members->contains($nick));
    }

    /** @test */
    public function a_user_can_be_invited_to_a_project_by_the_owner()
    {
        $project = Project::factory()->create();

        $userToInvite = User::factory()->create();

        $this->actingAs($project->owner)
            ->post(route('invitations.store', $project), [
                'email' => $userToInvite->email
            ])
            ->assertRedirect(route('projects.show', $project));

        $this->assertTrue($project->members->contains($userToInvite));
    }

    /** @test */
    public function the_invited_email_must_be_a_valid_account()
    {
        $project = Project::factory()->create();

        $this->actingAs($project->owner)
            ->post(route('invitations.store', $project), [
                'email' => 'dummy@email.fake'
            ])
            ->assertSessionHasErrors([
                'email' => 'The invited users must have a Birdboard account.'
            ]);
    }

    /** @test */
    public function project_member_can_update_project_details()
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
