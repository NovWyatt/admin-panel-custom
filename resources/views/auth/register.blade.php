<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Register') }} - {{ config('app.name', 'Laravel') }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/signup.css') }}">
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


</head>

<body>
    <!-- ------------------------------Content--------------------------- -->
    <div class="background"></div>
    <section class="home">
        <div class="content">
            <a href="{{ url('/') }}" class="logo">{{ config('app.name', 'Laravel') }}</a>
            <h2>{{ __('Join Us') }}</h2>
            <h3>{{ __('Create Your Account Today') }}</h3>
        </div>
        
        <div class="login">
            <h2>{{ __('Register') }}</h2>
            
            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf
                
                <!-- Name Input -->
                <div class="input {{ $errors->has('name') ? 'error' : '' }}">
                    <input 
                        id="name" 
                        type="text" 
                        class="input1 @error('name') is-invalid @enderror" 
                        name="name" 
                        value="{{ old('name') }}" 
                        placeholder="{{ __('Full Name') }}" 
                        required 
                        autocomplete="name" 
                        autofocus>
                    <i class="fa-solid fa-user"></i>
                    
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
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
                        autocomplete="email">
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
                        autocomplete="new-password">
                    <i class="fa-solid fa-lock"></i>
                    
                    <!-- Password Strength Indicator -->
                    <div class="password-strength">
                        <div class="password-strength-bar" id="strengthBar"></div>
                    </div>
                    
                    <!-- Password Requirements -->
                    <div class="password-requirements" id="passwordRequirements">
                        <span class="requirement" id="req-length">{{ __('At least 8 characters') }}</span>
                        <span class="requirement" id="req-uppercase">{{ __('One uppercase letter') }}</span>
                        <span class="requirement" id="req-lowercase">{{ __('One lowercase letter') }}</span>
                        <span class="requirement" id="req-number">{{ __('One number') }}</span>
                    </div>
                    
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Confirm Password Input -->
                <div class="input {{ $errors->has('password_confirmation') ? 'error' : '' }}">
                    <input 
                        id="password_confirmation" 
                        type="password" 
                        class="input1" 
                        name="password_confirmation" 
                        placeholder="{{ __('Confirm Password') }}" 
                        required 
                        autocomplete="new-password">
                    <i class="fa-solid fa-lock"></i>
                    
                    @error('password_confirmation')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Terms and Conditions -->
                <div class="check">
                    <label>
                        <input 
                            type="checkbox" 
                            name="terms" 
                            id="terms" 
                            required>
                        {{ __('I agree to the') }} 
                        <a href="#" target="_blank">{{ __('Terms & Conditions') }}</a>
                    </label>
                </div>
                
                <!-- Register Button -->
                <div class="button">
                    <button type="submit" class="btn" id="registerBtn">
                        {{ __('Create Account') }}
                    </button>
                </div>
            </form>
            
            <!-- Login Link -->
            <div class="sign-up">
                <p>{{ __("Already have an account?") }}</p>
                <a href="{{ route('login') }}">{{ __('Sign in') }}</a>
            </div>
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

        $(document).ready(function() {
            // Password strength checker
            $('#password').on('input', function() {
                const password = $(this).val();
                checkPasswordStrength(password);
                checkPasswordMatch();
            });

            // Password confirmation checker
            $('#password_confirmation').on('input', function() {
                checkPasswordMatch();
            });

            // Password strength function
            function checkPasswordStrength(password) {
                let strength = 0;
                const requirements = {
                    length: password.length >= 8,
                    uppercase: /[A-Z]/.test(password),
                    lowercase: /[a-z]/.test(password),
                    number: /\d/.test(password)
                };

                // Update requirement indicators
                $('#req-length').toggleClass('met', requirements.length);
                $('#req-uppercase').toggleClass('met', requirements.uppercase);
                $('#req-lowercase').toggleClass('met', requirements.lowercase);
                $('#req-number').toggleClass('met', requirements.number);

                // Calculate strength
                strength = Object.values(requirements).filter(Boolean).length;

                // Update strength bar
                const strengthBar = $('#strengthBar');
                strengthBar.removeClass('strength-weak strength-fair strength-good strength-strong');
                
                switch(strength) {
                    case 1:
                        strengthBar.addClass('strength-weak');
                        break;
                    case 2:
                        strengthBar.addClass('strength-fair');
                        break;
                    case 3:
                        strengthBar.addClass('strength-good');
                        break;
                    case 4:
                        strengthBar.addClass('strength-strong');
                        break;
                }
            }

            // Password match checker
            function checkPasswordMatch() {
                const password = $('#password').val();
                const confirmPassword = $('#password_confirmation').val();
                const confirmInput = $('#password_confirmation').closest('.input');

                if (confirmPassword && password !== confirmPassword) {
                    confirmInput.addClass('error');
                    if (!confirmInput.find('.error-message').length) {
                        confirmInput.append('<span class="error-message">{{ __("Passwords do not match") }}</span>');
                    }
                } else {
                    confirmInput.removeClass('error');
                    confirmInput.find('.error-message').remove();
                }
            }

            // Form submission handling
            $('#registerForm').on('submit', function(e) {
                const name = $('#name').val().trim();
                const email = $('#email').val().trim();
                const password = $('#password').val();
                const confirmPassword = $('#password_confirmation').val();
                const terms = $('#terms').is(':checked');
                
                // Basic validation
                if (!name || !email || !password || !confirmPassword) {
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
                
                // Password validation
                if (password.length < 8) {
                    e.preventDefault();
                    toastr.error('{{ __("Password must be at least 8 characters long") }}');
                    return false;
                }
                
                // Password confirmation
                if (password !== confirmPassword) {
                    e.preventDefault();
                    toastr.error('{{ __("Passwords do not match") }}');
                    return false;
                }
                
                // Terms acceptance
                if (!terms) {
                    e.preventDefault();
                    toastr.error('{{ __("Please accept the terms and conditions") }}');
                    return false;
                }
                
                // Disable button to prevent double submission
                $('#registerBtn').prop('disabled', true).text('{{ __("Creating Account...") }}');
            });
            
            // Remove error class on input focus
            $('.input1').on('focus', function() {
                const inputContainer = $(this).closest('.input');
                inputContainer.removeClass('error');
                inputContainer.find('.error-message').fadeOut();
            });
            
            // Name validation (only letters and spaces)
            $('#name').on('input', function() {
                const name = $(this).val();
                const nameRegex = /^[a-zA-ZÀ-ÿ\s]*$/;
                
                if (name && !nameRegex.test(name)) {
                    $(this).val(name.replace(/[^a-zA-ZÀ-ÿ\s]/g, ''));
                }
            });

            // Real-time email validation
            $('#email').on('blur', function() {
                const email = $(this).val().trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                const inputContainer = $(this).closest('.input');
                
                if (email && !emailRegex.test(email)) {
                    inputContainer.addClass('error');
                    if (!inputContainer.find('.error-message').length) {
                        inputContainer.append('<span class="error-message">{{ __("Please enter a valid email address") }}</span>');
                    }
                } else {
                    inputContainer.removeClass('error');
                    inputContainer.find('.error-message').remove();
                }
            });
        });
    </script>
</body>

</html>