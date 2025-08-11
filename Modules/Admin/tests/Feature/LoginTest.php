<?php

namespace Modules\Admin\Tests\Feature;

use Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Exceptions\InvalidArgumentException;
use InvalidArgumentException as GlobalInvalidArgumentException;
use Modules\Admin\Database\Factories\SystemAdminFactory;
use PHPUnit\Framework\ExpectationFailedException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Tests\TestCase;
use Throwable;

class LoginTest extends AbstractAuthTestCase
{
    /**
     * 测试空管理员名
     *
     * @return void
     *
     * @throws BadRequestException
     * @throws ExpectationFailedException
     */
    public function test_empty_admin_name()
    {
        $response = $this->postJson('/web/admin/login', [
            'admin_name' => '       ',
            'password'   => '123456',
        ]);
        $response->assertJsonMissing([
            'code' => 0,
        ]);
    }

    /**
     * 测试空密码
     *
     * @return void
     *
     * @throws BadRequestException
     * @throws ExpectationFailedException
     */
    public function test_empty_password()
    {
        $response = $this->postJson('/web/admin/login', [
            'admin_name' => 'admin',
            'password'   => '      ',
        ]);
        $response->assertJsonMissing([
            'code' => 0,
        ]);
    }

    /**
     * 测试密码错误
     *
     * @return void
     *
     * @throws BadRequestException
     * @throws Throwable
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws GlobalInvalidArgumentException
     */
    public function test_password_err()
    {
        SystemAdminFactory::new()->create(['admin_name' => 'super admin2']);
        $response = $this->postJson('/web/admin/login', [
            'admin_name' => 'super admin2',
            'password'   => '1234567',
            'remember'   => false,
        ]);
        $response->assertJsonMissing([
            'code' => 0,
        ]);
    }

    /**
     * 测试未找到管理员
     *
     * @return void
     *
     * @throws BadRequestException
     * @throws Throwable
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws GlobalInvalidArgumentException
     */
    public function test_not_found_admin()
    {
        SystemAdminFactory::new()->count(3)->create();
        $response = $this->postJson('/web/admin/login', [
            'admin_name' => "' OR '1'='1",
            'password'   => '123456',
            'remember'   => false,
        ]);
        $response->assertJsonMissing([
            'code' => 0,
        ]);
    }

    /**
     * 测试登录成功
     *
     * @return void
     *
     * @throws BadRequestException
     * @throws Throwable
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws GlobalInvalidArgumentException
     */
    public function test_login_success()
    {
        SystemAdminFactory::new()->create(['admin_name' => 'super admin2']);
        $response = $this->postJson('/web/admin/login', [
            'admin_name' => 'super admin2',
            'password'   => '123456',
            'remember'   => false,
        ]);
        $response->assertJson([
            'code' => 0,
        ]);
        $this->assertAuthenticated();
        $this->assertNotEmpty(Auth::user()->login_ip);
        $this->assertNotEmpty(Auth::user()->logged_at);
    }

    /**
     * 测试管理员状态错误
     *
     * @return void
     *
     * @throws BadRequestException
     * @throws Throwable
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws GlobalInvalidArgumentException
     */
    public function test_admin_status_err()
    {
        SystemAdminFactory::new()->create(['admin_name' => 'super admin2', 'status' => 'disabled']);
        $response = $this->postJson('/web/admin/login', [
            'admin_name' => 'super admin2',
            'password'   => '123456',
            'remember'   => false,
        ]);
        $response->assertJsonMissing([
            'code' => 0,
        ]);
    }

    /**
     * 测试管理员已删除
     */
    public function test_admin_is_delete()
    {
        SystemAdminFactory::new()->trashed()->create(['admin_name' => 'super admin2']);
        $response = $this->postJson('/web/admin/login', [
            'admin_name' => 'super admin2',
            'password'   => '123456',
            'remember'   => false,
        ]);
        $response->assertJsonMissing([
            'code' => 0,
        ]);
    }
}
