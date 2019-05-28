<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen;

use Orchid\Screen\Builder;
use Orchid\Screen\Repository;
use Orchid\Tests\TestUnitCase;
use Orchid\Screen\Fields\Input;

/**
 * Class BuilderTest.
 */
class BuilderTest extends TestUnitCase
{
    /**
     * @throws \Throwable
     */
    public function testSimpleBuild()
    {
        $form = $this->getBuilder(['name' => 'Alexandr'])
            ->generateForm();

        $this->assertContains('name="name"', $form);
        $this->assertContains('value=="Alexandr"', $form);
    }

    /**
     * @throws \Throwable
     */
    public function testPrefixBuild()
    {
        $form = $this->getBuilder(['profile' => ['name' => 'Alexandr']])
            ->setPrefix('profile')
            ->generateForm();

        $this->assertContains('name="profile[name]"', $form);
        $this->assertContains('value="Alexandr"', $form);
    }

    /**
     * @throws \Throwable
     */
    public function testLanguageBuild()
    {
        $form = $this->getBuilder([
            'profile' => [
                'en' => ['name' => 'Alexandr'],
            ],
        ])
            ->setLanguage('en')
            ->setPrefix('profile')
            ->generateForm();

        $this->assertContains('name="profile[ru][name]', $form);
        $this->assertContains('lang="en"', $form);
        $this->assertContains('value="Alexandr"', $form);
    }

    /**
     * @throws \Throwable
     */
    public function testPrefixForFields()
    {
        $fields = [
            Input::make('name')->prefix('one'),
            Input::make('name')->prefix('two'),
            Input::make('name')->prefix('three'),
        ];

        $data = new Repository(['name' => 'Alexandr']);

        $builder = new Builder($fields, $data);

        $form = $builder->generateForm();

        $this->assertContains('name="one[name]"', $form);
        $this->assertContains('name="two[name]"', $form);
        $this->assertContains('name="three[name]"', $form);
        $this->assertContains('value="Alexandr"', $form);
    }

    /**
     * @throws \Throwable
     */
    public function testPrefixAndLanguageForFields()
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

        $this->assertContains('name="one[en][name]"', $form);
        $this->assertContains('name="two[en][name]"', $form);
        $this->assertContains('name="three[en][name]"', $form);
        $this->assertContains('lang="en"', $form);
        $this->assertContains('value="Alexandr"', $form);
    }

    /**
     * @param array $value
     *
     * @return Builder
     */
    private function getBuilder($value = [])
    {
        $fields = [Input::make('name')];
        $data = new Repository($value);

        return new Builder($fields, $data);
    }
}
