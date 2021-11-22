<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\TenancyRequest;
use App\Models\Tenant;

class TenancyController extends AppBaseController
{
    /**
     * @param TenancyRequest $request
     * @return string
     */
    public function store(TenancyRequest $request): string
    {
        $tenant_name = $request->validated()['name'];

        return Tenant::create(['id' => $tenant_name])
            ->domains()->create(['domain' => $tenant_name]);
    }
}
