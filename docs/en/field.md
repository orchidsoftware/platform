# Fields
----------
Fields are used to generate the output for the form template.

All possible fields are defined in the `config/platform.php` file inside the fields section
Every field may be used in a entity, template or filter. 

Fields and entities are defined separately, that allows us to use only a key 
to access them, for example if we need a `wysiwyg` redactor requested value will be our class. 
This allows to change the `tinymce` to `summernote` or `ckeditor` almost in one click.


> Don't be shy to add custom fields, for example to use a redactor comfortable for you or any component.
 
 
## Input


![Input](https://orchid.software/img/ui/input.png)

Input is one of the most diversed elements of forms that allows you to create different parts of interface and provide interaction with user.
Input is mainly intended to create text fields.
 
An example:
```php
Input::make()
    ->type('text')
    ->name('place')
    ->max(255)
    ->required()
    ->title('Name Articles')
    ->help('Article title');
``` 
 

> Note that a lot of parameters, like max, required, title, help and others, are accessible from almost every `field` of the system and are completely optional
 
 
 
## Wysiwyg


![Wysing](https://orchid.software/img/ui/wysing.png)

A visual redactor which contents are displayed in the process of redaction and look almost like a result.
The redactor allows to add images, tables, define text styles and embed videos.
 
An example:
```php
TinyMCE::make()
    ->name('body')
    ->required()
    ->title('Name Articles')
    ->help('Article title')
    ->theme('inline');
``` 
To display a top panel and a menu, that allows you to view a splash screen and html code, in the redactor, you need to set an attribute `theme('modern')`.
 
## Markdown


![Markdown](https://orchid.software/img/ui/markdown.png)
![Markdown2](https://orchid.software/img/ui/markdown2.png)

Light markup language redactor 
 created to write a maximum human-friendly and easy-to-correct text
  suitable to be transpiled to languages for advanced publications
 
an example:
```php
SimpleMDE::make()
    ->name('body')
    ->title('What would you tell us?');
```  
 
## Picture
 
Allows to upload pictures and cut them to a required format 


An example:
```php
Picture::make()
    ->name('picture')
    ->width(500)
    ->height(300);
```  
           
       
## Datetime
 
 
![Datatime](https://orchid.software/img/ui/datatime.png)
 
Allows to set date and time


An example:
```php
DateTimer::make()
    ->type('text')
    ->name('open')
    ->title('Opening date')
    ->help('The opening event will take place');
```           
           
## Checkbox
 
User graphical interface element that allows a user to control the parameter with two states — ☑ on and ☐ off.


An example:
```php
CheckBox::make()
    ->name('free')
    ->value(1)
    ->title('Free')
    ->placeholder('Event for free')
    ->help('Event for free');
```           

## Code
 
 
![Code](https://orchid.software/img/ui/code.png)
 
A field for a program code with a highligt

An example:
```php
Code::make()
    ->name('block')
    ->title('Code Block')
    ->help('Simple web editor');
```    



## Textarea
 
A `textarea` field is an element of form used to insert several text strings inside it. 
As opposed to `input` tag, it's possible to do a line break there, it will be saved and sent to server.

An example:
```php
TextArea::make()
    ->name('description')
    ->max(255)
    ->rows(5)
    ->required()
    ->title('Short description');
```    


## Tags
 
A notation of several values delimited by comma

An example:
```php
Tags::make()
    ->name('keywords')
    ->title('Keywords')
    ->help('SEO keywords');
```   


## Select

Simple selection from array list:

```php
Select::make()
    ->options([
        'index'   => 'Index',
        'noindex' => 'No index',
    ])
    ->name('select')
    ->title('Select tags')
    ->help('Allow search bots to index');
```


## Mask
 
A mask for data input in `input` tag. 
It's great to use it when a value must be inserted in some standard way, for example when inserting a phone number or TIN

An example:
```php
Input::make()
    ->type('text')
    ->name('phone')
    ->mask('(999) 999-9999')
    ->title('Phone')
    ->help('Number Phone');
```   

A json with parameters may be passed to mask, eg:


```php
Input::make()
    ->type('text')
    ->name('price')
    ->mask([
         'mask' => '999 999 999.99',
         'numericInput' => true
    ])
    ->title('Cost');
```   

```php
Input::make()
    ->type('text')
    ->name('price')
    ->mask([
        'alias' => 'currency',
        'prefix' => ' ',
        'groupSeparator' => ' ',
        'digitsOptional' => true,
    ])
    ->title('Cost');
```   

All available *Inputmask* may be found [here](https://github.com/RobinHerbots/Inputmask#options)


## Entities

Behavior fields may upload a dynamic data which is great if you need connections.

```php
Relationship::make()
    ->name('my_title')
    ->required()
    ->title('My title')
    ->handler(AjaxWidget::class);
```


AjaxWidget will receive a search value inside the `$query` property and the `$key` will  receive a value.


```php
namespace App\Http\Widgets;

use Orchid\Widget\Widget;

class AjaxWidget extends Widget
{

    /**
     * @var null
     */
    public $query = null;

    /**
     * @var null
     */
    public $key = null;

    /**
     * @return array
     */
    public function handler()
    {
        $data = [
            [
                'id'   => 1,
                'text' => 'Post 1',
            ],
            [
                'id'   => 2,
                'text' => 'Post 2',
            ],
            [
                'id'   => 3,
                'text' => 'Post 3',
            ],
        ];


        if(!is_null($this->key)) {
            foreach ($data as $key => $result) {

                if ($result['id'] === intval($this->key)) {
                    return $data[$key];
                }
            }
        }

        return $data;

    }

}

```
