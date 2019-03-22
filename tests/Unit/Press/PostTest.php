<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Press;

use Illuminate\Support\Arr;
use Orchid\Press\Models\Post;
use Orchid\Press\Models\Term;
use Orchid\Tests\TestUnitCase;
use Orchid\Platform\Models\User;
use Orchid\Press\Models\Taxonomy;

class PostTest extends TestUnitCase
{
    /**
     * @test
     */
    public function testHasCorrectCreatePost()
    {
        $post = factory(Post::class)->create();
        $this->assertInstanceOf(Post::class, $post);
        $this->assertIsInt($post->id);
        $this->assertGreaterThan(0, $post->id);
    }

    /**
     * @test
     */
    public function testHasStatusScope()
    {
        factory(Post::class)->create(['status' => 'foo']);
        $posts = Post::status('foo')->get();
        $this->assertNotNull($posts);
        $this->assertCount(1, $posts);
    }

    /**
     * @test
     */
    public function testHasPublishedScope()
    {
        factory(Post::class)->create(['status' => 'publish']);
        $posts = Post::published()->get();
        $this->assertNotNull($posts);
        $this->assertGreaterThan(0, $posts->count());
    }

    /**
     * @test
     */
    public function testHasTypeScope()
    {
        factory(Post::class)->create(['type' => 'foo']);
        $posts = Post::type('foo')->get();
        $this->assertNotNull($posts);
        $this->assertCount(1, $posts);
    }

    /**
     * @test
     */
    public function testHasTypeInScope()
    {
        factory(Post::class)->create(['type' => 'blue']);
        factory(Post::class)->create(['type' => 'red']);
        factory(Post::class)->create(['type' => 'yellow']);
        $posts = Post::typeIn(['blue', 'yellow'])->get();
        $this->assertNotNull($posts);
        $this->assertCount(2, $posts);
    }

    /**
     * @test
     */
    public function testHasTaxonomyScope()
    {
        $this->createPostWithTaxonomiesAndTerms();
        $posts = Post::taxonomy('foo', 'test')->get();
        $this->assertNotNull($posts);
        $this->assertGreaterThan(0, $posts->count());
    }

    /**
     * @return Post
     */
    private function createPostWithTaxonomiesAndTerms()
    {
        $post = factory(Post::class)->create();
        $post->taxonomies()->attach(
            factory(Taxonomy::class)->create([
                'taxonomy' => 'foo',
                'term_id'  => function () {
                    return factory(Term::class)->create([
                        'slug' => 'test',
                    ])->id;
                },
            ])
        );

        return $post;
    }

    /**
     * @test
     */
    public function testCanHaveDifferentPostType()
    {
        $page = factory(Post::class)->create(['type' => 'example-page']);
        $this->assertEquals($page->type, 'example-page');
    }

    /**
     * @test
     */
    public function testCanAcceptUnicodeChars()
    {
        $post = factory(Post::class)->create([
            'content' => [
                'en' => [
                    'title' => 'English characters',
                ],
                'ru' => [
                    'title' => 'Русские символы',
                ],
            ],
        ]);
        $this->assertEquals('English characters', $post->content['en']['title']);
        $this->assertEquals('Русские символы', $post->content['ru']['title']);
    }

    /**
     * @test
     */
    public function testCanOrderedAscending()
    {
        factory(Post::class, 2)->create();
        $posts = Post::query()->orderBy('publish_at')->get();
        $first = $posts->first();
        $last = $posts->last();
        $this->assertTrue($first->publish_at->lessThanOrEqualTo($last->publish_at));
        $this->assertTrue($last->publish_at->greaterThanOrEqualTo($first->publish_at));
    }

    /**
     * @test
     */
    public function testCanOrderedDescending()
    {
        factory(Post::class, 2)->create();
        $posts = Post::orderBy('publish_at', 'desc')->get();
        $last = $posts->first();
        $first = $posts->last();
        $this->assertTrue($first->publish_at->lessThanOrEqualTo($last->publish_at));
        $this->assertTrue($last->publish_at->greaterThanOrEqualTo($first->publish_at));
    }

