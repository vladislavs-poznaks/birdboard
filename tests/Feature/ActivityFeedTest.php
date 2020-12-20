<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_project_generates_activity()
    {
        $project = Project::factory()->create();

        $this->assertEquals(1, $project->activity->count());

        $this->assertEquals('created', $project->activity->first()->description);
    }

    /** @test */
    public function updating_a_project_generates_activity()
    {
        $project = Project::factory()->create();
        $project->update([
            'title' => 'Changed'
        ]);

        $this->assertEquals(2, $project->activity->count());
        $this->assertEquals('updated', $project->activity->last()->description);
    }
}
