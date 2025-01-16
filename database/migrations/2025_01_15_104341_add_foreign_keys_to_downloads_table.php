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
        Schema::table('downloads', function (Blueprint $table) {
            $table->foreign(['document_id'], 'downloads_ibfk_1')->references(['id'])->on('documents')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['user_id'], 'downloads_ibfk_2')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('downloads', function (Blueprint $table) {
            $table->dropForeign('downloads_ibfk_1');
            $table->dropForeign('downloads_ibfk_2');
        });
    }
};
