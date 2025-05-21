<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('room_id');
            $table->integer('months_paid');
            $table->integer('overdue_months')->default(0)->nullable();
            $table->decimal('penalty_amount', 8, 2)->default(0);
            $table->decimal('total_amount', 8, 2);
            $table->string('payment_method');
            $table->string('image');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->date('payment_date');
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
