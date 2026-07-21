<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_and_delete_author_accounts(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        /** @var User $author */
        $author = User::factory()->create(['role' => 'author']);

        $this->actingAs($admin)
            ->get('/admin/authors')
            ->assertOk()
            ->assertSee($author->name);

        $this->actingAs($admin)
            ->delete('/admin/authors/' . $author->id)
            ->assertRedirect('/admin/authors');

        $this->assertNull($author->fresh());
    }
}
