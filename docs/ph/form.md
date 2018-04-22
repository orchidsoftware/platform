# Mga Form
----------
 
Ang form ay isang bahaging hindi nakadepende sa aplikasyon na kumukontrol sa function ng tagakontrol at nagsisilbing tagalikha ng mga pahinang
magagamit sa pagpapalawak.

Ang form ay hindi isang tagagawa o tagatayo.
Ang kanilang paraan sa pagbubuo ng isang form ng datos, kung saan makakadagdag ka ng mga bagong impormasyon sa anyo ng mga tab,
na walang alam tungkol sa isa't isa, pero gumagana sa kaparehong mga impormasyon.
Halimbawa, mayroon tayong form ng tagagamit, kung saan sa default ay may dalawang tab
na may pangkalahatang impormasyon at access na mga karapatan, sa pamamagitan ng pagdagdag ng mga bagong form
(na nakarehistro sa tulong ng mga pangyayari), mapapalawak at makakadagdag tayo ng iba't-ibang mga impormasyon,
habang sa code makikita mo lamang ang display ng form at ang aksyon na gagawin sa naresultang modelo.
Pinahihintulutan nitong palawakin ang mga istandard na na mga tab at mas eksaktong mabago sa ilalim ng mga mahalagang pangangailangan.

Bilang halimbawa:

> May isang pakete para sa isang online na tindahan na pinapayagan kang magdagdag ng mga bilihin,
dito ay mga naihandang mga field para sa input (Pangalan, presyo, atbp.).
Sa paggamit ng mga form,
ang isang pangatlong partidong pakete ay makakadagdag ng sarili nitongadd-on, halimbawa, pagda-download ng dokumentasyon para sa produkto.


Ang ORCHID ay may dalawang mga form:

1. Ang Pangunahi
1. Pagre-realize

### Pangunahing Form

Ang pangunahing form ay naiiba lamang sa pagre-realize sa katotohanang posibleng makakonekta ng walang hanggang numero ng mga tagapagpatupad ` sa pamamagitan ng pagtawag ng mga ` pangyayari`.

Isang halimbawa ng pangunahing form:
```php
namespace Orchid\Platform\Http\Forms\Systems\Roles;

use Orchid\Platform\Forms\FormGroup;
use Orchid\Platform\Models\Role;
use Orchid\Platform\Events\Systems\RolesEvent;

class RoleFormGroup extends FormGroup
{
    /**
     * @var
     */
    public $event = RolesEvent::class;

    /**
     * Katangiang pang-deskripsyon para sa grupo.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name'        => 'Pangalan',
            'description' => 'deskripsyon',
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function main()
    {
        //Ipakita ang pangunahing form o grid
        return view('');
    }
}

```

### Pagpapatupad ng form

Ang form kung saan ang datos ay `na-seyb/na-update`. Ang nosyon na ang form ay may sariling katangian sa pagpapatunay.
Ang bawat pagpapatupad na form ay pagaganahin nang walang nalalaman tungkol sa nakaraan o sumsunod.
Ang pagsulat ng form ay hindi dapat nagreresulta sa kahit anong problema dahil mukha itong regular na tagakontrol.

Halimbawa:
```php
namespace Orchid\Platform\Http\Forms\Systems\Roles;

use Orchid\Platform\Forms\Form;
use Orchid\Platform\Models\Role;
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
        //Ipakita ang form
    }

    /**
     * Save Base Post.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function persist()
    {
        //i-seyb ang aksyon
    }

    /**
     * @param Role $role
     */
    public function delete(Role $role)
    {
        //tanggalin ang aksyon
    }
}

```

Pagkatapos ang `tagakontrol` ay magmumukhang ganito:

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
