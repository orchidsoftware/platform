# Mga Kinakailangan ng Sistema
----------

Ang manwal na ito ay naglalaman ng detalyadong mga kinakailangan ng sistema para sa instalasyon


## Mga Kinakailangan sa Browser

Pang-administrasyong panel (walang karagdagang mga modyul),
Kompatibol at lubos na functional sa lahat ng mga modernong browser,
na sinusuportahan ang CSS at JavaScript (menor na mga pagbabago ng mukha ay posible).

- Microsoft Edge
- Firefox
- Opera
- Safari
- Google Chrome

Ang panlabas ay itinayo sa pinakasikat na istraktura ng `Bootstrap`. Ang inirerekomendang resolusyon ng screen ay 1920 × 1080 (Buong HD)


## Database na Server

### MySQL

Kinakailangang bersyon ng MySQL na 5.7.8 o mas mataas pa kasama ang InnoDB bilang pangunahing imbakang makina
, nangangailangan rin ng pagpapalawak ng database ng PDO.

### PostgreSQL
Nangangailangan ng PostgreSQL 9.3 o mas bago pa.


### Mariadb
Nangangailangan ng Mariadb 10.3.2 o mas bago pa.

### Iba pang mga database na server
Ang ilan ay inilaang hindi lalayo mula sa code na natitiyak sa MySQL/PostgreSQL,
gaya ng gusto natin sa lahat. Ang pagpapatakbo at paggamit sa ibang mga server ay posible, pero pwedeng kailangang
baguhin ang takbo ng ilang mga function.

## PHP

Ang ORCHID ay nangangailangan ng hindi baba sa PHP `7.1.3` upang magpatakbo nang magpatakbo. Kailangan mo rin ng mga sumusunod na ekstensyon:

- OpenSSL na Ekstensyon ng PHP
- PDO na Ekstensyon ng PHP
- Mbstring na Ekstensyon ng PHP
- Tokenizer na Ekstensyon ng PHP
- XML na Ekstensyon ng PHP
- Ctype na Ekstensyon ng PHP
- JSON na Ekstensyon ng PHP
- PHP GD na Ekstensyon

## Web na server

Ang ORCHID ay gumagana sa kahit anong web na server na may bersyon ng PHP na `7.0` o mas mataas pa.

Maraming mga tagabigay ng hosting ang nag-aalok ng opsyong pumili ng bersyon ng PHP.
Ang naka-default na bersyong PHP ay maaaring mas mababa pa sa 7.0, kaya tingnan ang kontrol na panel ng iyong host,
upang malaman kung aling bersyon ng PHP ang kasalukuyang sinusuportahan, at baguhin ito upang matumbasan ang mga kinakailangan.

Kung gusto mong lumikha at bumuo ng mga ORCHID na sayt sa iyong kompyuter, pwede mong lokal na i-install lahat ng iyong mga kinakailangan.


### Ang Apache
     
Sa Laravel may isang file na `public/.htaccess`, na ginagamit sa pagpapakita ng mga link nang hindi tinutukoy
ang harapang tagakontrol na `index.php` sa hinihinging address.
Bago mo simulan ang Laravel gamit ang Apache na server, siguraduhing ang modyul na `mod_rewrite` ay gumagana,
mahalaga ito para sa tamang pagproseso ng .htaccess na file.
     
Kung ang file na `.htaccess` na ibinigay ng Laravel ay hindi gumagana sa iyong Apache na server, subukan ang alternatibong ito:

```php
Options + FollowSymLinks
RewriteEngine On

RewriteCond% {REQUEST_FILENAME}! -d
RewriteCond% {REQUEST_FILENAME}! -f
RewriteRule ^ index.php [L]
```


### Ang Nginx

Kung ginagamit mo ang Nginx, ang susunod na direktiba sa konpigurasyon ng iyong sayt
ay magpapadala sa lahat ng mga kahilingan sa harapang tagakontrol na `index.php`:

```php
location/{
    try_files $uri $uri//index.php?$query_string;
}
```


### Naka-built-in na PHP web server (para sa pagbubuo lamang)

Ang naka-embed na PHP web server ay isinali bilang CLI na kagamitan sa bersyong PHP na 5.4.0 o mas bago pa.

Ang PHP na web server ay dinisenyo upang tumulong sa pagbubuo ng mga aplikasyon.
Magiging mahalaga ito para sa pagsusuri at paglalahad ng mga aplikasyon,
na pinapatakbo sa kinokontrol na mga kapaligiran.
Hindi ito para sa isang lubos na naitampok na web server,
kaya hindi dapat ito ginagamit bilang produksyon na server para sa pampublikong silbi.
