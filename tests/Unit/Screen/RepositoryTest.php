<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen;

use Orchid\Screen\Repository;
use Orchid\Tests\TestUnitCase;

/**
 * Class RepositoryTest.
 */
class RepositoryTest extends TestUnitCase
{
    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var array
     */
    protected $config;

    protected function setUp(): void
    {
        $this->repository = new Repository($this->config = [
            'foo'       => 'bar',
            'bar'       => 'baz',
            'null'      => null,
            'numeric'   => 142,
            'associate' => [
                'x' => 'xxx',
                'y' => 'yyy',
            ],
            'array'     => [
                'aaa',
                'zzz',
            ],
            'x'         => [
                'z' => 'zoo',
            ],
        ]);

        parent::setUp();
    }

    public function test_repository_count(): void
    {
        $this->assertEquals(7, $this->repository->count());
    }

    public function test_repository_to_array(): void
    {
        $this->assertInstanceOf(Repository::class, $this->repository);
        $this->assertIsArray($this->repository->toArray());
    }

    public function test_repository_content(): void
    {
        $this->assertEquals('yyy', $this->repository->getContent('associate.y'));
        $this->assertEquals('ggg', $this->repository->getContent('associate.g', 'ggg'));
        $this->assertEquals(142, $this->repository->getContent('numeric'));

        $this->assertNull($this->repository->getContent('null'));
        $this->assertNull($this->repository->getContent('abc'));
    }
}
