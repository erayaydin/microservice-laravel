<?php

namespace MService\License\Models;

enum LicenseType: string
{
    case DEMO = 'DEMO';
    case STARTER = 'STARTER';
    case ULTIMATE = 'ULTIMATE';

    public function getMaxFileSize(): int
    {
        return match($this) {
            LicenseType::DEMO => 100 * 1024 * 1024,
            LicenseType::STARTER => 1024 * 1024 * 1024,
            LicenseType::ULTIMATE => 64 * 1024 * 1024 * 1024,
        };
    }

    public function getDailyObjectLimit(): int
    {
        return match($this) {
            LicenseType::DEMO => 5,
            LicenseType::STARTER => 50,
            LicenseType::ULTIMATE => 300,
        };
    }

    public function getQuota(): int
    {
        return match($this) {
            LicenseType::DEMO => 1024 * 1024 * 1024,
            LicenseType::STARTER => 30 * 1024 * 1024 * 1024,
            LicenseType::ULTIMATE => 1024 * 1024 * 1024 * 1024,
        };
    }
}
