<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStandardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->text('desc');
            $table->text('desc_en')->nullable();
            $table->string('brand');
            $table->string('brand_en')->nullable();
            $table->string('origin');
            $table->string('origin_en')->nullable();

            $table->timestamps();
        });

        Schema::create('item_images', function (Blueprint $table) {
            $table->foreignId('item_id')->primary()->constrained('items');
            $table->string('image');

            $table->timestamps();
        });

        Schema::create('item_utils', function (Blueprint $table) {
            $table->foreignId('item_id')->primary()->constrained('items')->cascadeOnDelete();
            $table->boolean('is_listed');
            $table->bigInteger('view_count');

            $table->timestamps();
        });



        Schema::create('variations', function (Blueprint $table) {
            $table->id();
            $table->string('barcode');
            $table->string('name1'); // e.g. Spicy
            $table->string('name2'); // e.g. 24g x 20
            $table->string('name1_en')->nullable();
            $table->string('name2_en')->nullable();
            $table->double('weight');
            $table->double('price');
            $table->string('image');
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::create('variation_relationships', function (Blueprint $table) {
            // e.g. Spicy 24g x 20
            $table->foreignId('parent')->constrained('variations')->cascadeOnDelete();
            // e.g. Spicy 24g x 1
            $table->foreignId('child')->constrained('variations')->cascadeOnDelete();

            $table->timestamps();

            $table->primary(['parent','child']);
        });

        Schema::create('variation_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variation_id')->constrained('variations')->cascadeOnDelete();
            $table->dateTime('start');
            $table->dateTime('end')->nullable();
            $table->double('rate')->default(1.0);

            $table->timestamps();
        });

        Schema::create('wholesale_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->dateTime('start');
            $table->dateTime('end')->nullable();
            $table->double('rate')->default(1.0);

            $table->timestamps();
        });

        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variation_id')->constrained('variations')->cascadeOnDelete();
            $table->date('expire_date');
            $table->integer('quantity');

            $table->timestamps();
        });


        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->string('status'); // Enable or Disable

            $table->timestamps();
        });

        Schema::create('classifications', function (Blueprint $table) {
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();

            $table->timestamps();

            $table->primary(['item_id', 'category_id']);
        });



        Schema::create('customers', function (Blueprint $table) {
            $table->foreignId('order_id')->primary()->constrained('orders')->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('addressLine1');
            $table->string('addressLine2')->nullable();
            $table->string('postal_code');
            $table->string('area');
            $table->string('state');
            $table->string('country')->default("Malaysia");

            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code');
            $table->string('order_mode')->default('Pick Up'); // Pick Up or Delivery
            $table->string('delivery_id')->nullable();
            $table->string('payment_method');
            $table->string('order_verify_id'); // Use to verify the pick up mode's order
            $table->string('status')->default('待处理');
            $table->string('receipt_image');

            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('name');
            $table->string('barcode');
            $table->double('price');
            $table->double('discount_rate')->default(1.0);
            $table->integer('quantity');
            $table->date('expire_date');

            $table->timestamps();
        });

        Schema::create('order_operations', function (Blueprint $table) {
            $table->dateTime('operated_on');
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('action');
            $table->string('status');

            $table->timestamps();

            $table->primary(['operated_on', 'order_id']);
        });



        Schema::create('item_user_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->integer('star');
            $table->dateTime('rated_on');
            $table->string('identity'); // unique browser identity

            $table->timestamps();
        });

        Schema::create('system_configs', function (Blueprint $table) {
            $table->string('name')->primary();
            $table->string('value');
            $table->text('desc');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
        Schema::dropIfExists('item_images');
        Schema::dropIfExists('item_utils');

        Schema::dropIfExists('variations');
        Schema::dropIfExists('variation_relationships');
        Schema::dropIfExists('variation_discounts');
        Schema::dropIfExists('wholesale_discounts');
        Schema::dropIfExists('inventories');

        Schema::dropIfExists('categories');
        Schema::dropIfExists('classifications');

        Schema::dropIfExists('customers');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('order_operations');

        Schema::dropIfExists('item_user_ratings');
        Schema::dropIfExists('system_configs');
    }
}
