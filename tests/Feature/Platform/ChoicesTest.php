<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Support\Facades\DB;
use Illuminate\Testing\TestResponse;
use Orchid\Platform\Models\User;
use Orchid\Screen\Fields\Support\ChoicePayload;
use Orchid\Tests\App\EmptyUserModel;
use Orchid\Tests\TestFeatureCase;
use PHPUnit\Framework\Attributes\DataProvider;

class ChoicesTest extends TestFeatureCase
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
    #[DataProvider('scopeList')]
    public function testScopeModel(array $scope): void
    {
        $response = $this->postChoices(new ChoicePayload(
            model: EmptyUserModel::class,
            name: 'email',
            key: 'id',
            scope: $scope,
        ));

        $json = $this->users->map(fn ($user) => [
            'value' => $user->id,
            'label' => $user->email,
        ])->toArray();

        $response->assertJson($json);
    }

    /**
     * @dataProvider scopeList
     *
     * @throws \Throwable
     */
    #[DataProvider('scopeList')]
    public function testAppendModel(array $scope): void
    {
        $response = $this->postChoices(new ChoicePayload(
            model: EmptyUserModel::class,
            name: 'email',
            key: 'id',
            scope: $scope,
            append: 'full',
        ));

        $json = $this->users->map(fn ($user) => [
            'value' => $user->id,
            'label' => $user->name.' ('.$user->email.')',
        ])->toArray();

        $response->assertJson($json);
    }

    /**
     * @throws \Throwable
     */
    public function testParamsForScopeModel(): void
    {
        $user = $this->users->first();

        $response = $this->postChoices(new ChoicePayload(
            model: EmptyUserModel::class,
            name: 'email',
            key: 'id',
            scope: [
                'name'       => 'asFilerId',
                'parameters' => [$user->id],
            ],
        ));

        $response->assertJson([
            ['value' => $user->id, 'label' => $user->email],
        ]);
    }

    public function testSearchColumns()
    {
        $user = $this->users->random();
        $response = $this->postChoices(new ChoicePayload(
            model: EmptyUserModel::class,
            name: 'name',
            key: 'id',
            append: 'full',
            searchColumns: ['email'],
        ), [
            'search' => $user->email,
        ]);

        $response->assertJson([
            ['value' => $user->id, 'label' => $user->name.' ('.$user->email.')'],
        ]);
    }

    public function testEncryptedChoicePayload()
    {
        $user = $this->users->random();
        $payload = new ChoicePayload(
            model: EmptyUserModel::class,
            name: 'name',
            key: 'id',
            scope: ['name' => 'asBuilder', 'parameters' => []],
            append: 'full',
            searchColumns: ['email'],
        );

        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('orchid.choices'), [
                'search'  => $user->email,
                'choices' => (string) $payload,
            ]);

        $response->assertJson([
            ['value' => $user->id, 'label' => $user->name.' ('.$user->email.')'],
        ]);
    }

    public function testChoicePayloadSearchesAndLimitsResultsByChunk(): void
    {
        $users = User::factory()->count(3)->sequence(
            ['name' => 'Payload Chunk', 'email' => 'payload-chunk-1@example.com'],
            ['name' => 'Payload Chunk', 'email' => 'payload-chunk-2@example.com'],
            ['name' => 'Payload Chunk', 'email' => 'payload-chunk-3@example.com'],
        )->create();

        $response = $this->postChoices(new ChoicePayload(
            model: EmptyUserModel::class,
            name: 'name',
            key: 'id',
            searchColumns: ['email'],
        ), [
            'search' => 'payload-chunk-',
            'chunk'  => 2,
        ]);

        $response->assertExactJson($users->take(2)->map(fn (User $user) => [
            'value' => $user->id,
            'label' => $user->name,
        ])->values()->all());
    }

    public function testChoicePayloadSearchesPrimaryColumn(): void
    {
        $user = User::factory()->create([
            'name'  => 'Payload Primary Search',
            'email' => 'payload-primary@example.com',
        ]);

        $response = $this->postChoices(new ChoicePayload(
            model: EmptyUserModel::class,
            name: 'name',
            key: 'id',
        ), [
            'search' => 'Payload Primary',
        ]);

        $response->assertExactJson([
            ['value' => $user->id, 'label' => $user->name],
        ]);
    }

    public function testChoicePayloadSearchesAdditionalColumnsAndUsesAppendLabel(): void
    {
        $user = User::factory()->create([
            'name'  => 'Payload Append',
            'email' => 'payload-append@example.com',
        ]);

        $response = $this->postChoices(new ChoicePayload(
            model: EmptyUserModel::class,
            name: 'name',
            key: 'id',
            append: 'full',
            searchColumns: ['email'],
        ), [
            'search' => 'payload-append@example.com',
        ]);

        $response->assertExactJson([
            ['value' => $user->id, 'label' => 'Payload Append (payload-append@example.com)'],
        ]);
    }

    /**
     * @dataProvider scopeList
     */
    #[DataProvider('scopeList')]
    public function testChoicePayloadAppliesScopes(array $scope): void
    {
        $response = $this->postChoices(new ChoicePayload(
            model: EmptyUserModel::class,
            name: 'email',
            key: 'id',
            scope: $scope,
        ), [
            'chunk' => 3,
        ]);

        $response->assertExactJson($this->users->take(3)->map(fn (User $user) => [
            'value' => $user->id,
            'label' => $user->email,
        ])->values()->all());
    }

    public function testSearchColumnsWithScopes()
    {
        $user = $this->users->random();
        $payload = new ChoicePayload(
            model: EmptyUserModel::class,
            name: 'email',
            key: 'id',
            scope: [
                'name'       => 'asBuilder',
                'parameters' => [],
            ],
            append: 'full',
            searchColumns: ['id'],
        );

        DB::enableQueryLog();

        $response = $this->postChoices($payload, [
            'search' => $user->email,
        ]);

        $queryLog = DB::getQueryLog();
        $latest_query = array_pop($queryLog);

        $response->assertJson([
            ['value' => $user->id, 'label' => $user->name.' ('.$user->email.')'],
        ]);

        $this->assertContains('select * from "users" where "name" = ? and ("email" like ? or "id" like ?) limit 10', $latest_query);
    }

    /**
     * @param array<string, mixed> $parameters
     */
    private function postChoices(ChoicePayload $payload, array $parameters = []): TestResponse
    {
        return $this
            ->actingAs($this->createAdminUser())
            ->post(route('orchid.choices'), [
                'choices' => (string) $payload,
                ...$parameters,
            ]);
    }
}
