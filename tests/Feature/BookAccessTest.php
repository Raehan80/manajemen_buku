<?php

namespace Tests\Feature;

use App\Models\Book;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_mahasiswa_can_view_books_but_cannot_create_edit_or_delete_them(): void
    {
        $this->loginAs('mahasiswa@mail.com');

        $book = Book::create([
            'title' => 'Buku Pengantar',
            'author' => 'Penulis',
            'isbn' => '9780000000001',
            'year' => 2025,
        ]);

        $this->get('/books')
            ->assertOk()
            ->assertSee('Buku Pengantar')
            ->assertDontSee('Tambah buku')
            ->assertDontSee('Edit')
            ->assertDontSee('Hapus')
            ->assertDontSee('Aksi');

        $this->get('/books/create')->assertForbidden();
        $this->get("/books/{$book->id}/edit")->assertForbidden();

        $this->delete("/books/{$book->id}")->assertForbidden();
        $this->assertModelExists($book);
    }

    public function test_dosen_can_view_create_and_edit_but_cannot_delete_books(): void
    {
        $this->loginAs('dosen@mail.com');

        $book = Book::create([
            'title' => 'Buku Pengantar',
            'author' => 'Penulis',
            'isbn' => '9780000000002',
            'year' => 2025,
        ]);

        $this->get('/books')
            ->assertOk()
            ->assertSee('Tambah buku')
            ->assertSee('Edit')
            ->assertDontSee('Hapus');

        $this->get('/books/create')->assertOk();
        $this->get("/books/{$book->id}/edit")->assertOk();

        $this->post('/books', [
            'title' => 'Buku Dosen',
            'author' => 'Dosen',
            'isbn' => '9780000000005',
            'year' => 2025,
        ])->assertRedirect('/books');

        $this->put("/books/{$book->id}", [
            'title' => 'Buku Dosen Diperbarui',
            'author' => 'Penulis Baru',
            'isbn' => $book->isbn,
            'year' => 2026,
        ])->assertRedirect('/books');

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Buku Dosen Diperbarui',
        ]);
        $this->assertDatabaseHas('books', ['isbn' => '9780000000005']);

        $this->delete("/books/{$book->id}")->assertForbidden();
        $this->assertModelExists($book);
    }

    public function test_admin_can_create_edit_and_delete_books(): void
    {
        $this->loginAs('admin@mail.com');

        $this->get('/books')->assertOk();
        $this->get('/books/create')->assertOk();

        $this->post('/books', [
            'title' => 'Buku Pengantar',
            'author' => 'Penulis',
            'isbn' => '9780000000003',
            'year' => 2025,
        ])->assertRedirect('/books');

        $book = Book::query()->where('isbn', '9780000000003')->firstOrFail();
        $this->assertModelExists($book);

        $this->get("/books/{$book->id}/edit")->assertOk();

        $this->put("/books/{$book->id}", [
            'title' => 'Buku Lanjutan',
            'author' => 'Penulis Baru',
            'isbn' => '9780000000004',
            'year' => 2026,
        ])->assertRedirect('/books');

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Buku Lanjutan',
            'isbn' => '9780000000004',
        ]);

        $this->get('/books')
            ->assertOk()
            ->assertSee('Tambah buku')
            ->assertSee('Edit')
            ->assertSee('Hapus');

        $this->delete("/books/{$book->id}")->assertRedirect('/books');
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    public function test_users_can_search_books_by_title_author_or_isbn(): void
    {
        $this->loginAs('mahasiswa@mail.com');

        Book::create([
            'title' => 'Belajar Laravel',
            'author' => 'Ayu Putri',
            'isbn' => '9780000000006',
            'year' => 2025,
        ]);
        Book::create([
            'title' => 'Dasar Desain',
            'author' => 'Budi Santoso',
            'isbn' => '9780000000007',
            'year' => 2024,
        ]);

        $this->get('/books?search=Laravel')
            ->assertOk()
            ->assertSee('Belajar Laravel')
            ->assertDontSee('Dasar Desain');
    }

    private function loginAs(string $email): void
    {
        $this->seed(RolePermissionSeeder::class);

        $this->post('/login', [
            'email' => $email,
            'password' => 'password',
        ])->assertRedirect('/dashboard');
    }
}
