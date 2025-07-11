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
        Schema::create('fatwas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // السائل
        $table->foreignId('sheikh_id')->nullable()->constrained('users')->onDelete('set null'); // الشيخ
        $table->string('question');
        $table->text('answer')->nullable();
        $table->foreignId('category_id')->nullable()->constrained();
        $table->enum('status', ['pending', 'assigned', 'answered'])->default('pending');
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
        Schema::dropIfExists('fatwas');
    }
};
