@php use App\Enums\AccountType; @endphp
<p>Welcome to dashboard :D</p>

@if (Session::has('user'))
    <div class="alert alert-success mb-4">
        {{ session('user')['email'] }}
        {{ session('user')['username'] }}
        @if(session('user')['account_type'] == AccountType::ADMINISTRATOR->value)
            <p>Congrats, you are the administrator!</p>
        @endif
    </div>
@endif
