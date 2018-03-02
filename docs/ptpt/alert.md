# Notificações
----------

Notificações é uma maneira simples de informar um utilizador sobre o estado da tua aplicação. Por exemplo, a notificação pode informar um utilizador de acabamento longo ou uma nova mensagem. Nesta seção, mostraremos como fazê-lo funcionar na tua aplicação.

## Notificação flash:

Notificação flash é uma notificação descartável que será excluída no próximo recurso. As notificações são para informar sobre o evento aconteceu diretamente, por exemplo, mensagem sobre económia de dados.


```php
public function store()
{
    Alert::message('Welcome Aboard!');
    return Redirect::home();
}
```

Tu também podes desta forma:

```php
Alert::info('Message')
Alert::success('Message')
Alert::error('Message')
Alert::warning('Message')
```

ou use uma notação mais curta:

```php
alert('Message');
```


Depois disso, haverá várias chaves instaladas numa sessão:
- 'flash_notification.message' - Mensagem a ser exibida
- 'flash_notification.level' - String que representa o tipo de notificação

Para exibir num local particular, pode ser usado o seguinte:
```html
<div class="container">
    @include('dashboard::partials.alert')
    <p>Welcome to my website...</p>
</div>
```

## Notificações do painel de controle

As notificações do painel de controle diferem das mensagens flash no fato de que elas não desaparecem após a exibição e podem ser adicionadas a qualquer utilizador, mesmo que estejam off-line. Esta é outra boa maneira de informar, por exemplo, notificar um associado sobre nova tarefa no aplicativo "gestor de tarefas".

Tu precisas de fazer o seguinte para criar uma notificação:
```php
$user = User::find(1);

$user->notify(new \Orchid\Platform\Notifications\DashboardNotification([
    'title' => 'Hello Word',
    'message' => 'New post!',
    'action' => 'https://google.com',
    'type' => 'error',
]));
```

Tipos permitidos:

- informações (por padrão)
- sucesso
- atenção
- erro
