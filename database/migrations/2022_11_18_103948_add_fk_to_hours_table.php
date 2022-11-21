<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('hours', static function (Blueprint $table) {
            $table  ->foreignId('hour_type_id')
                    ->constrained()
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();

            $table  ->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('hours', static function (Blueprint $table) {
            $table->dropConstrainedForeignId('hour_type_id');
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