    /**
     * @test
     */
    public function testCanBePaginated()
    {
        $post = factory(Post::class)->create();
        factory(Post::class)->create();
        factory(Post::class)->create();
        $paginator = Post::paginate(2);
        $firstPost = Arr::first($paginator->items());
        $this->assertEquals(2, $paginator->perPage());
        $this->assertEquals(1, $paginator->currentPage());
        $this->assertEquals(2, $paginator->count());
        $this->assertEquals(3, $paginator->total());
        $this->assertInstanceOf(Post::class, $firstPost);
        $this->assertEquals($post->slug, $firstPost->slug);
        $this->assertStringStartsWith('<ul class="pagination"', $paginator->toHtml());
    }

    /**
     * @test
     */
    public function testCanHaveTaxonomy()
    {
        $post = $this->createPostWithTaxonomiesAndTerms();
        $this->assertCount(1, $post->taxonomies);
        $this->assertEquals('foo', $post->taxonomies->first()->taxonomy);
    }

    /**
     * @test
     */
    public function testCanHaveTaxonomyAndTerms()
    {
        $createdPost = $this->createPostWithTaxonomiesAndTerms();
        $post = Post::orderBy('id', 'desc')
            ->taxonomy('foo', 'test')->first();

        $this->assertNotNull($post);
        $this->assertEquals($createdPost->id, $post->id);
    }

    /**
     * @test
     */
    public function testCanHaveGetTermsAttribute()
    {
        $post = $this->createPostWithTaxonomiesAndTerms();

        $this->assertIsArray($post->getTermsAttribute());
        $this->assertTrue(isset($post->getTermsAttribute()['foo']));
        $this->assertFalse(isset($post->getTermsAttribute()['fee']));
        $this->assertTrue(isset($post->getTermsAttribute()['foo']['test']));
        $this->assertFalse(isset($post->getTermsAttribute()['fee']['baz']));
    }

    /**
     * @test
     */
    public function testCanHaveTerm()
    {
        $post = $this->createPostWithTaxonomiesAndTerms();

        $this->assertTrue($post->hasTerm('foo', 'test'));
        $this->assertFalse($post->hasTerm('foo', 'baz'));
        $this->assertFalse($post->hasTerm('fee', 'test'));
        $this->assertFalse($post->hasTerm('fee', 'baz'));
    }

    /**
     * @test
     */
    public function testCanHaveOptions()
    {
        $post = $this->createPostWithTaxonomiesAndTerms();

        $this->assertIsArray($post->getOptions()->first());
        $this->assertTrue(isset($post->getOptions()['locale']));
    }

    /**
     * @test
     */
    public function testCanHaveOption()
    {
        $post = $this->createPostWithTaxonomiesAndTerms();

        $this->assertIsArray($post->getOption('locale'));
        $this->assertEquals('true', $post->getOption('locale')['en']);
        $this->assertEquals('test', $post->getOption('default', 'test'));

        $post = factory(Post::class)->create(['options' => 'locale']);

        $this->assertEquals('test', $post->getOption('locale', 'test'));
    }

    /**
     * @test
     */
    public function testCanHaveCheckLanguage()
    {
        $post = $this->createPostWithTaxonomiesAndTerms();

        $this->assertTrue($post->checkLanguage('en'));
        $this->assertFalse($post->checkLanguage('ru'));
    }

    /**
     * @test
     */
    public function testCanHaveAuthorRelation()
    {
        $post = $this->createPostWithAuthor();
        $user = User::get()->first();

        $this->assertEquals($user->name, $post->author->name);
        $this->assertEquals($user->email, $post->author->email);
    }

    /**
     * @return Post
     */
    private function createPostWithAuthor()
    {
        $post = factory(Post::class)->create();
        $post->author()->associate(User::get()->first());

        return $post;
    }

    /**
     * @test
     */
    public function testCanHaveAuthorGetUser()
    {
        $post = $this->createPostWithAuthor();
        $user = User::get()->first();

        $this->assertEquals($user->name, $post->getUser()->name);
        $this->assertEquals($user->email, $post->getUser()->email);
    }
}
