<?php

namespace App\DTOs\Student;

class UpdateProfileData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
         public readonly ?string $password ,
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            name: $request->name,
            email: $request->email,
            password: $request->password,
        );
    }
    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if (!empty($this->password)) {
            $data['password'] = bcrypt($this->password);
        }

        return $data;
    }
}