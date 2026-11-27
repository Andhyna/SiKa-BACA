<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Buat tabel categories jika belum ada
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }

        // 2. Buat tabel members jika belum ada, atau lengkapi kolomnya
        if (!Schema::hasTable('members')) {
            Schema::create('members', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('member_code')->unique();
                $table->string('phone')->nullable();
                $table->text('address')->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('members', function (Blueprint $table) {
                if (!Schema::hasColumn('members', 'member_code')) {
                    $table->string('member_code')->unique();
                }
                if (!Schema::hasColumn('members', 'phone')) {
                    $table->string('phone')->nullable();
                }
                if (!Schema::hasColumn('members', 'address')) {
                    $table->text('address')->nullable();
                }
            });
        }

        // 3. Lengkapi kolom pada tabel books
        Schema::table('books', function (Blueprint $table) {
            if (!Schema::hasColumn('books', 'year')) {
                $table->year('year')->nullable();
            }
            if (!Schema::hasColumn('books', 'stock')) {
                $table->integer('stock')->default(0);
            }
            if (!Schema::hasColumn('books', 'category_id')) {
                $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        //
    }
};