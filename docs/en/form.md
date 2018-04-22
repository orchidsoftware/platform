# Forms
----------

Form is an independent part of application that undertakes controller functionality and is used to create extendable pages.



> **Notice:** If you do not plan to allow your forms to be package expandable, then the best for you is to use classic controller or screen.


![Forms](https://orchid.software/img/scheme/forms.jpg)

Forms are not constructors or builders.
They are intended to generate data form where you can add new data in the form of tabs that don't know anything about each other but operate the same input information. 

As example, pretend you have a user form that by default has two tabs
with the same information and user rights; we can expand and add 
a variety of different information by adding new forms (registered by events), 
whereas in the program code you will only see the form presentation and the action that must be performed on the resulting model.
That allows you to expand existing tabs and better adapt them for your needs.

> **Example:** There is a package for online store that allows to add the new item,
it has prepared input fields (Name, cost, etc.) inside. 
It's possible to add a third-party component functionality to it by using forms, for example, if we need to also upload the item documentation.  

ORCHID has two types of forms:

1. Main form
1. Implementation form


## Main form

The difference between the main form and implementation is in ability to `add an unlimited amount of executors` by calling `events`.

An example of main form:
```php
use Orchid\Platform\Forms\FormGroup;
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

## Implementation form

A form where data is `saved/refreshed`. Every form has it's own data validation properties.
Every implementation form is executed without any info about previous or following forms.

The way form is implemented should not raise any questions as it looks like a generic controller.

An example:
```php
use Orchid\Platform\Forms\Form;
use Orchid\Platform\Models\Role;

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

Your `controller` should look like the following:

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
