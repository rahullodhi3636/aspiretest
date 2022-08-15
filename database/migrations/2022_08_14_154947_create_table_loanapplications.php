<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLoanapplications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_loanapplications', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('loan_type');
            $table->double('loan_amount',8,2);
            $table->integer('loan_term');
            $table->enum('loan_status',[0, 1])->default(0)->comment('0 pending 1 approved');
            $table->enum('loan_payment_status',[0, 1])->default(0)->comment('0 pending 1 Paid');
            $table->date('loan_paid_date')->nullable();
            $table->integer('status_updated_by');
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
        Schema::dropIfExists('table_loanapplications');
    }
}
