<?php

namespace App\Http\Controllers;

use App\Enums\AccountType;
use App\Services\UserService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): View
    {
        session(['account_edit' => false]);
        session(['account' => true]);

        return view('account', ['companies' => $this->userService->getUserCompanies()]);
    }

    public function edit(): View
    {
        session(['account_edit' => true]);
        return view('account', ['companies' => $this->userService->getUserCompanies()]);
    }

    public function register(Request $request): RedirectResponse|View
    {
        $result = $this->userService->register($request->except('_token'));

        // add check if password and repeat password is the same!
        // implement server side validations in more advanced way!

        if ($result['success']) {
            return redirect()->route('login')->with(['success' => $result['message']]);
        } else {
            return redirect()->route('register')->withErrors(['error' => $result['error']])->withInput();
        }
    }

    public function login(Request $request): RedirectResponse|View
    {
        $result = $this->userService->login($request->except('_token'));

        if ($result['success']) {
            session(['user_data' => $result['user']]);
            return redirect()->route('invoices')->with(['user' => $result['user']]);

            // make check if user is administrator or business user!
        } else {
            return redirect()->route('login')->withErrors(['message' => $result['message']])->withInput();
        }
    }

    public function logout(): Redirector|Application|RedirectResponse
    {
        $this->userService->logout();

        session()->forget('user_data');

        return redirect('/');
    }

    public function manageRequests(): Factory|View|Application
    {
        $result = $this->userService->getUserData($this->userService->getUserIdWeb());

        if ($result['success'] && $result['user']['account_type'] == AccountType::ADMINISTRATOR->value) {
            $user_registration_requests = $this->userService->getRegistrationRequests(
                $this->userService->getUserIdWeb())['user_registration_requests'];
            return view('manage_user_registration_requests', ['user_registration_requests' =>
                $user_registration_requests]);
        } else {
            return view('permission_denied');
        }
    }

    public function updateRequestStatus(Request $request): RedirectResponse
    {
        $request_array = $request->except('_token');

        $result = $this->userService->updateApprovalStatus($request_array, $request_array['user_registration_request'],
            $this->userService->getUserIdWeb());

        if ($result['success']) {
            return redirect()->route('user_registration_requests',
                ['company' => request()->query('company')])->with(['message' => $result['message']]);
        } else {
            return back()->withErrors(['message' => $result['message']]);
        }
    }

    //TODO move backup and restore into service layer!

    public function backupDatabase(): Factory|View|BinaryFileResponse|Application|string
    {
        $result = $this->userService->getUserData($this->userService->getUserIdWeb());

        if ($result['success'] && $result['user']['account_type'] == AccountType::ADMINISTRATOR->value) {

            $backup_file_name = 'backup_' . date('Y-m-d_His') . '.sql';
            $backup_directory = storage_path('app/backups/');
            $backup_file_path = $backup_directory . $backup_file_name;

            if (!is_dir($backup_directory)) {
                mkdir($backup_directory, 0755, true);
            }

            $command = sprintf(
                'mysqldump -u%s -p%s %s > "%s"',
                env('DB_USERNAME'),
                env('DB_PASSWORD'),
                env('DB_DATABASE'),
                $backup_file_path
            );

            exec($command);

            if (file_exists($backup_file_path)) {
                $temp_file_path = tempnam(sys_get_temp_dir(), 'backup_');
                file_put_contents($temp_file_path, file_get_contents($backup_file_path));
                return response()->download($temp_file_path, $backup_file_name)->deleteFileAfterSend();
            } else {
                return 'Internal Server Error occurred while backing up your database';
            }
        } else {
            return view('permission_denied');
        }
    }

    public function restoreDatabase(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'fileInput' => [
                    'required',
                    'file',
                    function ($attribute, $value, $fail) {
                        $content = File::get($value);
                        if (!preg_match('/\b(SELECT|INSERT|UPDATE|DELETE)\b/i', $content)) {
                            $fail('The uploaded file does not appear to be a valid SQL file');
                        }
                    },
                    'min:1',
                    'max:12288',
                ],
            ]);

            $file = $request->file('fileInput');

            $path = $file->storeAs('backups', 'db_restore' . $file->getClientOriginalName());

            $command = sprintf(
                'mysql -u%s -p%s %s < "%s"',
                env('DB_USERNAME'),
                env('DB_PASSWORD'),
                env('DB_DATABASE'),
                storage_path('app/' . $path)
            );

            shell_exec($command);

            Storage::delete($path);

            return redirect()->route('login')->with(['success' => 'Database successfully restored']);
        } catch (Exception $e) {
            return redirect()->route('login')->withErrors(['message' =>
                'Failed to restore database: ' . $e->getMessage()]);
        }
    }
}
