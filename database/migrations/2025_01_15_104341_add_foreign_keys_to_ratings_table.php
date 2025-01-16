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
        Schema::table('ratings', function (Blueprint $table) {
            $table->foreign(['document_id'], 'ratings_ibfk_1')->references(['id'])->on('documents')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['user_id'], 'ratings_ibfk_2')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropForeign('ratings_ibfk_1');
            $table->dropForeign('ratings_ibfk_2');
        });
    }
};
