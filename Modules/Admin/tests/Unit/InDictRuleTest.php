<?php

namespace Modules\Admin\Tests\Unit;

use Illuminate\Support\Facades\Validator;
use Modules\Admin\Rules\InDict;
use Modules\Admin\Tests\AbstractAuthTestCase;
use Tests\TestCase;

class InDictRuleTest extends AbstractAuthTestCase
{
    /**
     * A basic test example.
     */
    public function test_not_in_dict_rule(): void
    {
        $validator = Validator::make([
            'a' => 1
        ], [
            'a' => [new InDict('data_status')]
        ]);

        $this->assertTrue($validator->fails());
    }

    /**
     * A basic test example.
     */
    public function test_in_dict_rule(): void
    {
        $validator = Validator::make([
            'a' => 'normal'
        ], [
            'a' => [new InDict('data_status')]
        ]);

        $this->assertFalse($validator->fails());
    }

    public function test_nullable(): void
    {
        $validator = Validator::make([
            'a' => null,
            'b' => 'normal'
        ], [
            'a' => ['nullable', new InDict('data_status')],
            'b' => ['nullable', new InDict('data_status')],
        ]);

        $this->assertFalse($validator->fails());
    }
}
