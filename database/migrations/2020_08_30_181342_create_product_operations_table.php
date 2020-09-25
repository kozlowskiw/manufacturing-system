<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->foreignId('operation_id');
            $table->integer('expected_execution_time');
            $table->float('wspk', 4, 2);
            $table->boolean('measured_correctly');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_operations');
    }
}
