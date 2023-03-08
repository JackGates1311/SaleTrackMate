<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\TestData;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testCrudOperationsForArticle()
    {
        $articles = TestData::articles;
        $id = null;

        // READ ALL COMPANIES
        $response = $this->getJson('/api/companies');
        $response->assertStatus(200);
        $response->assertJson(['companies' => []]);
        $this->assertEmpty($response->json()['companies']);

        // READ ALL
        $response = $this->getJson('/api/articles');
        $response->assertStatus(200);
        $response->assertJson(['articles' => []]);
        $this->assertEmpty($response->json()['articles']);

        // CREATE
        foreach ($articles as $index => $article)
        {
            $article += ['company_id' => $this->getCompanyId()];

            $response = $this->postJson('/api/articles', $article);
            $response->assertStatus(201);

            if($index == 1)
            {
                $id = $response->json('data.id');
            }
        }

        // READ ALL COMPANIES
        $response = $this->getJson('/api/companies');
        $response->assertStatus(200);
        $response->assertJson(['companies' => []]);
        $this->assertNotEmpty($response->json()['companies']);

        // READ ALL
        $response = $this->getJson('/api/articles');
        $response->assertStatus(200);
        $response->assertJson(['articles' => []]);
        $this->assertNotEmpty($response->json()['articles']);

        // READ
        $response = $this->getJson('/api/articles/' . $id);
        $response->assertStatus(200);
        $response->assertJson(['article' => []]);
        $this->assertNotEmpty($response->json()['article']);

        // UPDATE
        $updatedData = array_merge($articles[1] , ['name' => 'Updated Article Name']);
        $response = $this->putJson('/api/articles/' . $id, $updatedData);
        $response->assertStatus(200);
        $this->assertEquals('Updated Article Name', $response->json('data.name'));

        // DELETE
        $response = $this->deleteJson('/api/articles/' . $id);
        $response->assertStatus(200);
        $this->assertNull(Article::find($id));
    }

    public function getCompanyId(): string
    {
        $companies = testData::companies;

        // CREATE
        $response = $this->postJson('/api/companies', $companies[1]);
        $response->assertStatus(201);

        return $response->json('data.id');
    }
}
