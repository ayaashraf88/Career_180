@extends('components.layouts.app')
@section('content')
<!-- Alpine.js Root -->
<div x-data="{ showPassword: false ,confirmPassword:false}" class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-semibold">
                    {{ __('Login') }}
                </div>

                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Oops!</strong> Please check the following errors:
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input
                                id="name"
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autocomplete="name"
                                autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input
                                id="email"
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3"
                            x-data="{
         isFocused: false,
         password: '',
         confirmPassword: '',
         passwordsMatch: true,
         showPassword: false,
         showConfirmPassword: false
     }">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <div class="input-group">
                                <input
                                    :type="showPassword ? 'text' : 'password'"
                                    id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password"
                                    required
                                    autocomplete="new-password"
                                    x-model="password"
                                    @input="passwordsMatch = (password === confirmPassword)">
                                <button
                                    class="btn btn-outline-secondary"
                                    type="button"
                                    @click="showPassword = !showPassword">
                                    <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                </button>
                            </div>

                            <!-- Confirm Password Field -->
                            <label for="confirmPassword" class="form-label mt-3">{{ __('Confirm Password') }}</label>
                            <div class="input-group">
                                <input
                                    :type="showConfirmPassword ? 'text' : 'password'"
                                    id="confirmPassword"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    x-model="confirmPassword"
                                    @input="passwordsMatch = (password === confirmPassword)">
                                <button
                                    class="btn btn-outline-secondary"
                                    type="button"
                                    @click="showConfirmPassword = !showConfirmPassword">
                                    <i :class="showConfirmPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                </button>
                            </div>

                            <!-- Password match validation -->
                            <p x-show="!passwordsMatch" class="text-danger mt-2">Passwords do not match.</p>
                            <div class="d-flex justify-content-evenly align-items-center">
                                <div>
                                    <button type="submit" class="btn btn-primary px-4" :disabled="!passwordsMatch || password === ''">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection