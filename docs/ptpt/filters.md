# Filtros
----------


Os filtros servem para simplificar a pesquisa de entradas usando o filtro comum.
Por exemplo, se desejas filtrar o catálogo de produtos por atributos, marcas, etc.
A amostragem de valores baseia-se nos parâmetros dos pedidos http.

Esta não é solução da caixa nem da ferramenta universal, então deves estender a estrutura para as tuas aplicações específicas.

## Criação

Existe um comando para criar um novo filtro:

```php
php artisan make:filter QueryFilter
```

Ele vai criar a classe de filtro na pasta `app/Http/Filters`


Exemplo de filtro:
```php
namespace App\Http\Filters;

use Orchid\Platform\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class QueryFilter extends Filter
{

    /**
     * @var array
     */
    public $parameters = ['query'];

    /**
     * @var bool
     */
    public $display = true;

    /**
     * @var bool
     */
    public $dashboard = false;

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where('demo', $this->request->get('query'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function display()
    {
        return view('simpleFilter',[]);
    }
}
```

Um filtro irá funcionar sujeito à disponibilidade de pelo menos um dos parâmetros especificados numa matriz `$parameters`, se uma matriz estiver vazia, o filtro irá funcionar a cada pedido.

## Usa

Para usar um filtro, precisas especificá-lo numa classe de comportamento.
```php
use Orchid\Behaviors\Many;

class MyBehaviorPost extends Many
{

    /**
     * HTTP data filters
     *
     * @var array
     */
    public function filters(){
        return [
            QueryFilter::class,
        ];
    }
}
```

> **Nota** que podes usar os mesmos filtros para diferentes comportamentos.


A filtração pode ser iniciada pelo método `filtersApply`:
```php
use Orchid\Press\Models\Post;

Post::type('news')->filtersApply()->simplePaginate();
```


Para usares os filtros nos teus próprios modelos, é necessário aplicar `Orchid\Platform\Traits\FilterTrait` trocar e passar para funcionar `filtersApply` variedade de classes:

```php
use App\MyModel;

MyModel::filtersApply([
   Filter::class,
])->simplePaginate();

```
