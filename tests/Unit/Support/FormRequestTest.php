<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Support;

use Illuminate\Container\Container;
use Illuminate\Contracts\Validation\Factory as ValidationFactoryContract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory as ValidationFactory;
use Mockery as m;
use Orchid\Support\Concerns\ValidDataPart;
use Orchid\Tests\TestUnitCase;

class FormRequestTest extends TestUnitCase
{

    public function testValidatedMethodReturnsOfPartTheValidatedData()
    {
        $request = $this->createRequest([
            'profile' => ['name' => 'Alexandr Chernyaev'],
        ]);

        $request->validateResolved();

        $this->assertEquals('Alexandr Chernyaev', $request->validated('profile.name'));
        $this->assertEquals('default', $request->validated('default', 'default'));
    }

    /**
     * Create a new request of the given type.
     *
     * @param array $payload
     *
     * @return FormRequest
     */
    protected function createRequest($payload = [])
    {
        $container = tap(new Container(), function ($container) {
            $container->instance(
                ValidationFactoryContract::class,
                $this->createValidationFactory($container)
            );
        });

        $class = new class extends FormRequest {
            use ValidDataPart;

            public function rules()
            {
                return [
                   'profile' => ['name' => 'required']
                ];
            }

            public function authorize()
            {
                return true;
            }
        };

        $request = $class::create('/', 'GET', $payload);

        return $request->setRedirector($this->createMockRedirector())
            ->setContainer($container);
    }

    /**
     * Create a new validation factory.
     *
     * @param Container $container
     *
     * @return ValidationFactory
     */
    protected function createValidationFactory($container)
    {
        $translator = m::mock(Translator::class)->shouldReceive('get')
            ->zeroOrMoreTimes()->andReturn('error')->getMock();

        return new ValidationFactory($translator, $container);
    }

    /**
     * Create a mock redirector.
     *
     * @return Redirector
     */
    protected function createMockRedirector()
    {
        $redirector = $this->mocks['redirector'] = m::mock(Redirector::class);

        $redirector->shouldReceive('getUrlGenerator')->zeroOrMoreTimes()
            ->andReturn($generator = $this->createMockUrlGenerator());

        $redirector->shouldReceive('to')->zeroOrMoreTimes()
            ->andReturn($this->createMockRedirectResponse());

        $generator->shouldReceive('previous')->zeroOrMoreTimes()
            ->andReturn('previous');

        return $redirector;
    }

    /**
     * Create a mock URL generator.
     *
     * @return UrlGenerator
     */
    protected function createMockUrlGenerator()
    {
        return $this->mocks['generator'] = m::mock(UrlGenerator::class);
    }

    /**
     * Create a mock redirect response.
     *
     * @return RedirectResponse
     */
    protected function createMockRedirectResponse()
    {
        return $this->mocks['redirect'] = m::mock(RedirectResponse::class);
    }
}
