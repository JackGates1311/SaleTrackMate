<?php

namespace Tests\Feature;

use App\Models\GoodOrServiceDetails;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\TestData;

class ArticleDetailsTest extends TestCase
{
    use RefreshDatabase;

    public function testCrudOperationsForArticleDetails()
    {
        $articlesDetails = TestData::articleDetails;

        // READ ALL ARTICLES
        $response = $this->getJson('/api/articles');
        $response->assertStatus(200);
        $response->assertJson(['articles' => []]);
        $this->assertEmpty($response->json()['articles']);

        // READ ALL
        $response = $this->getJson('/api/articlesDetails');
        $response->assertStatus(200);
        $response->assertJson(['articles' => []]);
        $this->assertEmpty($response->json()['articles']);

        // CREATE
        $articlesDetailsUpdated = $this->createArticlesDetails($articlesDetails);

        // READ ALL
        $response = $this->getJson('/api/articlesDetails');
        $response->assertStatus(200);
        $response->assertJson(['articles' => []]);
        $this->assertNotEmpty($response->json()['articles']);

        // UPDATE
        $updatedData = array_merge($articlesDetailsUpdated[1], ['supplier' => 'Updated Supplier']);
        $response = $this->putJson('/api/articlesDetails/' . $articlesDetailsUpdated[1]['id'], $updatedData);
        $response->assertStatus(200);
        $this->assertEquals('Updated Supplier', $response->json('data.supplier'));

        // DELETE
        $response = $this->deleteJson('/api/articlesDetails/' . $articlesDetailsUpdated[1]['id']);
        $response->assertStatus(200);
        $this->assertNull(GoodOrServiceDetails::find($articlesDetailsUpdated[1]['id']));
    }

    public function createArticlesDetails($articlesDetails): array
    {
        $companies = testData::companies;
        $articles = TestData::articles;

        // CREATE COMPANIES
        $response = $this->postJson('/api/companies', $companies[1]);
        $response->assertStatus(201);
        $companyId = $response->json('data.id');

        $articlesIds = [];

        // CREATE ARTICLES
        foreach ($articles as $article) {
            $article += ['company_id' => $companyId];

            $response = $this->postJson('/api/articles', $article);
            $response->assertStatus(201);
            $id = $response->json('data.id');

            $articlesIds[] = $id;
        }

        $articlesDetailsUpdated = [];

        // CREATE ARTICLE DETAILS
        foreach ($articlesDetails as $index => $articleDetails) {
            $articleDetails += ['article_id' => $articlesIds[$index]];

            $response = $this->postJson('/api/articlesDetails', $articleDetails);
            $response->assertStatus(201);
            $articlesDetails = $response->json('data');

            // READ
            $response = $this->getJson('/api/articlesDetails/' . $response->json('data.id'));
            $response->assertStatus(200);
            $response->assertJson(['articleDetails' => []]);
            $this->assertNotEmpty($response->json()['articleDetails']);

            $articlesDetailsUpdated[] = $articlesDetails;
        }

        return $articlesDetailsUpdated;
    }
}
