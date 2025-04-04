<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

readonly class HomeController
{
    public function getVersion(): JsonResponse
    {
        $package = \Composer\InstalledVersions::getRootPackage();

        return new JsonResponse([
            'name' => $package['name'],
            'version' => $package['version'],
        ]);
    }
}
