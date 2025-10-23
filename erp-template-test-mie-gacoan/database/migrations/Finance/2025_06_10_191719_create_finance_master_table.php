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
        Schema::create('fm_group_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('code', 5)->nullable();
            $table->string('name', 255)->nullable();
            $table->timestamps(); 
            $table->timestamp('deleted_at')->nullable();
            $table->BigInteger('deleted_by')->nullable();
            $table->BigInteger('created_by')->nullable();
            $table->BigInteger('updated_by')->nullable();
        });

        Schema::create('fm_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('code', 5)->nullable();
            $table->string('name', 255)->nullable();
            $table->BigInteger('group_ac_id')->nullable();

            $table->timestamps(); 
            $table->timestamp('deleted_at')->nullable();
            $table->BigInteger('deleted_by')->nullable();
            $table->BigInteger('created_by')->nullable();
            $table->BigInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_master');
    }
};
