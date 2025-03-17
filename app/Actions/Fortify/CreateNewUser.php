<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
 public function create(array $input): User
{
    Validator::make($input, [
        'name' => ['required', 'string', 'max:255'],
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            Rule::unique(User::class),
        ],
        'password' => $this->passwordRules(),
        'phone' => ['nullable', 'string', 'max:15'], // Optional field
        'age' => ['nullable', 'integer', 'min:0'], // Optional field, must be a positive number
        'city' => ['nullable', 'string', 'max:255'], // Optional field
        
    ])->validate();

    return User::create([
        'name' => $input['name'],
        'email' => $input['email'],
        'password' => Hash::make($input['password']),
        'phone' => $input['phone'] ?? null, // Handle nullable field
        'age' => $input['age'] ?? null, // Handle nullable field
        'city' => $input['city'] ?? null, // Handle nullable field
        
    ]);
}
}
