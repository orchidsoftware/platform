<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Testing\TestResponse;
use Orchid\Platform\Models\User;
use Orchid\Tests\App\EmptyUserModel;
use Orchid\Tests\TestFeatureCase;

class RelationsTest extends TestFeatureCase
{
    /**
     * @var User[]
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
    public function scopeList(): array
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
     * @dataProvider scopeList
     *
     * @throws \Throwable
     */
    public function testAppendModel(string $scope)
    {
        $response = $this->getScope($scope, 'full');

        $users = collect();

        $this->users->each(function (User $user) use ($users) {
            $users->put($user->id, $user->name.' ('.$user->email.')');
        });

        $json = $users->toArray();

        $response->assertJson($json);
    }

    /**
     * @param string      $scope
     * @param string|null $append
     *
     * @return TestResponse
     */
    private function getScope(string $scope, string $append = null): TestResponse
    {
        $params = [
            'model' => Crypt::encryptString(EmptyUserModel::class),
            'name'  => Crypt::encryptString('email'),
            'key'   => Crypt::encryptString('id'),
            'scope' => Crypt::encryptString($scope),
        ];

        if ($append !== null) {
            $params['append'] = Crypt::encryptString($append);
        }

        return $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.systems.relation'), $params);
    }
}
