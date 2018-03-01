# Direitos de acesso
----------
O controle de acesso baseado em funções é o desenvolvimento de uma política de controle de acesso de amostra. Uma função se forma como objetos do grupo de estruturas de autorização dependendo da sua aplicação específica.

A formação de funções visa a determinação de regras de controle de acesso compreensíveis pelo utilizador. O controle de acesso baseado em função pode variar de forma dinâmica e flexível durante o trabalho do sistema de controle de acesso.

A permissão é a menor unidade de direito que o utilizador pode ter. Tu podes verificar se um utilizador tem uma permissão com o nome especificado.

## Utilizador

Na aplicação ORCHID, os utilizadores costumam receber funções, não permissões (embora, tal possibilidade existe). O papel relacionado a um conjunto de permissões em vez de um utilizador individual.

O conceito é fácil de aprender. Geralmente, num processo comercial comum tu geres várias dúzias de permissões. Além disso, tu podes ter desde 10 a 100 utilizador. Embora os utilizador não sejam totalmente particulares, tu podes dividi-los em grupos lógicos de acordo com a forma como lidam com um programa. Estes grupos são chamados de papéis.

A gestão direta do utilizador via permissão de atribuição pode ser cansativo e errado devido à pluralidade de utilizador e permissões.

- Tu podes agrupar uma, duas ou mais permissões nas funções.
- Um utilizador pode ser atribuído com uma ou várias funções.
- Um conjunto de permissões na posse de um utilizador é calculado como a concatenação de permissões de cada função do utilizador.


Um utilizador tem vários sabores de gestão de funções:

```php
// Verifica se o utilizador tem direitos
// A verificação é realizada para o utilizador e seu papel
Auth:user()->hasAccess($string);

// Obtenha todos os papéis do utilizador
Auth::user()->getRoles();

// Verifica se o utilizador tem uma função
Auth::user()->inRole($role)

// Adiciona uma função ao utilizador
Auth::user()->addRole($role)
```

## Funções

As funções também possuem os seguintes procedimentos:

```php
// Retorna todos os utilizadores com a função
$role->getUsers();
```


## Criação da função de administrador

Executa o seguinte comando para criares um utilizador com direitos supremos (no momento da criação):


```php
php artisan make:admin nickname email@email.com secretpassword
```


## Adicionar permissões personalizadas

Tu podes configurar as tuas próprias permissões em aplicativos.
Usando-os tu podes implementar um acesso a funções específicas.

O exemplo de adicionar as permissões personalizadas com o uso do provedor:

```php
use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Kernel\Dashboard;

class PermissionServiceProvider extends ServiceProvider
{
    / **
     * Nagpapahiwatig kapag ang pag-load ng provider ay pinahinto.
     *
     * @var bool
     * /
    protected $defer = false;

    / **
     * @param Dashboard $dashboard
     * /
    public function boot (Dashboard $dashboard)
    {
        $permission = $this->registerPermissions ();
        $dashboard->permission->registerPermissions ($permission);
    }

    protected function registerPermissions ()
    {
        return [
            'Modules' => [
                [
                    'slug' => 'Analytics',
                    'description' => 'Description',
                ],
            ],

        ];
    }
}
```
