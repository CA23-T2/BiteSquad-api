<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->enum('role', ['Employee', 'Admin'])->default('Employee');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        $admin = new User([
            'username' => 'Administrator',
            'email' => 'admin@example.com',
            'role' => 'Admin',
            'first_name' => 'Lorem',
            'last_name' => 'Ipsum',
            'password' => Hash::make('tinjalica123'),
        ]);

        $admin->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
