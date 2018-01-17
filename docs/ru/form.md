# Формы
----------

Форма является независимой частью приложения, которая принимает на себя функцию контроллера 
и служит для создания страниц доступных для расширения.



> **Примечание:** Если вы не планируете давать возможность расширять ваши формы с помощью пакетов,
 то наилучшим вариантом будет воспользоваться классическим контроллером или экраном.


Формы не является конструктором или строителем.
Их смысл в формировании формы данных, в которую можно добавлять новую информацию в виде табов, 
которые ничего друг о друге не знают, но оперируют одной информацией. 
Например у нас есть форма пользователя, где по умолчанию указано две вкладки 
с общей информацией и правами доступа, с помощью добавления новых форм 
(зарегистрированных с помощью событий) мы можем расширить и добавить различную информацию, 
при этом в коде вы будете видеть только отображение формы и действие которое надо сделать с полученной моделью. 
Тем позволяя расширять уже стандартные вкладки и чётче подстраиваться под необходимые нужды.

> **Например:** Существует пакет для интернет магазина, который позволяет добавлять товар,
в нём заранее пред заготовлены поля для ввода (Название, цена и т.п). 
С помощью форм,
сторонний пакет может добавить своё собственно дополнение, например загрузку документации к товару.


ORCHID имеет две формы:

1. Основная
1. Реализующая


## Основная форма

Основная форма отличается от реализации только тем, что можно `подключить неограниченное количество исполнителей` посредством вызова `событий`.

Пример базовой формы:
```php
namespace Orchid\Platform\Http\Forms\Systems\Roles;

use Orchid\Platform\Forms\FormGroup;
use Orchid\Platform\Core\Models\Role;
use Orchid\Platform\Events\Systems\RolesEvent;

class RoleFormGroup extends FormGroup
{
    /**
     * @var
     */
    public $event = RolesEvent::class;

    /**
     * Description Attributes for group.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name'        => 'Name',
            'description' => 'description',
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function main()
    {
        //Display main form or grid
        return view('');
    }
}

```

## Форма реализации

Форма, на которой данные `сохраняются/обновляются`. Каждая форма имеет свои собственные свойства проверки данных.
Каждая реализующая форма будет запускаться в свою очередь, не зная ничего о предыдущем или последующем.
Запись формы не должна вызывать никаких проблем, поскольку она выглядит как обычный контроллер.

Example:
```php
namespace Orchid\Platform\Http\Forms\Systems\Roles;

use Orchid\Platform\Forms\Form;
use Orchid\Platform\Core\Models\Role;
use Alert;
use Dashboard;

class BaseRolesForm extends Form
{
    /**
     * @var string
     */
    public $name = 'General Info';

    /**
     * Base Model.
     *
     * @var
     */
    protected $model = Role::class;

    /**
     * Validation Rules Request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required|max:255',
            'slug'        => 'required|max:255',
            'permissions' => 'array',
        ];
    }

    /**
     * Display Settings App.
     *
     * @param Role|null $role
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get()
    {
        //Display form
    }

    /**
     * Save Base Post.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function persist()
    {
        //save action
    }

    /**
     * @param Role $role
     */
    public function delete(Role $role)
    {
        //remove action
    }
}

```

Тогда ваш `controller` будет выглядеть так:

```php
namespace Orchid\Foundation\Http\Controllers\Systems;

use Illuminate\Http\Request;
use Orchid\Foundation\Core\Models\Role;
use Orchid\Foundation\Http\Controllers\Controller;
use Orchid\Foundation\Http\Forms\Systems\Roles\RoleFormGroup;

class RoleController extends Controller
{
    /**
     * @var
     */
    public $form = RoleFormGroup::class;

    /**
     * RoleController constructor.
     */
    public function __construct()
    {
        $this->form = new $this->form();
    }

    /**
     * @return string
     */
    public function index()
    {
        return $this->form->grid();
    }

    /**
     * @return mixed
     */
    public function create()
    {
        return $this->form
            ->route('dashboard.systems.roles.update')
            ->method('POST')
            ->render();
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->form->save();

        return redirect()->route('dashboard.systems.roles.edit', $request->get('slug'));
    }

    /**
     * @param Request $request
     * @param Role    $role
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Role $role)
    {
        $this->form->save($role);

        return redirect()->route('dashboard.systems.roles.edit', $request->get('slug'));
    }

    /**
     * @param Role $role
     *
     * @return mixed
     */
    public function edit(Role $role)
    {
        return $this->form
            ->route('dashboard.systems.roles.update')
            ->slug($role->slug)
            ->method('PUT')
            ->render($role);
    }

    /**
     * @param Role $role
     *
     * @return mixed
     */
    public function destroy(Role $role)
    {
        $this->form->remove($role);

        return redirect()->route('dashboard.systems.roles');
    }
}

```

