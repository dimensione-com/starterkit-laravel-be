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
        Schema::create('ente', function (Blueprint $table)
        {
            $table->id('id');
            $table->string('name_ente');
            $table->string('addres_ente');
            $table->enum('type_ente', ['pubblico', 'privato']);
            $table->string('partita_iva_ente')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ente');
    }
};
