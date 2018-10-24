# Partisipasyon sa pagbubuo
----------

Hinihimok namin ang lahat na mag-ambag sa proyektong ORCHID. Mahahanap mo ang pinakabagong bersyon ng kodigo sa GitHub sa <https://github.com/orchidsoftware/platform>.

## Pagsubaybay sa problema

Makikita mo ang hindi naresolbang mga isyu sa [GitHub Issues Tracker](https://github.com/orchidsoftware/platform/issues).
 Kung nais mong magtrabaho sa isang tiyak na isyu, mag-iwan ng komento sa nauugnay gawain upang ipaalam sa ibang mga kasali sa proyekto.
 

Para sa aktibong pagbubuo, lubos na inirerekomenda na gamitin lamang ang mga kahilingan sa pagdagdag ng mga `pull request`, at hindi lamang mga ulat ukol sa bug.

Kapag lumikha ka ng isang ulat ukol sa kamalian, dapat naglalaman ito ng titulo at klarong paglalarawan sa problema. Dapat ring isali mo ang mga impormasyon at code upang tulungan kang isulat muli ang problema. Ang pangunahing layunin ng ulat ukol sa kamalian ay ang padaliin ang lokalisasyon, isulat muli ang problema at hanapin ang kanyang solusyon.

Tandaan din na ang mga ulat sa kamalian ay nilikha sa pag-asang ang ibang mga tagagamit na may parehong problema ay makakasali sa kanilang desisyon kasama ka. Pero huwag umasa sa iba na ihulog lahat at simulang ayusin ang iyong problema. Ang ulat sa kamalian ay dinisenyo upang tulungan at iba pa na simulang magtutulungan upang lutasin ang problema.


## Partisipasyon sa mga pangunahing diskusyon

Makakapagmungkahi ka ng mga bagong katangian at paglilinang sa kasalukuyang paggalaw ng ORCHID. Kapag nag-aalok ka ng bagong katangian, mangyaring maging handa na gawin ang mga halimbawa ng code na kakailanganin upang tawagin/gamitin ang function na ito.

Impormal na diskusyon tungkol sa mga kamalian/problema at mga bagong oportunidad:
 1. [Telegram group @orchid_community](https://t.me/orchid_community)
 1. [Slack group ORCHID](https://lara-orchid.slack.com/messages/C6JJA6X0V/)

## Seguridad

Kapag nakakakita ka ng kahinaan sa seguridad sa loob ng ORCHID, mangyaring magpadala ng isang e-mail na mensahe sa email na `bliz48rus @ gmail.com`.
Ang lahat ng mga mungkahi ay madaliang ire-review.


## Istilo ng pagsulat ng code

Sinusunod ng ORCHID ang [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide-meta.md) at [PSR-4](Https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) na mga istandard.


Pwede mong gamitin ang [PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) upang ayusin ang istilo ng iyong code bago ang paglalathala.

Upang makapagsimula, i-install ang kagamitan sa pangkalahatang antas at suriin ang istilo ng code sa pamamagitan ng pagpapagana ng sumusunod na utos mula sa terminal ng ugat na direktoryo ng iyong proyekto:
```` bash
php-cs-fixer fix
````



## Pagde-debug at pagpapadala ng isang kahilingan sa pagbabago


Sa yugto ng pagtutulong sa proyekto, baka may mga tanong ka tungkol sa pagde-debug at instalasyon,
Ang seksyong ito ay nilikha para sa gustong magpadala ng kahilingan sa unang pagkakataon.


### Instalasyon

Upang i-install ang ORCHID na pakete bilang isang tagabuo, kailangan mong i-install ang laravel framework.

Pumunta sa direktoryo at paganahin ang:

```bash
git clone https://github.com/orchidsoftware/platform.git
```

Magdagdag ng isang lokal na repositori sa composer.json na aplikasyon:

```php
"repositories": [
    {
        "type": "path",
        "url": "./platform"
    }
]
```

At idagdag ang ating pakete sa pagdedepende:

```bash
composer require orchid/platform: @dev
````
Ang may-akda ay magpapadala sa pakete mula sa repositori na iyong naitakda.
Ang iba pa sa mga aksyon ay tumutumbas sa `Setup` na seksyon.

### Pagpapadala ng isang Kahilingan sa Pagbabago

Maglikha ng isang sanga katulad nito:

```bash
git checkout -b feature/issue_001
```

Muntik nitong madaliang intindihin na ang nalikhang sanga ay nagdadagdag ng isang bagong functionality mula sa mensaheng numero 001.


Gumawa ng mga pagbabago at ayusin ang mga ito:

```bash
git commit -am 'ref # 001 [Docs] Fix misprint'
```


Upang ipadala ang iyong sanga, kailangan mong:
```bash
git push origin feature/issue_001
```
