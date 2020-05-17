<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Illuminate\Database\Eloquent\Collection;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Fields\Relation;
use Orchid\Tests\App\AjaxRecord;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

/**
 * Class RelationTest.
 */
class RelationTest extends TestFieldsUnitCase
{
    /**
     * @var Collection
     */
    protected $roles;

    public function setUp(): void
    {
        parent::setUp();

        $this->roles = factory(Role::class)->times(10)->create();
    }

    public function testInstance()
    {
        /** @var Role $current */
        $current = $this->roles->random();

        $select = Relation::make('role')
            ->title('Select role')
            ->fromModel(Role::class, 'name')
            ->value($current);

        $view = self::renderField($select);

        $this->assertStringContainsString($current->name, $view);
        $this->assertStringContainsString('Select role', $view);
    }

    public function testInstanceArray()
    {
        /** @var Role $current */
        $current = $this->roles->random();

        $select = Relation::make('role')
            ->title('Select roles')
            ->fromModel(Role::class, 'name')
            ->value($current->id);

        $view = self::renderField($select);

        $this->assertStringContainsString($current->name, $view);
        $this->assertStringContainsString('Select roles', $view);
    }

    public function testInstanceArrayWithStringPrimary()
    {
        $StringPrimaryClass = new class extends Role {
            protected $keyType = 'string';
        };

        $select = Relation::make('role')
            ->title('Select role')
            ->fromModel(get_class(new $StringPrimaryClass), 'name')
            ->value('a string key');

        $view = self::renderField($select);

        $this->assertStringContainsString('Select role', $view);
    }

    public function testMultipleInstance()
    {
        /** @var Role $current */
        $current = $this->roles->random(2);

        $select = Relation::make('role.')
            ->fromModel(Role::class, 'name')
            ->value($current);

        $view = self::renderField($select);

        $this->assertStringContainsString($current[0]->name, $view);
        $this->assertStringContainsString($current[1]->name, $view);
    }

    public function testMultipleInstanceArray()
    {
        /** @var Role $current */
        $current = $this->roles->random(2);

        $select = Relation::make('role.')
            ->fromModel(Role::class, 'name')
            ->value([
                $current[0]->id,
                $current[1]->id,
            ]);

        $view = self::renderField($select);

        $this->assertStringContainsString($current[0]->name, $view);
        $this->assertStringContainsString($current[1]->name, $view);
    }

    public function testAJAXClass()
    {
        $select = Relation::make('role.')
            ->fromClass(AjaxRecord::class, 'text')
            ->value(1);

        $view = self::renderField($select);

        $this->assertStringContainsString('Record 1', $view);
    }
}
