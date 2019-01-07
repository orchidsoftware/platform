<?php

declare(strict_types=1);

namespace Tests\Feature\Example;

use Orchid\Press\Models\Term;
use Orchid\Platform\Models\User;
use Orchid\Press\Models\Taxonomy;
use Orchid\Tests\TestFeatureCase;

class CategoryTest extends TestFeatureCase
{
    /**
     * debug: php vendor/bin/phpunit  --filter= CategoryTest tests\\Feature\\Example\\CategoryTest --debug.
     * @var
     */
    private $user;

    public function setUp()
    {
        parent::setUp();
        //$this->withoutMiddleware();
        if ($this->user) {
            return $this->user;
        }
        $this->user = factory(User::class)->create();
    }

    /**
     * @return array
     */
    private function createTaxonomyWithChildren()
    {
        $taxonomy = factory(Taxonomy::class)->create([
            'taxonomy' => 'category',
            'term_id'  => function () {
                return factory(Term::class)->create()->id;
            },
        ]);

        $taxonomys[] = $taxonomy;

        for ($i = 1; $i <= 3; $i++) {
            $taxonomys[] = factory(Taxonomy::class)->create([
                'taxonomy'  => 'category',
                'parent_id' => $taxonomy->id,
                'term_id'   => function () {
                    return factory(Term::class)->create()->id;
                },
            ]);
        }

        return $taxonomys;
    }

    public function test_route_SystemsCategory()
    {
        $this->createTaxonomyWithChildren();
        $response = $this->actingAs($this->user)
            ->get(route('platform.systems.category'));
        $taxonomy = Taxonomy::where('parent_id', null)->get()->first();

        $response
            ->assertOk()
            ->assertSee($taxonomy->term->getContent('name'));
    }

    public function test_route_SystemsCategoryEdit()
    {
        $post = $this->createTaxonomyWithChildren();
        $taxonomy = Taxonomy::where('parent_id', null)->get()->first();

        $response = $this->actingAs($this->user)
            ->get(route('platform.systems.category.edit', $taxonomy->id));

        $response
            ->assertOk()
            ->assertSee($taxonomy->term->getContent('name'));
    }
}
