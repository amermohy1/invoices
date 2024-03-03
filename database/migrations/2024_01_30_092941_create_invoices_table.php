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
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->string('invoice_number',50);
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('product',50);
            $table->bigInteger( 'section_id' )->unsigned();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->decimal('Amount_collection',10,2)->nullable();;
            $table->decimal('Amount_Commission',10,2);
            $table->decimal('discount',10,2);
            $table->string('rate_vat');
            $table->decimal('value_vat',10,2);
            $table->decimal('total',10,2);
            $table->string('status',50);
            $table->integer('value_status');
            $table->text('note')->nullable();
            $table->date('Payment_Date')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
};
