<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen;

use Orchid\Screen\Builder;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Repository;
use Orchid\Tests\TestUnitCase;

/**
 * Class BuilderTest.
 */
class BuilderTest extends TestUnitCase
{
    /**
     * @throws \Throwable
     */
    public function testSimpleBuild(): void
    {
        $form = $this->getBuilder(['name' => 'Alexandr'])
            ->generateForm();

        $this->assertStringContainsString('name="name"', $form);
        $this->assertStringContainsString('value="Alexandr"', $form);
    }

    /**
     * @throws \Throwable
     */
    public function testPrefixBuild(): void
    {
        $form = $this->getBuilder(['profile' => ['name' => 'Alexandr']])
            ->setPrefix('profile')
            ->generateForm();

        $this->assertStringContainsString('name="profile[name]"', $form);
        $this->assertStringContainsString('value="Alexandr"', $form);
    }

    /**
     * @throws \Throwable
     */
    public function testLanguageBuild(): void
    {
        $form = $this->getBuilder(['en' => ['name' => 'Alexandr']])
            ->setLanguage('en')
            ->generateForm();

        $this->assertStringContainsString('name="en[name]', $form);
        $this->assertStringContainsString('lang="en"', $form);
        $this->assertStringContainsString('value="Alexandr"', $form);
    }

    /**
     * @throws \Throwable
     */
    public function testLanguageAndPrefixBuild(): void
    {
        $form = $this->getBuilder([
            'profile' => [
                'en' => ['name' => 'Alexandr'],
            ],
        ])
            ->setLanguage('en')
            ->setPrefix('profile')
            ->generateForm();

        $this->assertStringContainsString('name="profile[en][name]', $form);
        $this->assertStringContainsString('lang="en"', $form);
        $this->assertStringContainsString('value="Alexandr"', $form);
    }

    /**
     * @throws \Throwable
     */
    public function testPrefixForFields(): void
    {
        $fields = [
            Input::make('name')->prefix('one'),
            Input::make('name')->prefix('two'),
            Input::make('name')->prefix('three'),
        ];

        $data = new Repository(['name' => 'Alexandr']);

        $builder = new Builder($fields, $data);

        $form = $builder->generateForm();

        $this->assertStringContainsString('name="one[name]"', $form);
        $this->assertStringContainsString('name="two[name]"', $form);
        $this->assertStringContainsString('name="three[name]"', $form);
        $this->assertStringContainsString('value="Alexandr"', $form);
    }

    /**
     * @throws \Throwable
     */
    public function testPrefixAndLanguageForFields(): void
    {
        $fields = [
            Input::make('name')->prefix('one'),
            Input::make('name')->prefix('two'),
            Input::make('name')->prefix('three'),
        ];

        $data = new Repository(['en' => ['name' => 'Alexandr']]);

        $builder = new Builder($fields, $data);

        $form = $builder
            ->setLanguage('en')
            ->generateForm();

        $this->assertStringContainsString('name="one[en][name]"', $form);
        $this->assertStringContainsString('name="two[en][name]"', $form);
        $this->assertStringContainsString('name="three[en][name]"', $form);
        $this->assertStringContainsString('lang="en"', $form);
        $this->assertStringContainsString('value="Alexandr"', $form);
    }

    public function testNestedGroupsBuild(): void
    {
        $builder = new Builder([
            Group::make([
                Group::make([
                    Input::make('test'),
                ])
            ])
        ]);

        $form = $builder->generateForm();

        $this->assertStringContainsString('input', $form);
        $this->assertStringContainsString('name="test"', $form);
    }

    /**
     * @throws \Throwable
     */
    public function emptyRepositoryBuilder(): void
    {
        $builder = new Builder([
            Input::make('name'),
        ]);

        $form = $builder->generateForm();

        $this->assertStringContainsString('input', $form);
    }

    /**
     * @param array $value
     */
    private function getBuilder($value = []): Builder
    {
        $fields = [Input::make('name')];
        $data = new Repository($value);

        return new Builder($fields, $data);
    }
}
