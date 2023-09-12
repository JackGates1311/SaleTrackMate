<?php

namespace App\Services;

use App\Enums\AccountType;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserService
{
    private User $user_model;
    private CompanyService $companyService;

    public function __construct(User $user_model, CompanyService $companyService)
    {
        $this->user_model = $user_model;
        $this->companyService = $companyService;
    }

    public function register(array $userData): array
    {
        $validator = Validator::make($userData, User::$rules);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()];
        }

        $userData['password'] = Hash::make($userData['password']);
        $userData['is_active'] = false;
        $userData['account_type'] = AccountType::BUSINESS;

        try {

            $user = (new User)->create($userData);
            return $this->generateSuccessResponse($user, 'You have registered successfully');

        } catch (QueryException $exception) {

            if ($this->isDuplicateEntryError($exception, $userData['email'])) {
                return ['success' => false, 'error' => 'User is already registered with entered email address'];
            }

            return ['success' => false, 'error' => 'An error occurred during registration'];
        }
    }

    public function login(array $credentials): array
    {
        $validateUser = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validateUser->fails()) {
            return ['success' => false, 'message' => 'Email or Password is not provided',
                'error' => $validateUser->errors()];
        }

        if (!Auth::attempt($credentials)) {
            return ['success' => false, 'message' => 'Email or Password is incorrect',
                'error' => 'Email or Password is incorrect'];
        }

        $user = $this->user_model->where('email', $credentials['email'])->firstOrFail();

        if ($user->is_active) {
            return $this->generateSuccessResponse($user, 'User Logged In successfully');
        } else {
            return ['success' => false, 'message' => 'Account pending administrator approval',
                'error' => 'Account pending administrator approval'];
        }
    }

    private function generateSuccessResponse(User $user, string $message): array
    {
        $token = $user->createToken('api_token')->plainTextToken;
        $tokenExpiration = Carbon::now()->addMinutes(config('sanctum.expiration'));

        return [
            'success' => true,
            'message' => $message,
            'user' => $user,
            'token' => $token,
            'token_expiration' => $tokenExpiration
        ];
    }

    private function isDuplicateEntryError(QueryException $exception, string $email): bool
    {
        return str_contains($exception->getMessage(), "Duplicate entry '$email'");
    }

    public function getUserCompanies(): array
    {
        $result = $this->companyService->findByUserId($this->getUserIdWeb());

        return $result['companies']->toArray();
    }

    public function logout(): void
    {
        Auth::guard('web')->logout();
    }

    public function getUserIdApi(): string
    {
        $user = auth('api')->user();

        $user_id = '';

        if (isset($user->id)) {
            $user_id = $user->id;
        }
        return $user_id;
    }

    public function getUserIdWeb(): string
    {
        $user = auth('web')->user();

        $user_id = '';

        if (isset($user->id)) {
            $user_id = $user->id;
        }
        return $user_id;
    }
}
