<?php

namespace App\Http\Controllers;

use App\Enums\AccountType;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Throwable;

/**
 * @property string email
 */
class UserController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        try {
            $validated_data = $request->validate([
                'first_name' => 'required',
                'middle_name' => 'nullable',
                'last_name' => 'required',
                'username' => 'required|min:5',
                'email' => 'required|email',
                'password' => 'required|min:8',
                'country' => 'required|min:2|max:2',
                'city' => 'required',
                'postal_code' => 'required',
                'address' => 'required',
                'phone' => 'required',
                'fax' => 'nullable',
            ]);

            $validated_data['password'] = Hash::make($validated_data['password']);

            $validated_data['is_active'] = false;
            $validated_data['account_type'] = AccountType::BUSINESS;

            $user = (new User)->create($validated_data);

            $token = $user->createToken('api_token')->plainTextToken;
            $token_expiration = Carbon::now()->addMinutes(config('sanctum.expiration'));

            return response()->json(['message' => 'User registered successfully', 'token' => $token,
                'token_expiration' => $token_expiration], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Email or Password is not provided!',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email or Password is incorrect',
                ], 401);
            }

            $user = (new User)->where('email', $request['email'])->firstOrFail();
            $token = $user->createToken('api_token')->plainTextToken;
            $token_expiration = Carbon::now()->addMinutes(config('sanctum.expiration'));

            return response()->json([
                'message' => 'User Logged In Successfully',
                'user' => $user,
                'token' => $token,
                'token_expiration' => $token_expiration
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
