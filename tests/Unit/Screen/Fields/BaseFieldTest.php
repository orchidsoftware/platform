<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Illuminate\Http\Request;
use Illuminate\View\ComponentAttributeBag;
use Orchid\Screen\Exceptions\FieldRequiredAttributeException;
use Orchid\Screen\Field;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

/**
 * Class BaseFieldTest.
 */
class BaseFieldTest extends TestFieldsUnitCase
{
    /**
     * @var Field
     */
    public $field;

    protected function setUp(): void
    {
        parent::setUp();

        $field = new class extends Field
        {
            /**
             * @var string
             */
            public $view = '';

            /**
             * Default attributes value.
             *
             * @var array
             */
            public $attributes = [
                'class' => 'form-control',
            ];

            /**
             * @var array
             */
            public $required = [
                'name',
                'height',
            ];
        };

        $this->field = $field;
    }

    public function testRequiredAttributeNameField(): void
    {
        $this->expectException(FieldRequiredAttributeException::class);
        $this->expectExceptionMessage('Field must have the following attribute: name');

        $this->field->render();
    }

    public function testRequiredAttributeHeightField(): void
    {
        $this->expectException(FieldRequiredAttributeException::class);
        $this->expectExceptionMessage('Field must have the following attribute: height');

        $this->field->set('name', 'First name');
        $this->field->render();
    }

    public function testNoDisplay(): void
    {
        $this->assertNull($this->field->canSee(false)->render());
    }

    public function testAllowedAttributesPreserveExactAndWildcardPatterns(): void
    {
        $field = new class extends Field
        {
            protected $universalAttributes = [
                'class',
                'data-*',
                'aria-*',
            ];

            protected $inlineAttributes = [
                'href',
                'custom-*',
            ];

            protected $attributes = [
                'class'           => 'form-control',
                'href'            => '/dashboard',
                'data-controller' => 'field',
                'aria-label'      => 'Field',
                'custom-option'   => 'enabled',
                'unknown'         => 'discarded',
            ];

            public function allowedAttributes(): ComponentAttributeBag
            {
                return $this->getAllowAttributes();
            }
        };

        $this->assertSame([
            'class'           => 'form-control',
            'href'            => '/dashboard',
            'data-controller' => 'field',
            'aria-label'      => 'Field',
            'custom-option'   => 'enabled',
        ], $field->allowedAttributes()->getAttributes());
    }

    public function testDataAndAriaAttributesRequireMatchingPatterns(): void
    {
        $field = new class extends Field
        {
            protected $universalAttributes = ['class'];

            protected $attributes = [
                'class'           => 'form-control',
                'data-controller' => 'field',
                'aria-label'      => 'Field',
            ];

            public function allowedAttributes(): ComponentAttributeBag
            {
                return $this->getAllowAttributes();
            }
        };

        $this->assertSame([
            'class' => 'form-control',
        ], $field->allowedAttributes()->getAttributes());
    }

    public function testRenderPreservesDataAttributeOverrides(): void
    {
        $this->app->instance('request', Request::create('/'));

        $field = new class extends Field
        {
            protected $view = 'orchid::actions.link';

            protected $typeForm = null;

            protected $attributes = [
                'name'            => 'Dashboard',
                'href'            => '/dashboard',
                'turbo'           => true,
                'data-controller' => 'field',
            ];

            protected $inlineAttributes = [
                'href',
            ];

            protected function getAllowDataAttributes(): ComponentAttributeBag
            {
                $this->set('data-resolver', 'custom');

                return parent::getAllowDataAttributes();
            }
        };

        $view = $field->render();

        $this->assertEquals([
            'data-controller' => 'field',
            'data-resolver'   => 'custom',
        ], $view->getData()['dataAttributes']->getAttributes());
    }
}
