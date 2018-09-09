<?php
namespace Orchid\Tests\Unit\Press;

use Orchid\Press\Models\Term;
use Orchid\Press\Models\Taxonomy;
use Orchid\Tests\TestUnitCase;

class TermTest extends TestUnitCase
{
    /**
     * @test
     */
    public function its_meta_can_be_queried_by_its_relation()
    {
        $term = $this->createTermWithTaxonomy();
       
        $this->assertInstanceOf(Term::class, $term);
        
        $taxonomy = Taxonomy::where('term_id',$term->id)->first();
        $this->assertInstanceOf(Taxonomy::class, $taxonomy);
        
        $this->assertInstanceOf(Term::class, $taxonomy->term);

    }
    /**
     * @return Term
     */
    private function createTermWithTaxonomy()
    {
        $term = factory(Term::class)->create();
        $term->taxonomy()->save(factory(Taxonomy::class)->make());
        return $term;
    }
}