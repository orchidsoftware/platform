<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Press;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Orchid\Press\Models\Post;
use Orchid\Press\Models\Tag;
use Orchid\Press\Models\Tagged;
use Orchid\Tests\TestUnitCase;

class TagTest extends TestUnitCase
{
    /** @test */
    public function it_can_delete_a_tag_and_its_tagged_relations()
    {
        $post = factory(Post::class)->create();

        $post->tag('foo, bar');

        $this->assertCount(2, $post->tags);

        $tag = Tag::first();

        $tag->delete();

        $post = $post->fresh();

        $this->assertCount(1, $post->tags);
    }

    /** @test */
    public function it_has_a_taggable_relationship()
    {
        $tag = new Tag;

        $this->assertInstanceOf(MorphTo::class, $tag->taggable());
    }

    /** @test */
    public function it_has_a_tag_relationship()
    {
        $tag = new Tag;

        $this->assertInstanceOf(HasMany::class, $tag->tagged());
    }

    /** @test */
    public function it_has_a_name_scope()
    {
        Tag::create(['name' => 'Foo', 'slug' => 'foo', 'namespace' => 'foo']);

        $this->assertCount(1, Tag::name('Foo')->get());
    }

    /** @test */
    public function it_has_a_slug_scope()
    {
        Tag::create(['name' => 'Foo', 'slug' => 'foo', 'namespace' => 'foo']);

        $this->assertCount(1, Tag::slug('foo')->get());
    }

    /** @test */
    public function it_can_get_and_set_the_tagged_model()
    {
        $tag = new Tag;

        $tag->setTaggedModel(Tagged::class);

        $this->assertEquals(Tagged::class, $tag->getTaggedModel());
    }
}
