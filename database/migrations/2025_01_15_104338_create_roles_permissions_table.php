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
        Schema::create('roles_permissions', function (Blueprint $table) {
            $table->enum('role', ['Super Admin', 'Admin', 'Teacher', 'Student', 'Guest'])->primary();
            $table->boolean('can_upload')->nullable()->default(false);
            $table->boolean('can_download')->nullable()->default(false);
            $table->boolean('can_comment')->nullable()->default(false);
            $table->boolean('can_rate')->nullable()->default(false);
            $table->boolean('can_view')->nullable()->default(true);
            $table->boolean('can_add_user')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_permissions');
    }
};
