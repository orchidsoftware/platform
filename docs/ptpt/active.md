# Links ativos
----------

Os links ativos são o pacote de suporte que permite definir facilmente o endereço atual (URL) ou rota que é muito útil no caso de o atributo de navegação "ativo" precisar de ser adicionado (por exemplo, em uso com o Bootstrap) e para ações que são aplicáveis somente quando a rota particular está ativa.

Também inclui um assistente que fornece informações sobre os nomes atuais do controlador e da ação.

## Funções auxiliares

Links ativos com várias funções auxiliares que simplificam o uso sem uma fachada.
```php
active()
is_active()
```

## O uso de `ativo()`

Tu passas por uma série de rotas ou URLs que queres ver como a página principal e se houver alguma correspondência, uma sequência `ativa` será retornada ao Bootstrap. Além disso, tu podes passar a sequência de retorno do utilizador como o segundo argumento.

```php
// Retorna «ativo» se a rota atual corresponder a qualquer rota ou endereço do recurso.
active('login', 'users/*', 'posts.*', 'pages.contact'); 

// Retorna a «classe ativa» se a rota atual for «login» ou «logout».
active(['login', 'logout'], 'active-class'); 
```

No primeiro exemplo, a função retornará `ativo' se a rota atual de `login` começar com `users/` ou se a rota atual for `posts.create`.

Presta atenção a uma lista fornecida de diferentes tipos de argumento: tu podes usar uma string de URL, uma string de URL de asterisco (*) e também podes usar as rotas nomeadas.

Tu podes usar esta função com os teus links para fornecer o estado `ativo' para eles.

```php
<a href="{{ route('posts.index') }}" class="{{ active('posts.index') }}">
    All posts
</a>
```

Tu também podes especificar as rotas ou endereços específicos que devem ser verificados.
```php
active(['pages/*', 'not:pages/contact'])

active(['pages.*', 'not:pages.contact'])
```

## O uso de `está_ativo()`

Este funciona como `ativo()`: tu podes passar para ele as rotas e os endereços, mas em vez disto retorna p valor booleano se a página atual corresponder à regra ou não:

```php
@if (is_active('posts/*'))
    You're looking at a blog post!
@endif
```

## Assistentes adicionais

Se o teu roteamento for executado por um controlador de solicitação, existem duas funções que permitem definir o controlador atual e as ações disponíveis.
Estas funções retornarão o nome do controlador sem o método de solicitação.
Abaixo está o exemplo de solicitação redirecionada para `FooController@getBar':
```php
$controller = controller_name(); // foo

$action = action_name(); // bar
```
