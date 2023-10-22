<?php

use App\Models\Status;
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
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color')->nullable();
            $table->timestamps();
        });

        Status::create(['name'=>'Na čekanju', 'color' => '#737d00']); // proliv zuta
        Status::create(['name'=>'Potvrđeno', 'color' => '#1500ff']); // plavo
        Status::create(['name'=>'Poništeno', 'color' => '#ff0000']); // crveno
        Status::create(['name'=>'U pripremi', 'color' => '#ff8800']); // narandzasto
        Status::create(['name'=>'Spremno', 'color' => '#00d9ff']); // cyan
        Status::create(['name'=>'Dostavlja se', 'color' => '#5d00ff']); // purple
        Status::create(['name'=>'Gotovo', 'color' => '#00ff15']); // zeleno
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
