<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_unauthenticated_user_to_dashboard(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/dashboard');
    }

    public function test_application_uses_wib_timezone(): void
    {
        $this->assertSame('Asia/Jakarta', config('app.timezone'));
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee('SiKa-BACA');
    }

    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('SiKa-BACA');
    }

    public function test_books_page_displays_books_from_database(): void
    {
        $user = User::factory()->create([
            'role' => 'petugas',
        ]);

        $category = Category::query()->create([
            'name' => 'Teknologi',
            'description' => 'Buku seputar pemrograman dan IT',
        ]);

        Book::query()->create([
            'category_id' => $category->id,
            'title' => 'Mastering Web Framework',
            'author' => 'Taylor Otwell',
            'publisher' => 'Laravel Press',
            'year' => 2023,
            'stock' => 5,
        ]);

        $response = $this->actingAs($user)->get('/books');

        $response->assertOk();
        $response->assertSee('Katalog Koleksi Buku');
        $response->assertSee('Mastering Web Framework');
        $response->assertSee('Taylor Otwell');
    }

    public function test_book_detail_page_can_be_accessed(): void
    {
        $user = User::factory()->create([
            'role' => 'petugas',
        ]);

        $category = Category::query()->create([
            'name' => 'Sains',
            'description' => 'Buku sains',
        ]);

        $book = Book::query()->create([
            'category_id' => $category->id,
            'title' => 'Kosmos (Cosmos)',
            'author' => 'Carl Sagan',
            'publisher' => 'Gramedia',
            'year' => 1980,
            'stock' => 15,
        ]);

        $response = $this->actingAs($user)->get("/books/{$book->id}");

        $response->assertOk();
        $response->assertSee('Kosmos (Cosmos)');
        $response->assertSee('Carl Sagan');
    }

    public function test_categories_page_displays_categories_for_authenticated_user(): void
    {
        $user = User::factory()->create([
            'role' => 'petugas',
        ]);

        Category::query()->create([
            'name' => 'Fiksi',
            'description' => 'Kategori fiksi dan sastra',
        ]);

        $response = $this->actingAs($user)->get('/categories');

        $response->assertOk();
        $response->assertSee('Kategori Koleksi Buku');
        $response->assertSee('Fiksi');
    }

    public function test_members_page_displays_members_for_authenticated_user(): void
    {
        $user = User::factory()->create([
            'role' => 'petugas',
        ]);

        Member::query()->create([
            'member_code' => 'MBR-001',
            'name' => 'Ahmad Dahlan',
            'phone' => '081234567890',
            'address' => 'Karawang Barat',
        ]);

        $response = $this->actingAs($user)->get('/members');

        $response->assertOk();
        $response->assertSee('Data Anggota Perpustakaan');
        $response->assertSee('MBR-001');
        $response->assertSee('Ahmad Dahlan');
    }

    public function test_petugas_cannot_access_user_management(): void
    {
        $petugas = User::factory()->create([
            'role' => 'petugas',
        ]);

        $response = $this->actingAs($petugas)->get('/users/2');

        $response->assertForbidden();
    }

    public function test_invalid_category_path_returns_not_found(): void
    {
        $petugas = User::factory()->create([
            'role' => 'petugas',
        ]);

        $response = $this->actingAs($petugas)->get('/categories/edit');

        $response->assertNotFound();
    }

    public function test_borrowing_can_be_created_and_stock_is_decremented(): void
    {
        $petugas = User::factory()->create([
            'role' => 'petugas',
        ]);

        $category = Category::query()->create([
            'name' => 'Umum',
        ]);

        $book = Book::query()->create([
            'category_id' => $category->id,
            'title' => 'Clean Code',
            'author' => 'Robert C. Martin',
            'year' => 2008,
            'stock' => 3,
        ]);

        $member = Member::query()->create([
            'member_code' => 'MBR-002',
            'name' => 'Budi Santoso',
            'phone' => '081299990000',
        ]);

        $response = $this->actingAs($petugas)->post('/borrowings', [
            'member_id' => $member->id,
            'book_id' => $book->id,
            'quantity' => 2,
        ]);

        $response->assertRedirect('/borrowings');
        $this->assertSame(1, $book->fresh()->stock);
    }

    public function test_borrowing_update_processes_return_and_restores_stock(): void
    {
        $petugas = User::factory()->create([
            'role' => 'petugas',
        ]);

        $category = Category::query()->create([
            'name' => 'Teknik',
        ]);

        $book = Book::query()->create([
            'category_id' => $category->id,
            'title' => 'Refactoring',
            'author' => 'Martin Fowler',
            'year' => 2018,
            'stock' => 1,
        ]);

        $member = Member::query()->create([
            'member_code' => 'MBR-003',
            'name' => 'Siti Nurhaliza',
        ]);

        $this->actingAs($petugas)->post('/borrowings', [
            'member_id' => $member->id,
            'book_id' => $book->id,
            'quantity' => 1,
        ]);

        $this->assertSame(0, $book->fresh()->stock);

        $borrowing = \App\Models\Borrowing::first();

        $response = $this->actingAs($petugas)->put("/borrowings/{$borrowing->id}");

        $response->assertRedirect('/borrowings');
        $this->assertSame('returned', $borrowing->fresh()->status);
        $this->assertSame(1, $book->fresh()->stock);
    }

    public function test_cannot_delete_book_with_borrowing_history(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $category = Category::query()->create([
            'name' => 'Sejarah',
        ]);

        $book = Book::query()->create([
            'category_id' => $category->id,
            'title' => 'Indonesia Merdeka',
            'author' => 'Bung Hatta',
            'year' => 1945,
            'stock' => 2,
        ]);

        $member = Member::query()->create([
            'member_code' => 'MBR-004',
            'name' => 'Dewi Sartika',
        ]);

        $this->actingAs($admin)->post('/borrowings', [
            'member_id' => $member->id,
            'book_id' => $book->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($admin)->delete("/books/{$book->id}");

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('books', ['id' => $book->id]);
    }
}

