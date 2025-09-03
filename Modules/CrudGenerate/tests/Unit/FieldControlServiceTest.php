<?php

namespace Modules\CrudGenerate\Tests\Unit;

use Modules\Admin\Tests\AbstractAuthTestCase;
use Modules\CrudGenerate\Services\FieldControlService;

class FieldControlServiceTest extends AbstractAuthTestCase
{
    public function test_field_control_service(): void
    {
        $fieldControlService = $this->app->make(FieldControlService::class);
        $a                   = $fieldControlService->jsonSerialize();
        foreach ($a as $item) {
            $this->assertArrayHasKey('label', $item);
            $this->assertArrayHasKey('name', $item);
            $this->assertArrayHasKey('specialParams', $item);
        }
    }
}
