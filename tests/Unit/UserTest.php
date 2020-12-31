<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_projects()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    /** @test */
    public function a_user_has_shared_projects()
    {
        $john = User::factory()->create();
        $sally = User::factory()->create();
        $nick = User::factory()->create();

        ProjectFactory::ownedBy($sally)->create()->invite($john);

        $this->assertCount(1, $john->sharedProjects);
        $this->assertCount(0, $nick->sharedProjects);
    }
}
