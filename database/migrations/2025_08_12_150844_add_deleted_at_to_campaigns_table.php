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
    Schema::table('campaigns', function (Blueprint $table) {
        $table->softDeletes(); // ini otomatis bikin kolom deleted_at nullable
    });
}

public function down(): void
{
    Schema::table('campaigns', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });
}

};
