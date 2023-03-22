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
        Schema::create('item_children', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable()->unique()->index();
            $table->foreignId('item_id')->nullable()->constrained('items')->cascadeOnDelete();
//            $table->foreignId('stock_id')->nullable()->constrained('stocks')->cascadeOnDelete();
            $table->date('expire_date')->nullable();
            $table->string('lot_number')->nullable();
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
        Schema::dropIfExists('item_children');
    }
};
