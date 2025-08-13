<?php

namespace Modules\Admin\Tests\Feature;

use Faker\Generator;
use Illuminate\Container\Container;
use Mockery;
use Modules\Admin\Classes\Utils\FormToken;
use Modules\Admin\Database\Factories\CrudTestFactory;

class CrudTest extends AbstractAuthTestCase
{
    /**
     * 测试列表
     */
    public function test_index(): void
    {
        $faker = Container::getInstance()->make(Generator::class);
        CrudTestFactory::new()->count(15)->create();

        // 测试第二页
        $response = $this->getJson('/web/admin/CrudTest/index?__page__=2&__per_page__=10');
        $response->assertJsonCount(5, 'data');
        // 测试每页条数
        $response = $this->getJson('/web/admin/CrudTest/index?__page__=1&&__per_page__=12');
        $response->assertJsonCount(12, 'data');
        $response->assertJson([
            'meta' => [
                'current_page' => 1,
            ],
            'links' => [],
        ]);
        $response->assertJsonMissing([
            'test_hidden_field',
        ]);
        $response->assertJsonPath('data.0.status', 'normal');

        // 测试每页条数
        $response = $this->getJson('/web/admin/CrudTest/index?__page__=2&__per_page__=12');
        $response->assertJsonCount(3, 'data');
        // 测试显示有所
        $response = $this->getJson('/web/admin/CrudTest/index?__list_type__=all');
        $response->assertJsonCount(15, 'data');
        $response->assertJsonMissing([
            'test_hidden_field',
        ]);

        CrudTestFactory::new()->count(20)->create(['name' => $faker->name() . 'asdf' . $faker->name()]);
        // 测试搜索范围
        $response = $this->getJson('/web/admin/CrudTest/index?__list_type__=all&fast_search=asdf');
        $response->assertJsonCount(20, 'data');
        // 测试不存在的字段搜索
        $response = $this->getJson('/web/admin/CrudTest/index?__page__=1&__per_page__=10&aaaaaa=asdf');
        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data');

        CrudTestFactory::new()->count(3)->create(['name' => 'asdf']);
        CrudTestFactory::new()->count(3)->create(['name' => 'asdf1']);
        // 测试存在字段但不存在搜索范围的搜索
        $response = $this->getJson('/web/admin/CrudTest/index?__list_type__=all&name=asdf');
        $response->assertJsonCount(3, 'data');
    }

    public function test_tree()
    {
        $faker = Container::getInstance()->make(Generator::class);
        $model = CrudTestFactory::new()->create();
        CrudTestFactory::new()->count(2)->create(['name' => 'children ' . $faker->name(), 'parent_id' => $model->id]);
        // 测试树状结构
        $response = $this->getJson('/web/admin/CrudTest/index?__list_type__=tree&__order_by__[id]=asc');
        $response->assertJsonCount(2, 'data.0.children');
    }

    /**
     * 测试详情
     */
    public function test_read()
    {
        $response = $this->getJson('/web/admin/CrudTest/read?id=1');
        $response->assertJson([
            'code' => 404,
        ]);
        $model    = CrudTestFactory::new()->create();
        $response = $this->getJson('/web/admin/CrudTest/read?id=' . $model->id);
        $response->assertJson([
            'code' => 0,
        ]);
        $response->assertJsonPath('data.id', $model->id);
        $response->assertJsonMissing(['test_hidden_field']);
        $response->assertJsonPath('data.status', 'normal');
    }

    /**
     * 测试新增
     */
    public function test_create(): void
    {
        $this->app->instance(FormToken::class, new FormToken());
        $response = $this->postJson('/web/admin/CrudTest/create', [
            'name' => 'asdf',
        ]);
        $response->assertJson(['code' => 500]);
        $formToken = $this->app[FormToken::class];
        $token = $formToken->getToken();
        $response = $this->postJson('/web/admin/CrudTest/create', [
            'name' => 'asdf',
            '__form_token__' => $token,
        ]);
        $response->assertJson(['code' => 0]);

        $token = $formToken->getToken();
        // 测试重复名称
        $response = $this->postJson('/web/admin/CrudTest/create', [
            'name' => 'asdf',
            '__form_token__' => $token,
        ]);
        $response->assertJson(['code' => 422]);
    }

