<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_books_page_displays_library_information(): void
    {
        $response = $this->get('/books');

        $response->assertOk();
        $response->assertSee('Daftar Buku');
        $response->assertSee('SiKa BACA');
    }

    public function test_categories_page_displays_library_information(): void
    {
        $response = $this->get('/categories');

        $response->assertOk();
        $response->assertSee('Daftar Kategori');
        $response->assertSee('SiKa BACA');
    }

    public function test_members_page_displays_library_information(): void
    {
        $response = $this->get('/members');

        $response->assertOk();
        $response->assertSee('Daftar Member');
        $response->assertSee('SiKa BACA');
    }
}
