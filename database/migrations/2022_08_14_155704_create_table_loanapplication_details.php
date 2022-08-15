<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLoanapplicationDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_loanapplication_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');
            $table->double('installment_amount',8,2);
            $table->date('payment_date');
            $table->enum('installment_status',[0,1])->default(0)->comment('0 pending 1 paid');
            $table->integer('paid_by')->default(0);
            $table->double('installment_paid_amount',8,2)->default(0);
            $table->date('installment_paid_date')->nullable();
            $table->foreign('application_id')->references('id')->on('table_loanapplications')->onDelete('cascade');
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
        Schema::dropIfExists('table_loanapplication_details');
    }
}
