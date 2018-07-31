<?php

declare(strict_types=1);

namespace Orchid\Bulldozer\Http\Controllers;

use Illuminate\Http\Request;
use Orchid\Bulldozer\Builders\Model;
use Illuminate\Support\Facades\Cache;
use Orchid\Platform\Http\Controllers\Controller;

/**
 * Class BootController.
 */
class BootController extends Controller
{
    const MODELS = 'platform::boot.models';

    /**
     * BootController constructor.
     */
    public function __construct()
    {
        $this->checkPermission('platform.systems.attachment');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \ReflectionException
     */
    public function index()
    {
        $test = new Model('Test', [
            'property' => [
                'fillable' => ['id', 'name'],
                'guarded'  => [''],
                'hidden'   => [''],
                'visible'  => [''],
            ],
            'methods'  => [
                [
                    'model'            => '',
                    'relationshipType' => '',
                    'localKey'         => '',
                    'relatedKey'       => '',
                ],
            ],
        ]);

        //dd($test->generate());

        return view('platform::container.boot.index', [
            'models' => Cache::get(static::MODELS, []),
        ]);
    }

    /**
     * @param         $model
     * @param Request $request
     */
    public function store($model, Request $request)
    {
    }

    /**
     * @param         $model
     * @param Request $request
     */
    public function edit($model, Request $request)
    {
    }

    /**
     * @param Request $request
     * @throws \ReflectionException
     */
    public function saveModel(Request $request)
    {
        $test = new Model('Test', [
            'property' => [
                'fillable' => ['id', 'name'],
                'guarded'  => [''],
                'hidden'   => [''],
                'visible'  => [''],
            ],
            'methods'  => [
                [
                    'model'            => '',
                    'relationshipType' => '',
                    'localKey'         => '',
                    'relatedKey'       => '',
                ],
            ],
        ]);

        //dd($test->generate());
    }
}
