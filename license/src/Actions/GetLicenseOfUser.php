<?php

namespace MService\License\Actions;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use MService\License\Models\License;
use MService\License\Resources\LicenseResource;

class GetLicenseOfUser
{
    use AsAction;

    public function __construct(
        private readonly License $licenseModel,
    ) { }

    public function handler(int $userId): License
    {
        return $this->licenseModel->query()->forUser($userId)->notExpired()->first();
    }

    public function asController(ActionRequest $request, int $userId): LicenseResource
    {
        // TODO: check `admin.license` scope to internal RestAPI
        return new LicenseResource(
            $this->handler($userId)
        );
    }
}