    /**
     * 测试修改
     */
    public function test_update(): void
    {

        $model    = CrudTestFactory::new()->create();
        $response = $this->postJson('/web/admin/CrudTest/update', [
            'id'   => $model->id,
            'name' => 'asdf',
        ]);
        $response->assertStatus(200);
        $response->assertJsonPath('data.name', 'asdf');
        // 测试修改自身但是名称重复
        $response = $this->postJson('/web/admin/CrudTest/update', [
            'id'   => 1,
            'name' => 'asdf',
        ]);
        $response->assertStatus(200);

        // 测试修改不存在的
        $response = $this->postJson('/web/admin/CrudTest/update', [
            'id'   => 2,
            'name' => 'asdf1',
        ]);
        $response->assertJson(['code' => 404]);

        // 测试修改为重复名称
        CrudTestFactory::new()->create();
        $response = $this->postJson('/web/admin/CrudTest/update', [
            'id'   => 2,
            'name' => 'asdf',
        ]);
        $response->assertJson(['code' => 422]);
    }

    /**
     * 测试删除
     */
    public function test_destroy(): void
    {
        // 测试删除不存在的

        $response = $this->deleteJson('/web/admin/CrudTest/destroy', [
            'ids' => [2],
        ]);
        $response->assertJson(['code' => 404]);

        $model    = CrudTestFactory::new()->create();
        $response = $this->deleteJson('/web/admin/CrudTest/destroy', [
            'ids' => [$model->id],
        ]);
        $response->assertJson(['code' => 0]);

        $response = $this->getJson('/web/admin/CrudTest/read?id=' . $model->id);
        $response->assertJson(['code' => 0]);
        $response->assertJsonMissing([
            'deleted_at' => null,
        ]);
    }

    /**
     * 测试状态变更
     */
    public function test_change_status(): void
    {
        $model    = CrudTestFactory::new()->create();
        $response = $this->postJson('/web/admin/CrudTest/change-status', [
            'id'     => $model->id,
            'status' => 'disabled',
        ]);
        $response->assertJson(['code' => 0]);
        $model->refresh();
        $this->assertEquals('disabled', $model->status);

        $response = $this->postJson('/web/admin/CrudTest/change-status', [
            'id'     => $model->id,
            'status' => 'normal',
        ]);
        $response->assertJson(['code' => 0]);
        $model->refresh();
        $this->assertEquals('normal', $model->status);

        // 测试不存在的
        $response = $this->postJson('/web/admin/CrudTest/change-status', [
            'id'     => 2,
            'status' => 'disabled',
        ]);
        $response->assertJson(['code' => 404]);

        // 测试错误的状态
        $response = $this->postJson('/web/admin/CrudTest/change-status', [
            'id'     => 1,
            'status' => 'aaaaaaaaaaa',
        ]);
        $response->assertJson(['code' => 422]);
    }

    /**
     * 测试回收站
     */
    public function test_recycle()
    {
        $model    = CrudTestFactory::new()->create();
        $response = $this->postJson('/web/admin/CrudTest/recycle');
        $response->assertJson(['code' => 0]);
        $response->assertJsonCount(0, 'data');
        $model->delete();

        CrudTestFactory::new()->count(12)->create();
        $response = $this->getJson('/web/admin/CrudTest/recycle');
        $response->assertJsonCount(1, 'data');
        $response->assertJsonMissing(['deleted_at' => null]);
        $response->assertJsonMissing([
            'test_hidden_field',
        ]);
        $response->assertJsonPath('data.0.status', 'normal');
    }

    /**
     * 测试恢复
     */
    public function test_recovery()
    {
        $model = CrudTestFactory::new()->create();
        $model->delete();
        $response = $this->postJson('/web/admin/CrudTest/recovery', [
            'ids' => $model->id,
        ]);
        $response->assertJson(['code' => 0]);
        $response = $this->postJson('/web/admin/CrudTest/recovery', [
            'ids' => $model->id,
        ]);
        $response->assertJson(['code' => 404]);
    }

    /**
     * 测试真实删除
     */
    public function test_real_destroy()
    {
        $model    = CrudTestFactory::new()->create();
        $response = $this->deleteJson('/web/admin/CrudTest/real-destroy', [
            'ids' => $model->id,
        ]);
        $response->assertJson(['code' => 0]);
        $response = $this->getJson('/web/admin/CrudTest/read?id=' . $model->id);
        $response->assertJson(['code' => 404]);
    }
}
