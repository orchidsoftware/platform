# Forms
----------
 
The form is an independent part of the application that takes over the function of the controller and serves to create pages
available for expansion.

The form is not a constructor or builder.
Their sense in the formation of a form of data, in which you can add new information in the form of tabs,
who do not know anything about each other, but operate on the same information.
For example, we have a form of user, where by default there are two tabs
with general information and access rights, by adding new forms
(registered with the help of events), we can expand and add various information,
while in the code you will see only the display of the form and the action to be taken with the resulting model.
That allows to expand already standard tabs and more accurately to be adjusted under necessary needs.

For example:

> There is a package for an online store that allows you to add goods,
in it are pre-prepared fields for input (Name, price, etc.).
Using forms,
a third-party package can add its own add-on, for example, downloading documentation for the product.


ORCHID has two forms:

1. The main
1. Realizing

### Basic Form

The basic form differs from realizing only by the fact that it is possible to `connect an unlimited number of implementers` by means of calling` events`.

An example of the basic form:
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

### Implementing form

The form on which the data is `saved/updated`. A notion that the form has its own properties of validation.
Each implementing form will be run in turn without knowing anything about the previous or subsequent.
Writing a form should not cause any problems since it looks like a regular controller.

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

Then your `controller` will look like this:

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
