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
    Schema::table('otps', function (Blueprint $table) {
        // ubah kolom user_id jadi nullable
        $table->unsignedBigInteger('user_id')->nullable()->change();
    });

    Schema::table('otps', function (Blueprint $table) {
        // drop dulu constraint lama
        $table->dropForeign(['user_id']);

        // bikin lagi foreign key dengan onDelete cascade
        $table->foreign('user_id')
              ->references('id')->on('users')
              ->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('otps', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->unsignedBigInteger('user_id')->nullable(false)->change();

        $table->foreign('user_id')
              ->references('id')->on('users')
              ->onDelete('cascade');
    });
}
};
