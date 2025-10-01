<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicineExpirationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicine_expirations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_stock_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->date('expiry_date');
            $table->enum('status', ['active', 'expired', 'disposed'])->default('active');
            $table->text('disposal_notes')->nullable();
            $table->timestamp('disposed_at')->nullable();
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
        Schema::dropIfExists('medicine_expirations');
    }
}
