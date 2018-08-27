# Arquivo de configuração
----------

O ORCHID usa o sistema de configuração padrão Laravel.
Todos os parâmetros podem ser encontrados no diretório `config`, e o arquivo `platform.php` é o principal para a plataforma. Cada configuração é sugerida com comentários que somam a sua essência.

## Endereço da plataforma

```php
'domain' => env('DASHBOARD_DOMAIN', parse_url(config('app.url'))['host']),
```

O endereço do painel desempenha um papel importante para muitos projetos.
Por exemplo, um aplicativo pode estar no endereço `example.com` e um painel de controle encontra-se em `admin.example.com` ou mesmo num domínio externo.

Para executares isto, precisas definir qual o endereço deve ser acedido para o abrir.

```php
'domain' => 'admin.example.com',
```

Lembra-te de que os parâmetros do teu servidor web devem estar devidamente configurados.




## Prefixo da plataforma


```php
'prefix' => env('DASHBOARD_PREFIX', 'dashboard'),
```

O sistema instalado no site pode ser facilmente definido pelo prefixo do painel, por exemplo, é `wp-admin` para o WordPress, e dá a oportunidade de procurar automaticamente as versões antigas de software vulneráveis e obter controle sobre ela.
 
Há outros motivos, mas não falaremos sobre eles nesta seção.
O ponto é que o ORCHID permite alterar o prefixo 'painel de controlo` para todos os outros nomes, `admin` ou `administrator` por exemplo.



## Middlewares

```php
'middleware' => [
    'public'  => ['web'],
    'private' => ['web', 'dashboard'],
],
```

Tu podes adicionar ou excluir middlewares de interface gráfica.
Neste momento, existem dois tipos de middlewares:  `público`, para o qual o utilizador não autorizado pode aceder, por exemplo, pode ser a página de `Login` ou `Recuperação de senha` e `privado`, que pode ser acedido apenas por utilizadores autorizados.


Tu podes adicionar tantos novos middlewares quanto quiseres, como um exemplo do middleware para a filtragem da lista de permissões IP.



## Página de autorização

```php
'auth' => [
    'display' => true,
    'image'   => '/orchid/img/background.jpg',
    //'slogan'  => '',
],
```

A página de autorização possui várias configurações como a imagem de fundo e a lema do projeto.
Além disto, existe a capacidade de desativar completamente o formulário de autorização incorporado e implementar o teu próprio com o seguinte comando:

```php
php artisan orchid:auth
```



## Localização postal

```php
'locales' => [
    'en' => [
        'name'     => 'English',
        'script'   => 'Latn',
        'dir'      => 'ltr',
        'native'   => 'English',
        'regional' => 'en_GB',
    ],
],
```

As entradas genéricas criadas com o sistema de `comportamento` podem ser localizadas, significa que tu podes criar as mesmas entradas em diferentes idiomas; para adicionares um novo idioma, só precisas adicionar um novo elemento à matriz.



## Campos

```php
'fields' => [
    'textarea'     => Orchid\Screen\Fields\Types\TextAreaField::class,
    'input'        => Orchid\Screen\Fields\Types\InputField::class,
    'list'         => Orchid\Screen\Fields\Types\ListField::class,
    'tags'         => Orchid\Screen\Fields\Types\TagsField::class,
    'robot'        => Orchid\Screen\Fields\Types\RobotField::class,
    'relationship' => Orchid\Screen\Fields\Types\RelationshipField::class,
    'place'        => Orchid\Screen\Fields\Types\PlaceField::class,
    'picture'      => Orchid\Screen\Fields\Types\PictureField::class,
    'datetime'     => Orchid\Screen\Fields\Types\DateTimerField::class,
    'checkbox'     => Orchid\Screen\Fields\Types\CheckBoxField::class,
    'code'         => Orchid\Screen\Fields\Types\CodeField::class,
    'wysiwyg'      => Orchid\Screen\Fields\Types\TinyMCEField::class,
    'password'     => Orchid\Screen\Fields\Types\PasswordField::class,
    'markdown'     => Orchid\Screen\Fields\Types\SimpleMDEField::class,
],
```

