<?php

namespace MService\License\Actions;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use MService\License\Models\License;
use MService\License\Resources\LicenseResource;

final class GetLicense
{
    use AsAction;

    public function __construct(
        private readonly License $licenseModel,
    ) { }

    public function handler(int $userId): License
    {
        return $this->licenseModel->query()->forUser($userId)->notExpired()->first();
    }

    public function asController(ActionRequest $request): LicenseResource
    {
        return new LicenseResource(
            $this->handler($request->input('user_id'))
        );
    }
}
