<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Facades\Crypt;
use Orchid\Platform\Models\User;
use Orchid\Tests\Exemplar\App\EmptyUserModel;
use Orchid\Tests\TestFeatureCase;

class RelationsTest extends TestFeatureCase
{
    /**
     * @var User
     */
    protected $users;

    protected function setUp(): void
    {
        parent::setUp();
        $this->users = factory(User::class, 10)->create([
            'name' => 'RelationTest',
        ]);
    }

    /**
     * @return array
     */
    public function scopeList() : array
    {
        return [
            ['asBuilder'],
            ['asCollection'],
            ['asArray'],
        ];
    }

    /**
     * @param string $scope
     *
     * @dataProvider scopeList
     *
     * @throws \Throwable
     */
    public function testScopeModel(string $scope)
    {
        $response = $this->getScope($scope);
        $json = $this->users->pluck('email', 'id')->toArray();

        $response->assertJson($json);
    }

    /**
     * @param string $scope
     *
     * @return TestResponse
     */
    private function getScope(string $scope): TestResponse
    {
        return $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.systems.relation'), [
                'model' => Crypt::encryptString(EmptyUserModel::class),
                'name'  => Crypt::encryptString('email'),
                'key'   => Crypt::encryptString('id'),
                'scope' => Crypt::encryptString($scope),
            ]);
    }
}
