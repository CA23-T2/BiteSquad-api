<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('setting')->unique();
            $table->string('value')->unique();
            $table->timestamps();
        });

        Setting::create(['name' => 'Vrijeme do kojeg su otvorene narudžbine', 'setting' => 'order_time_restriction', 'value' => '9']);
        Setting::create(['name' => 'E-mail destinacija faktura', 'setting' => 'invoice_email_destination', 'value' => 'admin@example.com', 'description' => 'E-mail adresa koja prima fakture.']);
        Setting::create(['name' => 'Rezolucija izlaza fotografije OpenAI DALL-E', 'setting' => 'dall-e_output_resolution', 'value' => '256x256', 'description' => 'Veća rezolucija znači bolji kvalitet što takođe znači veća cijena']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
