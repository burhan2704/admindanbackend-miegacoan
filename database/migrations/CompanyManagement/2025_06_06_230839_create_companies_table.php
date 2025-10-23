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
         Schema::create('companies', function (Blueprint $table) {
            $table->id(); 
            $table->string('code')->unique();
            $table->string('name'); 
            $table->string('short_desc')->nullable();
            $table->string('logo')->nullable();
            $table->BigInteger('province_id')->nullable();
            $table->BigInteger('city_id')->nullable();
            $table->BigInteger('sub_district_id')->nullable();
            $table->text('address')->nullable(); 
            $table->string('zip_code', 10)->nullable();
            $table->string('country')->nullable(); 
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('fax')->nullable();
            $table->string('domain')->unique();
            $table->string('npwp')->nullable();
            $table->string('po_box')->nullable();
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
        Schema::dropIfExists('companies');
    }
};
