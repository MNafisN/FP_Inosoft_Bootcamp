<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructions', function (Blueprint $table) {
            $table->id();
            $table->string('instruction_id')->unique();
            $table->string('instruction_type');
            $table->timestamps();
            $table->string('assigned_vendor');
            $table->string('vendor_address');
            $table->string('attention_of');
            $table->integer('quotation_number');
            $table->string('invoice_to');
            $table->string('customer_contact');
            $table->string('customer_po_number');
            $table->cost_detail();
            $table->attachment();
            $table->text('notes');
            $table->string('transaction_code');
            $table->invoices();
            $table->termination();
            $table->string('instruction_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instructions');
    }
};
