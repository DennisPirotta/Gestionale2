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
        Schema::table('technical_report_hours', static function (Blueprint $table) {
            $table->foreignId('hour_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();

            $table->foreignId('technical_report_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('technical_report_hours', static function (Blueprint $table) {
            $table->dropConstrainedForeignId('hour_id');
            $table->dropConstrainedForeignId('technical_report_id');
        });
    }
};
