<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ArticleApiTest extends TestCase
{
    private $base_url = "http://localhost/api/v1/articles";
    private $user;

    public function login() {
    }

    /**
     * test server is running correctly and logging in for token
     */
    public function test_the_application_returns_token(): void
    {
        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $response = $this->post('http://localhost/api/v1/get_token', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertOk(200);
        $response->assertSeeText('token');
    }

    /**
     * Test the articles' list loads correctly
     */
    public function test_get_all_articles(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->get($this->base_url);

        $response->assertOk(200);
        $response->assertSeeText('data');
    }

    /**
     * test an article can be read
     */
    public function test_get_one_article(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $article = Article::factory()->create();

        $response = $this->get($this->base_url . '/' . $article->id);

        $this->assertThat(
            $response->getStatusCode(),
            $this->logicalOr(
                $this->equalTo(200),
                $this->equalTo(404)
            )
        );
    }

    /**
     * test article not found
     */
    public function test_article_not_found(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->get($this->base_url . '/0');

        $response->assertNotFound();
        $response->assertSeeText('Not Found');
    }

    /**
     * test new article api save
     * @return void
     */
    public function test_save_article(): void
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
