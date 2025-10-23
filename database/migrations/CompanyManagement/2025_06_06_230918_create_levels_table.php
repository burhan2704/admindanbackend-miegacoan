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
        Schema::create('levels', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('company_id')->nullable(false)->constrained('companies') ->onDelete('restrict');
            $table->BigInteger('position_id')->nullable();
            $table->string('code')->unique();
            $table->string('name'); 
            $table->boolean('is_active')->default(true);
            $table->timestamp('deleted_at')->nullable();
            $table->BigInteger('deleted_by')->nullable();
              $table->BigInteger('created_by')->nullable();
            $table->BigInteger('updated_by')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
