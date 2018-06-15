<?php

declare(strict_types=1);

namespace Orchid\Boot\Http\Controllers\Screens;

use Orchid\Screen\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Layouts;
use Illuminate\Http\Request;
use Orchid\Boot\Builders\Model;
use Illuminate\Support\Collection;
use Orchid\Boot\Builders\Migration;
use Orchid\Boot\Layouts\BootCreateModel;

class BootModelScreen extends Screen
{
    const MODELS = 'platform::boot.models';

    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Boot Models';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Add your Models, customize your columns, and even setup relationships.';

    /**
     * @var string
     */
    public $permission = 'platform.boot';

    /**
     * @var Collection
     */
    public $models;

    /**
     * @var
     */
    public $exist = false;

    /**
     * BootModelScreen constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->models = cache(static::MODELS, collect());
    }

    /**
     * Query data.
     *
     * @param $model
     * @return array
     */
    public function query($model): array
    {
        if ($model) {
            $this->exist = true;
            $this->name = "Boot for '{$model}' model";
        }

        return [
            'models'        => $this->models,
            'model'         => $model,
            'fieldTypes'    => Migration::TYPES,
            'relationTypes' => Model::RELATIONS,
        ];
    }

    /**
     * Button commands.
     *
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Link::name('Сохранить')
                ->icon('icon-check')
                ->show($this->exist)
                ->method('save'),
            Link::name('Удалить')
                ->icon('icon-trash')
                ->show($this->exist)
                ->method('delete'),
            Link::name('Добавить новую модель')
                ->icon('icon-plus')
                ->modal('CreateModelModal')
                ->title('Добавить новую модель')
                ->method('createModel'),
        ];
    }

    /**
     * Views.
     *
     * @return array
     * @throws \Orchid\Press\TypeException
     */
    public function layout(): array
    {
        return [
            Layouts::view('platform::container.boot.index'),

            // Модальные окна
            Layouts::modals([
                'CreateModelModal' => [
                    BootCreateModel::class,
                ],
            ]),
        ];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createModel(Request $request)
    {
        $name = studly_case($request->get('name'));

        if ($this->models->offsetExists($name)) {
            alert('Модель с таким именем уже существует');

            return back();
        }

        $this->models->put($name, collect());

        cache()->forever(static::MODELS, $this->models);

        alert('Модель успешно сохранена');

        return redirect()->route('platform.boot.index', $name);
    }

    /**
     * @param string $model
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(string $model)
    {
        $this->models = $this->models->except($model);
        cache()->forever(static::MODELS, $this->models);

        alert('Модель была удалена');

        return redirect()->route('platform.boot.index');
    }

    public function save()
    {
    }
}
