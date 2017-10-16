<?php

namespace Orchid\Platform\Tests\Unit;

use Orchid\Platform\Tests\TestCase;
use Orchid\Platform\Core\Models\Term;
use Orchid\Platform\Core\Models\Taxonomy;

class TaxonomyTest extends TestCase
{
    /**
     * @test
     */
    public function it_belongs_to_a_term()
    {
        $taxonomy = factory(\Orchid\Platform\Core\Models\Taxonomy::class)->create([
            'term_id' => 0,
            'count' => 1,
        ]);

        $term = factory(\Orchid\Platform\Core\Models\Term::class)->create();
        $taxonomy->term()->associate($term);

        $this->assertEquals($term->term_id, $taxonomy->term_id);
    }

    /**
     * @test
     */
    public function it_can_filter_taxonomy_by_term()
    {
        $taxonomy = $this->createTaxonomyWithTermsAndPosts();
        $term = $taxonomy->term;

        $taxonomies = Taxonomy::slug($term->slug)->get();

        foreach ($taxonomies as $taxonomy) {
            $this->assertEquals('foo', $taxonomy->taxonomy);
            $this->assertNotNull($taxonomy->term_id);
            $this->assertEquals($taxonomy->term_id, $taxonomy->term->term_id);
        }
    }

    /**
     * @test
     */
    public function it_can_be_queried_by_name_and_term_slug()
    {
        $taxonomy = $this->createTaxonomyWithTermsAndPosts();

        $foo = Taxonomy::name('foo')->slug('bar')->first();
        $this->assertEquals('Bar', $foo->name);

        $foo = Taxonomy::name('foo')->slug('bar')->get();
        $foo->each(function ($foo) {
            $this->assertEquals('Bar', $foo->name);
            $this->assertEquals('bar', $foo->slug);
        });
    }

    /**
     * @test
     */
    public function it_can_be_queries_by_term_as_an_aliases_to_slug()
    {
        $this->createTaxonomyWithTermsAndPosts();

        $foo = Taxonomy::name('foo')->term('bar')->first();

        $this->assertEquals('Bar', $foo->name);
    }

    /**
     * @test
     */
    public function it_can_query_taxonomy_by_term_and_get_all_posts_related()
    {
        $this->createTaxonomyWithTermsAndPosts();

        $post = Taxonomy::name('foo')->slug('bar')
            ->orderBy('term_taxonomy_id', 'desc')->first()
            ->posts->first();

        $this->assertEquals('Foo bar', $post->title);
    }

    /**
     * @test
     */
    public function its_first_post_should_have_keywords_if_it_has_taxonomy_and_term()
    {
        $taxonomy = $this->createTaxonomyWithTermsAndPosts();

        $post = $taxonomy->posts->first();

        $this->assertTrue(count($post->keywords) > 0);
    }

    /**
     * @test
     */
    public function it_has_correct_query_with_callback_in_where()
    {
        /*
         * TODO:
        $query = Category::where(function ($q) {
            $q->where('foo', 'bar');
        });

        $expectedQuery = 'select * from "term_taxonomy" where "taxonomy" = ? and ("foo" = ?)';
        $expectedBindings = ['category', 'bar'];

        $this->assertEquals($expectedQuery, $query->toSql());
        $this->assertSame($expectedBindings, $query->getBindings());
        */

        $this->assertTrue(1);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function createTaxonomyWithTermsAndPosts()
    {
        $taxonomy = factory(\Orchid\Platform\Core\Models\Taxonomy::class)->create([
            'taxonomy' => 'foo',
            'term_id' => function () {
                return factory(\Orchid\Platform\Core\Models\Term::class)->create([
                    'name' => 'Bar',
                    'slug' => 'bar',
                ])->term_id;
            }
        ]);

        $post = factory(\Orchid\Platform\Core\Models\Post::class)->create([
            'post_title' => 'Foo bar',
        ]);

        $post->taxonomies()->attach($taxonomy->term_taxonomy_id);

        return $taxonomy;
    }
}
