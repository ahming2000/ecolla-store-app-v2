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
            $table->string('brand');
            $table->string('brand_en')->nullable();
            $table->string('origin');
            $table->string('origin_en')->nullable();

            $table->timestamps();
        });

        Schema::create('item_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items');
            $table->string('image');

            $table->timestamps();
        });

        Schema::create('item_utils', function (Blueprint $table) {
            $table->foreignId('item_id')->primary()->constrained('items')->cascadeOnDelete();
            $table->boolean('is_listed')->default('0');
            $table->bigInteger('view_count')->default(0);
            $table->bigInteger('sold')->default(0);

            $table->timestamps();
        });

        Schema::create('wholesale_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->integer('step');
            $table->integer('min');
            $table->integer('max')->nullable();
            $table->double('rate')->default(1.0);

            $table->timestamps();
        });


        Schema::create('variations', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->unique();
            $table->string('name1'); // e.g. Spicy
            $table->string('name2'); // e.g. 24g x 20
            $table->string('name1_en')->nullable();
            $table->string('name2_en')->nullable();
            $table->double('price');
            $table->double('weight');
            $table->string('image')->nullable();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::create('variation_discounts', function (Blueprint $table) {
            $table->foreignId('variation_id')->primary()->constrained('variations')->cascadeOnDelete();
            $table->dateTime('start');
            $table->dateTime('end')->nullable();
            $table->double('rate')->default(1.0);

            $table->timestamps();
        });

        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variation_id')->constrained('variations')->cascadeOnDelete();
            $table->date('expire_date');
            $table->integer('stock');

            $table->timestamps();
        });


        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_en')->nullable();

            $table->timestamps();
        });

        Schema::create('category_item', function (Blueprint $table) {
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();

            $table->timestamps();

            $table->primary(['item_id', 'category_id']);
        });


        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('mode')->default('pickup'); // pickup/delivery
            $table->string('delivery_id')->nullable(); // Use to track delivery mode's delivery status
            $table->string('order_verify_id')->nullable(); // Use to verify the pick up mode's order
            $table->double('shipping_fee')->default(0.0);
            $table->string('payment_method'); // boost/tng/bank-in/quin-pay/duit-now
            $table->string('status')->default('pending'); // pending/prepared/completed/refunded/canceled
            $table->string('receipt_image');

            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->foreignId('id')->primary()->constrained('orders')->cascadeOnDelete();
            $table->string('name');
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


        Schema::create('item_user_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->integer('star'); // 1 to 5
            $table->string('user_ip');

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
        Schema::dropIfExists('wholesale_discounts');

        Schema::dropIfExists('variations');
        Schema::dropIfExists('variation_discounts');
        Schema::dropIfExists('inventories');

        Schema::dropIfExists('categories');
        Schema::dropIfExists('category_item');

        Schema::dropIfExists('orders');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('order_items');

        Schema::dropIfExists('item_user_ratings');
        Schema::dropIfExists('system_configs');
    }
}
