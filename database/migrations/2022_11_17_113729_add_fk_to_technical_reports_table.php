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
        Schema::table('technical_reports', static function (Blueprint $table) {

            $table  ->foreignId('customer_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();

            $table  ->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();

            $table  ->foreignId('secondary_customer_id')
                    ->nullable()
                    ->constrained('customers')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();

            $table  ->foreignId('order_id')
                    ->nullable()
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
        Schema::table('technical_reports', static function (Blueprint $table) {
            $table->dropConstrainedForeignId('customer_id');
            $table->dropConstrainedForeignId('user_id');
            $table->dropConstrainedForeignId('secondary_customer_id');
            $table->dropConstrainedForeignId('order_id');
        });
    }
};
