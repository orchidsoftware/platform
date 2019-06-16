<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Fields;

use Orchid\Platform\Models\Role;
use Orchid\Screen\Fields\Relation;
use Orchid\Tests\Exemplar\App\AjaxRecord;
use Illuminate\Database\Eloquent\Collection;

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

    /**
     * @test
     */
    public function testInstanse()
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

    /**
     * @test
     */
    public function testInstanseArray()
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

    /**
     * @test
     */
    public function testMultipleInstanse()
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

    /**
     * @test
     */
    public function testMultipleInstanseArray()
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

    /**
     * @test
     */
    public function testAJAXClass()
    {
        $select = Relation::make('role.')
            ->fromClass(AjaxRecord::class, 'text')
            ->value(1);

        $view = self::renderField($select);

        $this->assertStringContainsString('Record 1', $view);
    }
}
