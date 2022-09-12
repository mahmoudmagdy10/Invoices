<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices_details', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->string('status',50);
            $table->integer('value_status');
            $table->text('note')->nullable();
            $table->date('pay_date')->nullable();
            $table->string('user',255);
            $table->foreignId('invoice_id')
                ->constrained('invoices')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('section_id')
                ->constrained('sections')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('product_id')
                ->constrained('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('invoices_details');
    }
}
