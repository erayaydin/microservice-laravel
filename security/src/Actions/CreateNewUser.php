<?php

namespace MService\Security\Actions;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\Password;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use MService\Security\Models\User;

final class CreateNewUser
{
    use AsAction;

    public function __construct (
        private readonly Hasher $hasher,
        private readonly User $userModel,
    ) { }

    public function handle(string $name, string $email, string $password): void
    {
        /** @var User $user */
        $user = $this->userModel->query()->create([
            'name' => $name,
            'email' => $email,
            'password' => $this->hasher->make($password),
        ]);

        PublishUserCreatedMessage::dispatch($user);
    }

    public function asController(ActionRequest $request): Response
    {
        $this->handle(
            $request->validated('name'),
            $request->validated('email'),
            $request->validated('password'),
        );

        return response(status: 201);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', Password::default()->symbols()->numbers()->letters()->uncompromised()],
        ];
    }
}
