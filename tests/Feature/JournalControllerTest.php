<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Journal;
use Laravel\Sanctum\Sanctum;

class JournalControllerTest extends TestCase
{

    /** @test */
    public function it_can_retrieve_user_journals()
    {

        $user = User::factory()->create();

        $journals = Journal::factory()->count(3)->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);


        $response = $this->getJson('/api/v1/user/journals');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'User journals retreived successfully',
                'data' => $journals->toArray(),
            ]);
    }

    /** @test */
    public function it_can_create_a_journal_for_authenticated_user()
    {

        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $journalData = [
            'title' => 'Sample Journal Title',
            'content' => 'This is the content of the journal.',
        ];

        $response = $this->postJson('/api/v1/user/journal', $journalData);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Journal Created successfully',
                'data' => $journalData,
            ]);

        $this->assertDatabaseHas('journals', [
            'user_id' => $user->id,
            'title' => $journalData['title'],
            'content' => $journalData['content'],
        ]);
    }
}
