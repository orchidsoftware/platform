# Comportamentos
----------

O comportamento é a parte principal do sistema de gestão de conteúdo ORCHID. Ao invés de gerar CRUD para cada modelo, tu podes selecionar qualquer objeto sob um tipo separado e gerir-los facilmente.
Os comportamentos são aplicáveis apenas aos modelos 'Post', pois é modelo base para os dados típicos.

Deves descrever os campos que queres e os seus estados, enquanto o CRUD será montado automaticamente.
Também podes especificar uma validação ou módulos. (Consulta a seção Formulários).

![Behaviors](https://orchid.software/img/scheme/behaviors.jpg)

## Criar e registrar comportamentos
        
Sigue este procedimento para criar comportamentos:


```php
//Cria comportamentos para uma única entrada
php artisan make:singleBehavior

//Cria comportamentos para muitas entradas
php artisan make:manyBehavior
```

O comportamento privado deve ser registrado na seção `config/platform.php` na seção de tipos:


```php
//
'single' => [
    //App\Behaviors\Single\DemoPage::class,
],

//
'many' => [
    //App\Behaviors\Many\DemoPost::class,
],
```

> Para mostrar o comportamento do utilizador, tu deves conceder os direitos necessários ao utilizador ou ao grupo (funções) usando a interface visual.

O tipo é o seguinte:

 ```php
namespace DummyNamespace;

use Orchid\Platform\Behaviors\Many;

class DummyClass extends Many
{

    /**
     * @var string
     */
    public $name = '';

    /**
     * @var string
     */
    public $slug = '';

    /**
     * @var string
     */
    public $icon = '';

    /**
     * Slug url /news/{name}.
     * @var string
     */
    public $slugFields = '';

    /**
     * Rules Validation.
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @return array
     */
    public function fields()
    {
        return [];
    }

    /**
     * Grid View for post type.
     */
    public function grid()
    {
        return [];
    }

    /**
     * @return array
     */
    public function modules()
    {
        return [];
    }
}

```

Tu podes ampliar o tipo de dados de todas as maneiras possíveis para adicionar um novo recurso que corresponda ao teu aplicativo.


## Modificação da grade


Tu podes alterar os dados que queres mostrar na grade passando a matriz com nome e função em vez do valor da chave, onde o índice passado é um segmento de dados inicial.

 ```php
 /**
  * Grid View for post type.
  */
 public function grid()
 {
     return [
         TD::name('name')->title('Name'),
         TD::name('publish_at')->title('Date of publication'),
         TD::name('created_at')->title('Date of creation'),
         TD::name('full_name')->title('Full name')
         ->setRender(function($post){
             return  "{$post->getContent('fist_name')} {$post->getContent('last_name')}";
         })
     ];
 }

```
