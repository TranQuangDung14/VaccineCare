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
        Schema::create('vaccines', function (Blueprint $table) {
            $table->id();
            $table->string("name",1000)->nullable();
            $table->integer("diseases_id")->unsigned()->nullable();
            $table->text("description")->nullable(); 
            $table->integer("doses_required")->nullable()->unsigned();// số mũi cần tiêm
            $table->integer("dose_intervals")->nullable()->unsigned();// chu kì thời gian
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccines');
    }
};
