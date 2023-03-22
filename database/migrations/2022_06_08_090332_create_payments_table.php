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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('clients')->cascadeOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->cascadeOnDelete();
            $table->foreignId('bill_id')->nullable()->constrained('bills')->cascadeOnDelete();
            $table->foreignId('bank_id')->nullable()->constrained('banks')->cascadeOnDelete();
            $table->foreignId('expense_id')->nullable()->constrained('expenses')->cascadeOnDelete();
            $table->date('date')->nullable();
            $table->float('value')->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->nullable();
            $table->date('received_date')->nullable();
            $table->foreignId('received_bank_id')->nullable()->constrained('banks')->cascadeOnDelete();
            $table->enum('type' , ['مدفوعات' , 'مصروفات' ,'اقساط' ,'تحويلات'])->nullable();
            $table->dateTime('transaction_date')->nullable();
            $table->text('transaction_description')->nullable();
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
        Schema::dropIfExists('payments');
    }
};
