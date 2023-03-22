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
        Schema::table('bill_item', function (Blueprint $table) {
            $table->enum('discount_type' , ['نسبة %' ,'مبلغ'])->default('نسبة %');
            $table->enum('tax_type' , ['نسبة %' ,'مبلغ'])->default('نسبة %');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bill_item', function (Blueprint $table) {
            $table->dropColumn('discount_type');
            $table->dropColumn('tax_type');
        });
    }
};
