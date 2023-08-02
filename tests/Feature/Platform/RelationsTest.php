<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
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
        $this->users = User::factory()->count(10)->create([
            'name' => 'RelationTest',
        ]);
    }

    public static function scopeList(): array
    {
        return [
            [['name' => 'asBuilder', 'parameters' => []]],
            [['name' => 'asCollection', 'parameters' => []]],
            [['name' => 'asArray', 'parameters' => []]],
        ];
    }

    /**
     * @dataProvider scopeList
     *
     * @throws \Throwable
     */
    public function testScopeModel(array $scope): void
    {
        $response = $this->getScope($scope);
        $json = $this->users->pluck('email', 'id')->toArray();

        $response->assertJson($json);
    }

    /**
     * @dataProvider scopeList
     *
     * @throws \Throwable
     */
    public function testAppendModel(array $scope): void
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
     * @throws \Throwable
     */
    public function testParamsForScopeModel(): void
    {
        $user = $this->users->first();

        $response = $this->getScope([
            'name'       => 'asFilerId',
            'parameters' => [$user->id],
        ]);

        $response->assertJson([
            $user->id => $user->email,
        ]);
    }

    private function getScope(array $scope = null, string $append = null): TestResponse
    {
        $params = [
            'model' => Crypt::encryptString(EmptyUserModel::class),
            'name'  => Crypt::encryptString('email'),
            'key'   => Crypt::encryptString('id'),
        ];

        if ($scope !== null) {
            $params['scopes'] = [Crypt::encrypt($scope)];
        }

        if ($append !== null) {
            $params['append'] = Crypt::encryptString($append);
        }

        return $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.systems.relation'), $params);
    }

    public function testSearchColumns()
    {
        $user = $this->users->random();
        $params = [
            'search'        => $user->email,
            'model'         => Crypt::encryptString(EmptyUserModel::class),
            'name'          => Crypt::encryptString('name'),
            'key'           => Crypt::encryptString('id'),
            'searchColumns' => Crypt::encrypt(['email']),
            'scopes'         => null,
            'append'        => Crypt::encryptString('full'),
        ];

        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.systems.relation'), $params);

        $response->assertJson([
            $user->id => $user->name.' ('.$user->email.')',
        ]);
    }

    public function testSearchColumnsWithScopes()
    {
        $user = $this->users->random();
        $params = [
            'search'        => $user->email,
            'model'         => Crypt::encryptString(EmptyUserModel::class),
            'name'          => Crypt::encryptString('email'),
            'key'           => Crypt::encryptString('id'),
            'searchColumns' => Crypt::encrypt(['id']),
            'scopes'         => [
                Crypt::encrypt([
                'name'       => 'asBuilder',
                'parameters' => [],
                ])
            ],
            'append'        => Crypt::encryptString('full'),
        ];

        DB::enableQueryLog();

        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.systems.relation'), $params);

        $queryLog = DB::getQueryLog();
        $latest_query = array_pop($queryLog);

        $response->assertJson([
            $user->id => $user->name.' ('.$user->email.')',
        ]);

        $this->assertContains('select * from "users" where "name" = ? and ("email" like ? or "id" like ?) limit 10', $latest_query);
    }
}
