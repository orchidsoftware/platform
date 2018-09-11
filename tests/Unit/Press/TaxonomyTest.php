<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Press;

use Orchid\Press\Models\Post;
use Orchid\Press\Models\Term;
use Orchid\Tests\TestUnitCase;
use Orchid\Press\Models\Taxonomy;

class TaxonomyTest extends TestUnitCase
{
    /**
     * @test
     */
    public function it_belongs_to_a_term()
    {
        $taxonomy = factory(Taxonomy::class)->create([
            'term_id' => 0,
        ]);
        $term = factory(Term::class)->create();
        $taxonomy->term()->associate($term);

        $this->assertInstanceOf(Taxonomy::class, $taxonomy);
        $this->assertInstanceOf(Term::class, $taxonomy->term);
        $this->assertEquals($term->id, $taxonomy->term_id);
    }

    /**
     * @test
     */
    public function it_can_filter_taxonomy_by_term()
    {
        $taxonomy = $this->createTaxonomyWithTerms();
        $term = $taxonomy->term;
        $taxonomies = Taxonomy::slug($term->slug)->get();

        foreach ($taxonomies as $taxonomy) {
            $this->assertEquals('foo', $taxonomy->taxonomy);
            $this->assertNotNull($taxonomy->term_id);
            $this->assertEquals($taxonomy->term_id, $taxonomy->term->id);
        }
    }

    /**
     * @test
     */
    public function it_can_be_queried_by_term_slug()
    {
        $taxonomy = $this->createTaxonomyWithTerms();
        $foo = Taxonomy::get()->first();
        $this->assertEquals('test', $foo->slug);

        $foo = Taxonomy::get();
        $foo->each(function ($foo) {
            $this->assertEquals('test', $foo->slug);
        });
    }

    /**
     * @test
     */
    public function it_can_be_queries_by_term_as_an_aliases_to_slug()
    {
        $this->createTaxonomyWithTerms();
        $foo = Taxonomy::get()->first()->term;

        $this->assertEquals('test', $foo->slug);
    }

    /**
     * @test
     */
    public function it_can_query_taxonomy_posts()
    {
        $taxonomy = $this->createTaxonomyWithTerms();
        $post = factory(Post::class)->create();
        $post->taxonomies()->attach($taxonomy->id);
        $taxonomy_post = Taxonomy::slug('test')->first()->posts->first();

        $this->assertInstanceOf(Post::class, $taxonomy_post);
        $this->assertEquals($taxonomy_post->id, $post->id);
    }

    /**
     * @test
     */
    public function it_can_query_taxonomy_children()
    {
        $this->createTaxonomyWithChildren();
        $taxonomy = Taxonomy::where('parent_id', null)->get()->first();

        $this->assertCount(3, $taxonomy->childrenTerm);
        $this->assertCount(3, $taxonomy->allChildrenTerm);
        $this->assertInstanceOf(Taxonomy::class, $taxonomy->childrenTerm->first());
    }

    /**
     * @test
     */
    public function it_can_query_taxonomy_parent()
    {
        $this->createTaxonomyWithChildren();
        $taxonomy = Taxonomy::where('parent_id', null)->get()->first();
        $taxonomy_children = $taxonomy->childrenTerm->first();

        $this->assertInstanceOf(Taxonomy::class, $taxonomy_children->parentTerm()->first());
        $this->assertEquals($taxonomy->id, $taxonomy_children->parentTerm()->first()->id);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function createTaxonomyWithTerms()
    {
        $taxonomy = factory(Taxonomy::class)->create([
            'taxonomy' => 'foo',
            'term_id' => function () {
                return factory(Term::class)->create([
                    'slug' => 'test',
                ])->id;
            },
        ]);
        /*
        $post = factory(Post::class)->create();
        $post->taxonomies()->attach($taxonomy->id);
        */
        return $taxonomy;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function createTaxonomyWithChildren()
    {
        $taxonomy = factory(Taxonomy::class)->create([
            'taxonomy' => 'foo',
            'term_id' => function () {
                return factory(Term::class)->create()->id;
            },
        ]);

        $taxonomys[] = $taxonomy;

        for ($i = 1; $i <= 3; $i++) {
            $taxonomys[] = factory(Taxonomy::class)->create([
                'taxonomy' => 'foo',
                'parent_id' => $taxonomy->id,
                'term_id' => function () {
                    return factory(Term::class)->create()->id;
                },
            ]);
        }

        return $taxonomys;
    }
}
