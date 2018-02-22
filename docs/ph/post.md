#Mga Lathala
----------
Nagbabaka-sakali ang plataporma na sa default, ang kahit anong elemento na naglalaman ng datos ng sayt ay isang `Lathala` na modelo.

Kaya ngayon, makakakuha ka na ng database na datos:

```php
use Orchid\Platform\Core\Models\Post;

$posts = Post::all();
```

```php
//Lahat ng mga nai-publish na lathala
$posts = Post::published()->get();
$posts = Post::status('publish')->get();

//Isang tiyak na post
$post = Post::find(42);

//Pangalan ng tala na naglalaman ng kasalukuyang lokalisasyon
echo $post->getContent('name');

```


### Isahang Talahanayan na Inheritance

Kapag pinili mong gumawa ng isang bagong class para sa iyong karaniwang uri ng lathala, maibabalik mo ang klaseng ito para sa lahat ng mga instance ng ganoong uri ng lathala.

Ang ibig sabihin ng paggalaw ng isang tala ay nakabase sa tinitiyak na `uri`.
```php
//Lahat ng uri sa $videos na koleksyon ay magiging instance ng Lathala
$videos = Post::type('video')->status('publish')->get();
```


### Taksonomiya

Makakakuha ka ng mga taksonomiya para sa mga partikular na lathala katulad ng:

```php
$post = Post::find(42);
$taxonomy = $post->taxonomies()->first();
echo $taxonomy->taxonomy;
```

O makakahanap ka ng mga lathala na gumagamit ng mga taksonomiya nito:

```php
$post = Post::taxonomy('category', 'php')->first();
```

### Mga Kategorya at Mga Taksonomiya

Kumuha ng isang kategorya o taxonomiya o i-load ang mga lathala mula sa isang tiyak na kategorya. May maraming mga paraan
upang makamit ito.


```php
//lahat ng mga kategorya
$category = Taxonomy::category()->slug('uncategorized')->posts()->first();


//Lahat lamang ng mga kategorya at lathala na konektado nito
$category = Taxonomy::where('taxonomy', 'category')->with('posts')->get();
$category->each(function($category) {
    echo $category->getContent('name');
});

//lahat ng malinis at simpleng mga lathala mula sa isang kategorya
$category = Category::slug('uncategorized')->posts()->first();
$category->posts->each(function($post) {
    echo $post->getContent('name');
});
```

### Mga Ilalakip

Ang mga Ilalakip ay mga file na may kaugnayan sa isang talaan.
Ang mga file na ito ay maaaring nasa iba't-ibang mga format at resolusyon mula sa talaan.


```php
$item = Post::find(42);
$item->attachment('image')->get();
```

Ang mga na-upload na imahe ay awtomatikong naitakda sa mga pahintulot na itiniyak sa `config/platform`.
Upang tawagin sila, magagamit mo ang naitakda nang key.
Kung ang imahe para sa key na ito ay hindi matagpuan, ang orihinal na file ay ibabalik.

```php
$image = $item->attachment('image')->fisrt();

//Ibinabalik ang pampublikong address ng imahe kasama ang resolusyong set
$image->url('standard');
```
