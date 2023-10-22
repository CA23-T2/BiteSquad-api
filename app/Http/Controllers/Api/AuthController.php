<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            "name" => ['required', 'max:255'],
            "surname" => ['required', 'max:255'],
            "email" => ['required', 'email', 'max:255', 'unique:users'],
            "username" => ['required', 'max:255', 'unique:users', 'alpha_dash'],
            "password" => ['required', 'confirmed', 'min:8', 'max:255']
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = new User();

        $user->username = $request->username;
        $user->first_name = $request->name;
        $user->last_name = $request->surname;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $token = $user->createToken(Str::random(40))->plainTextToken;

            return new JsonResponse([
                "success" => true,
                "message" => "Register success!",
                "data" => ["token" => $token]
            ], 200);

        } else {
            return new JsonResponse('Invalid email or password', Response::HTTP_UNAUTHORIZED);
        }
    }

    public function login(Request $request) {

        $validator = Validator::make($request->all(), [
            "email" => ['required', 'email', 'max:255'],
            "password" => ['required', 'min:8', 'max:255']
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();

            $token = $user->createToken(Str::random(40))->plainTextToken;

            $user->update();

            return new JsonResponse([
                "success" => true,
                "message" => "Login success!",
                "data" => ["token" => $token]
            ], 200);

        } else {
            return new JsonResponse([
                "success" => false,
                "message" => "Invalid email or password!",
                "data" => []
            ], Response::HTTP_UNAUTHORIZED);
        }
    }
}
