# Formulários
----------

O formulário é uma parte independente do aplicativo que se compromete com a funcionalidade do controlador e é usada para criar páginas extensíveis.



> **Aviso:** Se não planeias permitir que os teus formulários sejam expansíveis em pacotes, o melhor para ti é usar um controlador ou um ecrã clássico.


![Formulários](https://orchid.software/img/scheme/forms.jpg)

Os formulários não são construtores ou empreiteiros.
Eles destinam-se a gerar o formulário de dados onde podes adicionar novos dados na forma de abas que não sabem nada uns dos outros, mas operam as mesmas informações de entrada.

Como exemplo, finje que tens um formulário de utilizador que, por padrão, possui duas abas
com a mesma informação e direitos de utilizador; podemos expandir e adicionar
uma variedade de informações diferentes, adicionando novos formulários (registrados por eventos),
enquanto no código do programa tu verás apenas a apresentação do formulário e a ação que deve ser realizada no modelo resultante.
Isto permite expandir abas existentes e adaptá-las melhor às tuas necessidades.

> **Exemplo:** Existe um pacote para loja online que permite adicionar o novo item,
ele preparou campos de entrada no interior (Nome, custo, etc.).
É possível adicionar uma funcionalidade de componente de terceiros ao usares formulários, por exemplo, se precisarmos também carregar a documentação do item.

ORCHID tem dois tipos de formulários:

1. Forma principal
1. Forma de implementação


## Formulário principal

A diferença entre o formulário principal e a implementação está na habilidade de `adicionar uma quantidade ilimitada de executores` ao chamar `eventos'.

Um exemplo de formulário principal:
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

## Formulário de implementação

Um formulário onde os dados são `salvos/atualizados`. Todo o formulário possui as suas próprias propriedades de validação de dados.
Todo o formulário de implementação é executado sem qualquer informação sobre formulários anteriores ou seguintes.

A forma como o formulário é implementado não deve levantar qualquer dúvida, pois parece um controlador genérico.

Um exemplo:
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

O seu `controlador` deverá ser parecido com isto:

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
