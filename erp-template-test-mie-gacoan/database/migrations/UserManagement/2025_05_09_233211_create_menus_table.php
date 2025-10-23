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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('parent_id')->nullable(); 
            $table->string('name');
            $table->string('route')->default('#');
            $table->string('icon')->nullable(); 
            $table->integer('seq_id')->default(0); 
            $table->boolean('is_active')->default(true);
            $table->timestamps();
             $table->timestamp('deleted_at')->nullable();
            $table->BigInteger('deleted_by')->nullable();
    
            $table->index('parent_id', 'idx_menus_parent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
