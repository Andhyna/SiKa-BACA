<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('categories') && !Schema::hasColumn('categories', 'description')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->text('description')->nullable()->after('name');
            });
        }

        if (Schema::hasTable('books') && !Schema::hasColumn('books', 'publisher')) {
            Schema::table('books', function (Blueprint $table) {
                $table->string('publisher')->nullable()->after('author');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('categories') && Schema::hasColumn('categories', 'description')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }

        if (Schema::hasTable('books') && Schema::hasColumn('books', 'publisher')) {
            Schema::table('books', function (Blueprint $table) {
                $table->dropColumn('publisher');
            });
        }
    }
};
