# Entities
----------

Ang paggalaw ay ang pangunahing bahagi ng pangnilalamang sistema ng pamamahala ng ORCHID, sa halip na paglikha ng CRUD para sa bawat modelo
Makakapili ka ng kahit anong bagay sa isang hiwalay na uri, at madali lang itong pamahalaan. Ang mga paggalaw ay naaaplay lamang sa
mga modelo na nakabase sa 'Post', dahil ito ang basehan sa karaniwang mga datos.

Kailangan mong ilarawan ang mga field na gusto mong matanggap at kung anong anyo, at ang CRUD nito ay ginawa nito mismo.
Makakatakda ka rin ng mga pagpapatunay, o mga modyul (Tingnan ang seksyon ng anyo).

![Mga Paggalaw](https://orchid.software/img/scheme/entities.jpg)

## Paglilikha at pagtatala ng mga paggalaw


Makakalikha ka ng mga paggalaw gamit ang mga sumusunod na mga utos:

```php
//Lumilikha ng mga galaw sa isang tala
php artisan orchid: singleBehavior

//Lumilikha ng mga galaw sa maraming mga tala
php artisan orchid: manyBehavior
```

Ang sariling paggalaw ay dapat nakarehistro sa `config/platform.php` sa uring seksyon


```php
//
'single' => [
    //Orchid\Press\Entities\Single\DemoPage::class,
],

//
'many' => [
    //Orchid\Press\Entities\Many\DemoPost::class,
],
```

> Upang ipakita ang paggalaw ng gumagamit, kailangang bigyan ito
o mga grupo ng mga kinakailangang karapatan gamit ang grapikal na interface

Ang uri ay nagmumukhang ganito:

```php
namespace DummyNamespace;

use Orchid\Press\Entities\Many;

class DummyClass extends Many
{

    / **
     * @var string
     * /
    public $name = '';

    / **
     * @var string
     * /
    public $slug = '';

    / **
     * @var string
     * /
    public $icon = '';

    / **
     * Slug url/news/{name}.
     * @var string
     * /
    public $slugFields = '';

    / **
     * Rules Validation.
     * @return array
     * /
    public function rules ()
    {
        return [];
    }

    / **
     * @return array
     * /
    public function fields ()
    {
        return [];
    }

    / **
     * Grid View para sa uri ng lathala.
     * /
    public function grid ()
    {
        return [];
    }

    / **
     * @return array
     * /
    public function modules ()
    {
        return [];
    }
}

```

Maaari mong i-extend ang uri ng datos gamit ang lahat ng pwedeng pamamaraan,
 Upang idagdag ito sa bagong functionality na tumutugma sa iyong aplikasyon

 
Pagbabago sa Grid
 

Ang datos na gusto mong ipakita sa grid ay maaaring baguhin,
 pagpasa ng isang hanay na may pangalan at function sa halip ng halaga ng key,
  kung saan ang nailipat na parametro ay ang orihinal na piraso ng datos.

 ```php
 / **
  * Grid View para sa uri ng lathala.
  * /
 public function grid ()
 {
     return [
         'name' => 'Pangalan',
         'publish_at' => 'Petsa ng Paglathala',
         'created_at' => 'Petsa ng Paggawa',
         'full_name' => => [
             'name' => 'Buong pangalan',
             'action' => function ($post) {
                 return $post->getContent ('fist_name')
                  . ' '.
                  $post->getContent ('last_name');
             }
         ],
     ];
 }

```
