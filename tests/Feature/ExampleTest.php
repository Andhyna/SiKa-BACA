<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_books_page_displays_books_from_database(): void
    {
        Book::query()->create([
            'title' => 'Madilog (Materialisme, Dialektika, Logika)',
            'author' => 'Tan Malaka',
            'year' => 1943,
            'stock' => 14,
        ]);

        Book::query()->create([
            'title' => 'Mastering Web Framework',
            'author' => 'Taylor Otwell',
            'year' => 2023,
            'stock' => 5,
        ]);

        $response = $this->get('/books');

        $response->assertOk();
        $response->assertSee('Daftar Buku');
        $response->assertSee('Madilog (Materialisme, Dialektika, Logika)');
        $response->assertSee('Penulis: Tan Malaka');
        $response->assertSee('Tahun: 1943');
        $response->assertSee('Stok: 14');
        $response->assertSee('Mastering Web Framework');
        $response->assertSee('Penulis: Taylor Otwell');
        $response->assertSee('Tahun: 2023');
        $response->assertSee('Stok: 5');
    }

    public function test_book_parameter_is_passed_to_controller(): void
    {
        $response = $this->get('/books/7');

        $response->assertOk();
        $response->assertSeeText('ID Buku: 7');
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
