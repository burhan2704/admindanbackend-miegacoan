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
         Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string('code', 5)->nullable();
            $table->string('name', 255)->nullable();
            $table->timestamps(); 
            $table->timestamp('deleted_at')->nullable();
            $table->BigInteger('deleted_by')->nullable();
            $table->BigInteger('created_by')->nullable();
            $table->BigInteger('updated_by')->nullable();
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('code', 5)->nullable();
            $table->string('name', 255)->nullable();
            $table->BigInteger('province_id')->nullable();
            $table->string('postal_code', 10)->nullable();

            $table->timestamps(); 
            $table->timestamp('deleted_at')->nullable();
            $table->BigInteger('deleted_by')->nullable();
            $table->BigInteger('created_by')->nullable();
            $table->BigInteger('updated_by')->nullable();
        });

        Schema::create('sub_districts', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->nullable();
            $table->string('name', 255)->nullable();
            $table->BigInteger('province_id')->nullable();
            $table->BigInteger('city_id')->nullable();
            $table->timestamps(); 
            $table->timestamp('deleted_at')->nullable();
            $table->BigInteger('deleted_by')->nullable();
            $table->BigInteger('created_by')->nullable();
            $table->BigInteger('updated_by')->nullable();
        });

        //STANDARD 
        Schema::create('im_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable(false)->constrained('companies') ->onDelete('restrict');
            $table->string('code', 50)->nullable();
            $table->string('name', 200)->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_product_code_auto')->default(false);
            $table->boolean('is_stock')->default(true);
            $table->boolean('is_consignee')->default(false);

            $table->BigInteger('ac_ap_id')->nullable();
            $table->BigInteger('ac_hpp_id')->nullable();
            $table->BigInteger('ac_sales_id')->nullable();
            $table->BigInteger('ac_sales_return_id')->nullable();
            $table->BigInteger('ac_sales_disc_id')->nullable();

            $table->timestamps(); 
            $table->timestamp('deleted_at')->nullable();
            $table->BigInteger('deleted_by')->nullable();
            $table->BigInteger('created_by')->nullable();
            $table->BigInteger('updated_by')->nullable();
        });


        Schema::create('im_categories', function (Blueprint $table) {
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

        Schema::create('im_brands', function (Blueprint $table) {
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

        Schema::create('im_groups', function (Blueprint $table) {
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

        Schema::create('im_sub_groups', function (Blueprint $table) {
             $table->id();
            $table->foreignId('company_id')->nullable(false)->constrained('companies') ->onDelete('restrict');
            $table->string('code', 50)->nullable();
            $table->string('name', 200)->nullable();
            $table->boolean('is_active')->default(true);
            $table->BigInteger('group_id')->nullable();
            $table->timestamps(); 
            $table->timestamp('deleted_at')->nullable();
            $table->BigInteger('deleted_by')->nullable();
            $table->BigInteger('created_by')->nullable();
            $table->BigInteger('updated_by')->nullable();
        });


        Schema::create('im_uoms', function (Blueprint $table) {
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


          Schema::create('im_size_groups', function (Blueprint $table) {
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

        Schema::create('im_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable(false)->constrained('companies') ->onDelete('restrict');
            $table->BigInteger('size_group_id')->nullable();
            $table->string('code', 50)->nullable();
            $table->string('name', 200)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps(); 
            $table->timestamp('deleted_at')->nullable();
            $table->BigInteger('deleted_by')->nullable();
            $table->BigInteger('created_by')->nullable();
        });

         Schema::create('im_color_groups', function (Blueprint $table) {
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

        Schema::create('im_colors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable(false)->constrained('companies') ->onDelete('restrict');
            $table->BigInteger('color_group_id')->nullable();
            $table->string('code', 50)->nullable();
            $table->string('name', 200)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps(); 
            $table->timestamp('deleted_at')->nullable();
            $table->BigInteger('deleted_by')->nullable();
            $table->BigInteger('created_by')->nullable();
            $table->BigInteger('updated_by')->nullable();
        });

        Schema::create('im_adjustment_types', function (Blueprint $table) {
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

        Schema::create('im_warehouse_types', function (Blueprint $table) {
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

         Schema::create('im_warehouses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable(false)->constrained('companies') ->onDelete('restrict');
            $table->BigInteger('wh_type_id')->nullable();
            $table->string('code', 50)->nullable();
            $table->string('name', 200)->nullable();
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
            $table->string('fax')->nullable();
            $table->string('npwp')->nullable();
            $table->BigInteger('manager_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps(); 
            $table->timestamp('deleted_at')->nullable();
            $table->BigInteger('deleted_by')->nullable();
            $table->BigInteger('created_by')->nullable();
            $table->BigInteger('updated_by')->nullable();
        });

         Schema::create('im_racks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable(false)->constrained('companies') ->onDelete('restrict');
            $table->BigInteger('wh_id')->nullable();
            $table->string('code', 50)->nullable();
            $table->string('name', 200)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps(); 
            $table->timestamp('deleted_at')->nullable();
            $table->BigInteger('deleted_by')->nullable();
            $table->BigInteger('created_by')->nullable();
            $table->BigInteger('updated_by')->nullable();
        });

        Schema::create('im_price_types', function (Blueprint $table) {
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

         Schema::create('im_sales_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable(false)->constrained('companies') ->onDelete('restrict');
            $table->date('entry_date')->nullable();
            $table->BigInteger('price_type_id')->nullable();
            $table->BigInteger('prd_id')->nullable();
            $table->BigInteger('prd_det_id')->nullable();
            $table->BigInteger('uom_id')->nullable();
            $table->decimal('uom_ratio', 20, 4)->default(0);
            $table->decimal('price', 20, 4)->default(0);
            $table->timestamps(); 
            $table->timestamp('deleted_at')->nullable();
            $table->BigInteger('deleted_by')->nullable();
            $table->BigInteger('created_by')->nullable();
            $table->BigInteger('updated_by')->nullable();
        });

         Schema::create('im_purchase_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable(false)->constrained('companies') ->onDelete('restrict');
            $table->date('entry_date')->nullable();
            $table->BigInteger('prd_id')->nullable();
            $table->BigInteger('prd_det_id')->nullable();
            $table->BigInteger('uom_id')->nullable();
            $table->decimal('uom_ratio', 20, 4)->default(0);
            $table->decimal('price', 20, 4)->default(0);
            $table->timestamps(); 
            $table->timestamp('deleted_at')->nullable();
            $table->BigInteger('deleted_by')->nullable();
            $table->BigInteger('created_by')->nullable();
            $table->BigInteger('updated_by')->nullable();
        });

        Schema::create('im_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable(false)->constrained('companies') ->onDelete('restrict');
            $table->string('code', 50)->nullable();
            $table->string('name', 200)->nullable();
            $table->string('short_name', 200)->nullable();
            $table->boolean('is_active')->default(true);
            $table->BigInteger('prd_type_id')->nullable();
            $table->BigInteger('prd_cat_id')->nullable();
            $table->BigInteger('brand_id')->nullable();
            $table->BigInteger('group_id')->nullable();
            $table->BigInteger('sub_group_id')->nullable();
            $table->BigInteger('size_group_id')->nullable();
            $table->BigInteger('uom1_id')->nullable();
            $table->BigInteger('uom2_id')->nullable();
            $table->BigInteger('uom3_id')->nullable();
            $table->decimal('uom2_ratio', 20, 4)->default(0);
            $table->decimal('uom3_ratio', 20, 4)->default(0);
            $table->BigInteger('supp_id')->nullable();
            $table->string('supp_prd_code', 200)->nullable();
            $table->string('supp_prd_name', 200)->nullable();
            $table->decimal('min_stock', 20, 4)->default(0);
            $table->decimal('max_stock', 20, 4)->default(0);
            $table->string('header_image', 200)->nullable();
            $table->timestamps(); 
            $table->timestamp('deleted_at')->nullable();
            $table->BigInteger('deleted_by')->nullable();
            $table->BigInteger('created_by')->nullable();
            $table->BigInteger('updated_by')->nullable();
        });

        Schema::create('im_product_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable(false)->constrained('companies') ->onDelete('restrict');
            $table->BigInteger('seq_id')->nullable();
            $table->BigInteger('prd_id')->nullable();
            $table->BigInteger('color_id')->nullable();
            $table->BigInteger('size_id')->nullable();
            $table->timestamps(); 
            $table->BigInteger('created_by')->nullable();
            $table->BigInteger('updated_by')->nullable();
        });

         Schema::create('im_product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable(false)->constrained('companies') ->onDelete('restrict');
            $table->BigInteger('seq_id')->nullable();
            $table->BigInteger('prd_det_id')->nullable();
            $table->string('detail_image', 500);
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
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('sub_districts');

        Schema::dropIfExists('im_types');
        Schema::dropIfExists('im_categories');
        Schema::dropIfExists('im_brands');
        Schema::dropIfExists('im_groups');
        Schema::dropIfExists('im_sub_groups');
        Schema::dropIfExists('im_uoms');
        Schema::dropIfExists('im_size_groups');
        Schema::dropIfExists('im_sizes');
        Schema::dropIfExists('im_color_groups');
        Schema::dropIfExists('im_colors');
        Schema::dropIfExists('im_adjustment_types');
        Schema::dropIfExists('im_warehouses');
        Schema::dropIfExists('im_racks');
        Schema::dropIfExists('im_price_types');
        Schema::dropIfExists('im_sales_prices');
        Schema::dropIfExists('im_purchase_prices');


    }
};
