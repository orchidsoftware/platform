# Autenticação
----------


## Guia de autenticação rápida

Na configuração ORCHID instalada, a página de autenticação dos utilizadores já está no endereço `/dashboard/login`.

No decorrer da instalação, tu herdaste o modelo em `app/User.php` para poderes expandir um modelo de autenticação e entretanto, para defini-lo para o Laravel.
(Procura no arquivo de configuração `config/auth.php`).



## Modificação

A autenticação usa o formulário padrão do login Laravel que requer apenas dois parâmetros `E-mail` e` Senha`. Em aplicações reais, pode ser necessária mais flexibilidade no caso de usares `ldap` ou autenticação através das redes sociais. Então tu deves criar a tua própria página que podes modificar.
 
Primeiro, para desligar a nossa página de autenticação integrada, alteramos o valor `display` no arquivo de configuração:

```php
'auth' => [
    'display' => false,
],
```
 

Então, usamos o comando incorporado Laravel para criar todas as rotas e modelos necessários:

```php
php artisan orchid:auth
```

Nós adicionamos o middleware `auth` à nossa configuração da plataforma `config/platform.php` para permitir redirecionamentos corretos.
Presta atenção que este valor deve ser definido antes do `painel de controle'
```php
    'middleware' => [
        'public'  => ['web'],
        'private' => ['web', 'auth', 'dashboard'],
    ],
```
