<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Login') }} - {{ config('app.name', 'Laravel') }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/login.css') }}">
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <!-- ------------------------------Content--------------------------- -->
    <div class="background"></div>
    <section class="home">
        <div class="content">
            <a href="{{ url('/') }}" class="logo">{{ config('app.name', 'Laravel') }}</a>
            <h2>{{ __('Welcome') }}</h2>
            <h3>{{ __('To Our Admin Panel') }}</h3>
        </div>
        
        <div class="login">
            <h2>{{ __('Login') }}</h2>
            
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf
                
                <!-- Email Input -->
                <div class="input {{ $errors->has('email') ? 'error' : '' }}">
                    <input 
                        id="email" 
                        type="email" 
                        class="input1 @error('email') is-invalid @enderror" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="{{ __('Email Address') }}" 
                        required 
                        autocomplete="email" 
                        autofocus>
                    <i class="fa-solid fa-envelope"></i>
                    
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Password Input -->
                <div class="input {{ $errors->has('password') ? 'error' : '' }}">
                    <input 
                        id="password" 
                        type="password" 
                        class="input1 @error('password') is-invalid @enderror" 
                        name="password" 
                        placeholder="{{ __('Password') }}" 
                        required 
                        autocomplete="current-password">
                    <i class="fa-solid fa-lock"></i>
                    
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Remember Me & Forgot Password -->
                <div class="check">
                    <label>
                        <input 
                            type="checkbox" 
                            name="remember" 
                            id="remember" 
                            {{ old('remember') ? 'checked' : '' }}>
                        {{ __('Remember Me') }}
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
                
                <!-- Login Button -->
                <div class="button">
                    <button type="submit" class="btn" id="loginBtn">
                        {{ __('Login') }}
                    </button>
                </div>
            </form>
            
            <!-- Sign Up Link -->
            @if (Route::has('register'))
                <div class="sign-up">
                    <p>{{ __("Don't have an account?") }}</p>
                    <a href="{{ route('register') }}">{{ __('Sign up') }}</a>
                </div>
            @endif
        </div>
    </section>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Toastr configuration
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000
        };

        // Show error messages using toastr
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif

        // Show success messages
        @if (session('status'))
            toastr.success("{{ session('status') }}");
        @endif

        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        // Form submission handling
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                const email = $('#email').val().trim();
                const password = $('#password').val().trim();
                
                // Basic validation
                if (!email || !password) {
                    e.preventDefault();
                    toastr.error('{{ __("Please fill in all fields") }}');
                    return false;
                }
                
                // Email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    e.preventDefault();
                    toastr.error('{{ __("Please enter a valid email address") }}');
                    return false;
                }
                
                // Disable button to prevent double submission
                $('#loginBtn').prop('disabled', true).text('{{ __("Logging in...") }}');
            });
            
            // Remove error class on input focus
            $('.input1').on('focus', function() {
                $(this).closest('.input').removeClass('error');
                $(this).siblings('.error-message').fadeOut();
            });
            
            // Auto-fill demo credentials (remove in production)
            @if (app()->environment('local'))
                // Double click to fill demo credentials
                $('.logo').on('dblclick', function() {
                    $('#email').val('admin@admin.com');
                    $('#password').val('password');
                    toastr.info('Demo credentials filled');
                });
            @endif
        });
    </script>
</body>

</html>