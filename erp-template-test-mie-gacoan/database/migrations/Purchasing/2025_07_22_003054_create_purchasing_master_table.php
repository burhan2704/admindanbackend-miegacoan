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
        Schema::create('pm_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable(false)->constrained('companies') ->onDelete('restrict');
            $table->string('code', 50)->nullable();
            $table->string('name', 200)->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps(); 
            $table->timestamp('deleted_at')->nullable();
            $table->BigInteger('deleted_by')->nullable();
            $table->BigInteger('created_by')->nullable();
            $table->BigInteger('updated_by')->nullable();
        });

        Schema::create('pm_supplier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable(false)->constrained('companies') ->onDelete('restrict');
            $table->string('code', 50)->nullable();
            $table->string('name', 200)->nullable();
            $table->boolean('is_active')->default(true);
            
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
        Schema::dropIfExists('pm_types');
        Schema::dropIfExists('pm_supplier');
    }
};
