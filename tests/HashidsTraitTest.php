<?php

namespace Litepie\Hashids\Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Litepie\Hashids\Traits\Hashids;

class HashidsTraitTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('test_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    /** @test */
    public function it_can_get_route_key()
    {
        $model = TestModel::create(['name' => 'Test']);
        $routeKey = $model->getRouteKey();

        $this->assertIsString($routeKey);
        $this->assertNotEquals($model->id, $routeKey);
    }

    /** @test */
    public function it_can_get_eid_attribute()
    {
        $model = TestModel::create(['name' => 'Test']);
        $eid = $model->eid;

        $this->assertIsString($eid);
        $this->assertEquals($model->getRouteKey(), $eid);
    }

    /** @test */
    public function it_can_find_by_encoded_id()
    {
        $model = TestModel::create(['name' => 'Test']);
        $encodedId = $model->getRouteKey();

        $found = TestModel::findOrNew($encodedId);
        $this->assertEquals($model->id, $found->id);
        $this->assertEquals($model->name, $found->name);
    }

    /** @test */
    public function it_returns_new_instance_for_invalid_encoded_id()
    {
        $found = TestModel::findOrNew('invalid');
        $this->assertTrue($found->exists === false);
        $this->assertInstanceOf(TestModel::class, $found);
    }

    /** @test */
    public function it_can_generate_signed_id()
    {
        $model = TestModel::create(['name' => 'Test']);
        $signedId = $model->getSignedId();

        $this->assertIsString($signedId);
        $this->assertNotEquals($model->getRouteKey(), $signedId);
    }

    /** @test */
    public function it_can_generate_signed_id_with_expiry()
    {
        $model = TestModel::create(['name' => 'Test']);
        $signedId = $model->getSignedId('+1 hour');

        $this->assertIsString($signedId);
    }

    /** @test */
    public function it_can_resolve_route_binding()
    {
        $model = TestModel::create(['name' => 'Test']);
        $encodedId = $model->getRouteKey();

        $resolved = (new TestModel)->resolveRouteBinding($encodedId);
        $this->assertInstanceOf(TestModel::class, $resolved);
        $this->assertEquals($model->id, $resolved->id);
    }

    /** @test */
    public function it_returns_null_for_invalid_route_binding()
    {
        $resolved = (new TestModel)->resolveRouteBinding('invalid');
        $this->assertNull($resolved);
    }
}

class TestModel extends Model
{
    use Hashids;

    protected $table = 'test_models';

    protected $fillable = ['name'];
}