Nos aliases de campo de configuração de campo são usados para abstrair de elementos usados, por exemplo, `wysiwyg` é um alias para o redactor TinyMCEField. Se chegaste a decidir que a funcionalidade do redactor que tu usas não é suficiente, só precisarás mudar o seu alias para os outros, em vez de mudares o teu nome completo em todos os arquivos do teu projeto.

[Mais sobre Campos](/en/docs/field/)


## Comportamentos individuais

```php
'single' => [
    Orchid\Press\Entities\Single\DemoPage::class,
],
```

Os comportamentos individuais são o tipo de comportamento que existe apenas num exemplar.
É uma ótima solução para a criação de páginas de sites únicas (Não genéricas!).


## `Muitos` comportamentos 


```php
'many' => [
    Orchid\Press\Entities\Many\DemoPage::class,
],
```

Muitos comportamentos são usados para reduzir o tempo gasto na criação de dados genéricos com múltiplas entradas.
Por exemplo, se precisas de criar algum tipo de catálogos ou livros de referência que tenham os mesmos dados neles.


## Comportamentos padrão

```php
'common' => [
    'user'     => Orchid\Platform\Entities\Base\UserBase::class,
    'category' => Orchid\Press\CategoryBase::class,
],
```

A plataforma é fornecida com um conjunto básico de comandos CRUD como a criação de utilizadores; para alterar ou adicionar novos campos de entrada, as classes padrão devem ser alteradas.

## Menu de utilizadores

```php
'menu' => [
    'header'  => 'Header menu',
    'sidebar' => 'Sidebar menu',
    'footer'  => 'Footer menu',
],
```

A configuração do menu requer apenas a chave e valor que serão mostrados ao utilizador.
Por padrão, existem três tipos de menus: superior, lateral e inferior.
Tu podes adicioná-los ou excluí-los se precisares.

Podes ver um exemplo de uso do menu [lá](/en/docs/tutorial_blog/#vidzhet).

## Imagens

```php
'images' => [
    'low'    => [
        'width'   => '50',
        'height'  => '50',
        'quality' => '50',
    ],
    'medium' => [
        'width'   => '600',
        'height'  => '300',
        'quality' => '75',
    ],
    'high'   => [
        'width'   => '1000',
        'height'  => '500',
        'quality' => '95',
    ],
],
```

Anexos podem processar imagens criando cópias do formato requerido.


## Tipos de anexos

```php
'attachment' => [
    'image' => [
        'png',
        'jpg',
        'jpeg',
        'gif',
    ],
    'video' => [
        'mp4',
        'mkv',
    ],
    'docs'  => [
        'doc',
        'docx',
        'pdf',
        'xls',
        'xlsx',
        'xml',
        'txt',
        'zip',
        'rar',
        'svg',
        'ppt',
        'pptx',
    ],
],
```

Os anexos também podem ser agrupados, o que pode ser útil, por exemplo, se forem necessários apenas documentos ou vídeos.

## Widgets do painel

```php
'main_widgets' => [
    Orchid\Platform\Http\Widgets\UpdateWidget::class,
],
```

A página do painel principal por padrão tem apenas um widget informando sobre a nova versão do software estável. O ORCHID não é criado para resolver problemas individuais por isso não pode fornecer nenhum tipo de métrica (por exemplo, sobre a quantidade de postagens criadas ou visitas de utilizadores)

Podes criar e adicionar qualquer widget que quiseres visualizar. Veja a seção "Widgets" para encontrar mais sobre o assunto.


## Recursos do painel


```php
'resource' => [
    'stylesheets' => [],
    'scripts'     => [],
],
```

Durante o teu trabalho, irás precisar de adicionar as tuas próprias tabelas de estilo ou cenários globais de javascript para todas as páginas, então precisas adicioná-las às matrizes relevantes.
