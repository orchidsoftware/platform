# Mga Setting
----------

Mga Setting - ang imbakang ito ng key-value ay ang pinakasimpleng imbakan ng datos na gumagamit ng key upang ma-access ang halaga. Ang mga repositoring ito ay ginagamit sa pag-iipon ng mga setting, paglilikha ng mga natatanging mga sistema ng file, bilang mga cache para sa mga bagay, pati na rin sa mga sistemang dinisenyo para sa iskalabilidad.

## Karagdagan

Tandaan na maaari kang maglagay sa repositori ng hindi lamang mga variable ng simpleng uri kundi pati na rin mga hanay. Sa repositori, ang mga hanay ay isasalin sa JSON at kapag ang halaga ay natanggap, ide-decode ito.

Upang magdagdag ng bagong halaga sa repositori, dapat gamitin mo ang:
```php
use Orchid\Platform\Facades\Setting;

...

Setting::set($key,$value);
```

## Pagkukuha

Upang makuha ang halaga:
```php
/ **
* @param string | array $key
* @param string | null $default
* /
$value = Setting::get($key);
//or with default value
$value = Setting::get($key, $default);
//or helper
setting($key,$default);
```

## Removing

Upang alisin ang halaga:
```php
/ **
* @param string | array $key
* @param string | null $default
* /
Setting::forget ($key);
```



Tandaan na makakakuha o makakatanggal ka ng maraming mga halaga ​​mula sa repositori nang sabayan. Para rito, kailangan mong magpasa ng isang hanay na may mga pangalan ng mga key sa unang argumento.

Sa default, ang bawat elemento ay naka-cache bago ito binago. Sa mga kaso kung saan kailangan mong kumuha ng isang halaga hindi mula sa cache, kailangan mong gamitin ang "getNoCache"
```php
Setting::getNoCache ($key, $default = null);
```
