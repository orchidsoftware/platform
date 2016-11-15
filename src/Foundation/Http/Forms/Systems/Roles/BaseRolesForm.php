<?php namespace Orchid\Foundation\Http\Forms\Systems\Settings;

use Orchid\Foundation\Core\Models\Role;
use Orchid\Foundation\Facades\Dashboard;
use Orchid\Foundation\Services\Forms\Form;

class BaseRolesForm extends Form
{

    /**
     * @var string
     */
    public $name = 'General Info';

    /**
     * Base Model
     * @var
     */
    protected $model = Role::class;


    /**
     * Validation Rules Request
     * @var array
     */
    protected $rules = [
        'name' => 'required|unique:roles|max:255',
        'slug' => 'required|unique:roles|max:255',
        'permissions' => 'array'
    ];


    /**
     * Display Settings App
     * @param null $storage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get($storage = null)
    {
        //  dd($storage); Тут мы получим модельку
       $permission = Dashboard::getPermission();

        return view('dashboard::container.systems.roles.info', [
            'permission' => $permission,
        ]);
    }

    /**
     * Save Base Role
     * @param null $storage
     * @return \Illuminate\Http\JsonResponse
     */
    public function persist($storage = null)
    {
        dd($storage);

        $test = Role::create($this->request->all());



        return response()->json(
            [
                'title' => 'Успешно',
                'message' => 'Данные сохранены',
            ]
        );
    }
}
