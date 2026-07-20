<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_draft_posts_are_not_listed_for_other_authors(): void
    {
        /** @var User $author */
        $author = User::factory()->create(['role' => 'author']);

        /** @var User $otherAuthor */
        $otherAuthor = User::factory()->create(['role' => 'author']);

        $draftPost = Post::create([
            'user_id' => $otherAuthor->id,
            'title' => 'Secret Draft',
            'slug' => 'secret-draft',
            'excerpt' => 'Draft excerpt',
            'content' => 'Draft content',
            'status' => 'draft',
        ]);

        $publishedPost = Post::create([
            'user_id' => $otherAuthor->id,
            'title' => 'Published Post',
            'slug' => 'published-post',
            'excerpt' => 'Published excerpt',
            'content' => 'Published content',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->actingAs($author)
            ->get('/author/posts')
            ->assertOk()
            ->assertDontSee($draftPost->title)
            ->assertSee($publishedPost->title);
    }
}
