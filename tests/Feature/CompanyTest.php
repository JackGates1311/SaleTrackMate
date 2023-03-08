<?php

namespace Tests\Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\TestData;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    public function testCrudOperationsForCompany()
    {
        $companies = TestData::companies;

        foreach ($companies as $company)
        {
            // CREATE
            $response = $this->postJson('/api/companies', $company);
            $response->assertStatus(201);
            $id = $response->json('data.id');

            // READ ALL
            $response = $this->getJson('/api/companies');
            $response->assertStatus(200);
            $response->assertJson(['companies' => []]);
            $this->assertNotEmpty($response->json()['companies']);

            // READ
            $response = $this->getJson('/api/companies/' . $id);
            $response->assertStatus(200);
            $response->assertJson(['company' => []]);
            $this->assertNotEmpty($response->json()['company']);

            // UPDATE
            $updatedData = array_merge($company, ['name' => 'Updated Company Name']);
            $response = $this->putJson('/api/companies/' . $id, $updatedData);
            $response->assertStatus(200);
            $this->assertEquals('Updated Company Name', $response->json('data.name'));

            // GET ARTICLES
            $this->articles_crud($company, $id);

            // DELETE COMPANY
            $response = $this->deleteJson('/api/companies/' . $id);
            $response->assertStatus(200);
            $this->assertNull(Company::find($id));
        }

    }

    public function articles_crud($data, $companyId)
    {
        // CREATE
        $articles = $data['articles'];

        foreach ($articles as $article) {
            $article += ['company_id' => $companyId];

            $response = $this->postJson('/api/articles', $article);
            $response->assertStatus(201);
            $response->json('data.id');

            $this->assertDatabaseHas('articles', $article);
        }
    }
}
