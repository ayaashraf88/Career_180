<?php

namespace App\DTOs\Auth;

class RegiserData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly bool $remember = false
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            name: $request->name,
            email: $request->email,
            password: $request->password,
            remember: $request->boolean('remember')
        );
    }
}