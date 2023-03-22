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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('clients')->cascadeOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->cascadeOnDelete();
            $table->foreignId('stock_id')->nullable()->constrained('stocks')->cascadeOnDelete();
            $table->foreignId('method_id')->nullable()->constrained('methods')->cascadeOnDelete();
            $table->string('code')->nullable()->unique()->index();
            $table->enum('type' , ['purchase' , 'sale' , 'exchange'])->nullable();
            $table->date('date')->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
};
