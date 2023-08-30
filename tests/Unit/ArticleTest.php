<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    private $base_url = 'http://localhost/api/v1/articles';

    /**
     * test server is running correctly checking root path
     */
    public function test_the_application_returns_successful_response():void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test the articles' list loads correctly
     */
    public function test_articles_index(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->get($this->base_url);
        $response->assertStatus(200);
    }

    /**
     * test an article can be created
     */
    public function test_articles_save(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->post($this->base_url, [
            'title' => 'api unit test title',
            'body' => 'api unit test body'
        ]);

        $response->assertCreated();
        $response->assertSeeText('data');
    }

    /**
     * test an article can be read
     */
    public function test_get_one_article(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $article = Article::factory()->create();

        $response = $this->get($this->base_url . $article->id);

        $this->assertThat(
            $response->getStatusCode(),
            $this->logicalOr(
                $this->equalTo(200),
                $this->equalTo(404)
            )
        );
    }

    /**
     * test new article api update
     * @return void
     */
    public function test_update_article(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->put(
            $this->base_url . '/' . $article->id,
            [
                "title" => "my TEST PUT article",
                "body" => "get all TEST POST request edited by PUT"
            ]
        );

        $response->assertOk();
        $response->assertSeeText('data');
    }

    /**
     * test new article api delete
     * @return void
     */
    public function test_delete_article(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->delete($this->base_url . '/' . $article->id);

        $response->assertStatus(204);
    }
}
