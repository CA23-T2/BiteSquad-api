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
            $table->string('profile_picture')
                ->default('https://static.vecteezy.com/system/resources/thumbnails/009/292/244/small/default-avatar-icon-of-social-media-user-vector.jpg');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreignId('role_id')->default(1)->constrained('roles');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });

        User::create([
            'username' => 'Customer',
            'email' => 'customer@example.com',
            'role_id' => 1,
            'first_name' => 'Lorem',
            'last_name' => 'Ipsum',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'username' => 'Employee',
            'email' => 'employee@example.com',
            'role_id' => 2,
            'first_name' => 'Lorem',
            'last_name' => 'Ipsum',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'username' => 'Administrator',
            'email' => 'admin@example.com',
            'role_id' => 3,
            'first_name' => 'Lorem',
            'last_name' => 'Ipsum',
            'password' => Hash::make('password'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
