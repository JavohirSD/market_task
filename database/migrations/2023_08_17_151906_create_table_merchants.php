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
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->decimal('balance', 10)->comment('Merchant balance');

            $table->string('name',128)
                    ->unique('merchants-name-index')
                    ->comment('Merchant name');

            $table->tinyInteger('status')
                    ->default(2)
                    ->comment('Status: 1-Active, 2-Inactive');

            $table->unsignedBigInteger('user_id')
                    ->index('merchants-user_id-index')
                    ->comment('Belongs to user');
        });

        Schema::table('merchants', function($table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchants');
    }
};
