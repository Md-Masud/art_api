<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
            ->constrained()
            ->onUpdate('cascade');
        $table->integer('sub_category_id')->nullable();
        $table->string('name');
        $table->string('slug');
        $table->string('code');
        $table->string('unit')->nullable();
        $table->string('video')->nullable();
        $table->string('selling_price')->nullable();
        $table->string('discount_price')->nullable();
        $table->string('stock_quantity')->nullable();
        $table->string('size')->nullable();
        $table->string('color')->nullable();
        $table->boolean('status')->default(0)->nullable();
        $table->text('description')->nullable();
        $table->string('thumbnail')->nullable();
        $table->string('images')->nullable();
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
        Schema::dropIfExists('products');
    }
}
