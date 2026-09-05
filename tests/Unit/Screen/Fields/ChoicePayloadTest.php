<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Illuminate\Support\Facades\DB;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Fields\Support\ChoicePayload;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

/**
 * Class ChoicePayloadTest.
 */
class ChoicePayloadTest extends TestFieldsUnitCase
{
    public function testSelectedOptionsIgnoresBlankValuesWithoutQuerying(): void
    {
        $payload = new ChoicePayload(model: Role::class, name: 'name', key: 'id');

        DB::enableQueryLog();

        $options = $payload->selectedOptions('');

        $this->assertSame([], $options);
        $this->assertEmpty(DB::getQueryLog());

        DB::disableQueryLog();
    }

    public function testSelectedOptionsIgnoresNullAmongSelectedValues(): void
    {
        $role = Role::factory()->create();

        $payload = new ChoicePayload(model: Role::class, name: 'name', key: 'id');

        $options = $payload->selectedOptions([$role->id, null, '']);

        $this->assertCount(1, $options);
        $this->assertSame($role->id, $options[0]['id']);
    }
}
