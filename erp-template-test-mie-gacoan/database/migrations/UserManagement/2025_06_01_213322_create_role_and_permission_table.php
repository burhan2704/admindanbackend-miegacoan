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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('company_id')->nullable();
            $table->string('role_name')->unique();
            $table->boolean('is_active')->default(true); 
            $table->timestamps();
            $table->BigInteger('created_by')->nullable();
            $table->BigInteger('updated_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->BigInteger('deleted_by')->nullable();

            $table->unique(['company_id', 'role_name'], 'unique_users_company_id_role_name');

        });


        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('company_id')->nullable(false);
            $table->BigInteger('role_id');
            $table->BigInteger('menu_id'); 
            $table->BigInteger('seq_id')->nullable(); 
            $table->boolean('can_create')->default(false);
            $table->boolean('can_update')->default(false);
            $table->boolean('can_delete')->default(false);
            $table->boolean('can_view')->default(false);
            $table->boolean('can_print')->default(false);
            $table->boolean('can_open')->default(false);
            $table->boolean('can_confirm')->default(false);
            $table->timestamps();
            $table->BigInteger('created_by')->nullable();
            $table->BigInteger('updated_by')->nullable();

        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
    }
};
