<?php

namespace App\DTOs\Auth;

class LoginData
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly bool $remember = false
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            email: $request->email,
            password: $request->password,
            remember: $request->boolean('remember')
        );
    }
}