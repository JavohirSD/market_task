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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('address',255)->comment('Shop address');
            $table->string('schedule',128)->comment('Work schedule');
            $table->decimal('latitude', 10, 8)->comment('Latitude of the shop');
            $table->decimal('longitude', 11, 8)->comment('Longitude of the shop');;
            $table->timestamps();

            $table->unsignedBigInteger('merchant_id')
                ->index('shops-mechant_id-index')
                ->comment('Belong mechant');

            $table->tinyInteger('status')
                ->default(2)
                ->comment('Status: 1-Active, 2-Inactive');
        });

        Schema::table('shops', function($table) {
            $table->foreign('merchant_id')
                ->references('id')
                ->on('merchants')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
