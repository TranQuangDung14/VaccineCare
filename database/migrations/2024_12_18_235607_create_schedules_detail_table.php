<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules_detail', function (Blueprint $table) {
            $table->id();
            $table->integer("vaccination_schedules_id")->unsigned()->nullable();
            $table->integer("dose_number")->nullable()->unsigned(); // thứ tự mũi tiêm
            $table->date("scheduled_date")->nullable();
            $table->date("administered_date")->nullable();
            $table->integer("status")->default(0)->comment('0: chưa tiêm, 1: đã tiêm, 2: bị lỡ'); //(0: chưa tiêm,1: đã tiêm, 2: bị lỡ)
            $table->text("notes")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules_detail');
    }
};
