<?php

namespace MService\License\Actions;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use MService\License\Models\License;
use MService\License\Resources\LicenseResource;

final class MeLicense
{
    use AsAction;

    public function handler(int $userId): License
    {
        return GetLicenseOfUser::run($userId);
    }

    public function asController(ActionRequest $request): LicenseResource
    {
        return new LicenseResource(
            $this->handler($request->input('user_id'))
        );
    }
}
