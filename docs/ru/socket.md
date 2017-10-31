
# Socket
----------

WebSocket — протокол полнодуплексной связи поверх TCP-соединения, предназначенный для обмена сообщениями между браузером и веб-сервером в режиме реального времени.

WebSocket разработан для воплощения в web-браузерах и web-серверах, но он может быть использован для любого клиентского или серверного приложения.

Протокол WebSocket - это независимый протокол, основанный на протоколе TCP. Он делает возможным более тесное взаимодействие между браузером и web сайтом, способствуя распространению интерактивного содержимого и созданию игр реального времени.

## Установка

Для установки используется пакетный менежер

```php
$ composer require orchid/socket
```

Добавьте сервис провадер в ваш `config/app.php`:

```php
Orchid\Socket\Providers\SocketServiceProvider::class
```

Опубликовать настройки

```php
php artisan vendor:publish
```


## Использование
----------

### Создание :
	
Чтобы создать новый слушатель, необходимо выполнить
```php
php artisan make:socket MyNameClass
```

В папке  `app/HTTP/Socket/Listener` создаться шаблон веб-сокета.

После создания необходимо установить маршрут который распологается  `routes/socket.php`

```php
//Основу маршрутизации составляет Symfony Routing Component
$socket->route('/myclass', new MyClass, ['*']);
```

Для запуска веб-сокета используйте команду:
```php
php artisan socket:serve
```

### Частые вопросы
----------


#### JavaScript
Подключение веб-сокета на JavaScript

```javascript
var socket = new WebSocket("ws://localhost");

socket.onopen = function() {
  alert("The connection is established.");
};

socket.onclose = function(event) {
  if (event.wasClean) {
    alert('Connection closed cleanly');
  } else {
    alert('Broken connections'); 
  }
  alert('Key: ' + event.code + ' cause: ' + event.reason);
};

socket.onmessage = function(event) {
  alert("The data " + event.data);
};

socket.onerror = function(error) {
  alert("Error " + error.message);
};


//To send data using the method socket.send(data).

//For example, the line:
socket.send("Hello");

```


#### Authorization
Пример установки уникальных номеров сокета и сессии laravel
```php

public function onOpen(ConnectionInterface $conn)
{
    $this->clients->attach($conn);
    
    //take user id
    $userId = $this->getUserFromSession($conn);
    
    //Create a list of users connected to the server
    array_push($this->userList, $userId);
    
    //We tell everything that happened
    echo "New connection! user_id = ({$userId})\n";
}

public function getUserFromSession($conn)
{
    // Create a new session handler for this client
    $session = (new SessionManager(App::getInstance()))->driver();
    
    // Get the cookies
    $cookies = $conn->WebSocket->request->getCookies();
    
    // Get the laravel's one
    $laravelCookie = urldecode($cookies[Config::get('session.cookie')]);
    
    // get the user session id from it
    $idSession = Crypt::decrypt($laravelCookie);
    
    // Set the session id to the session handler
    $session->setId($idSession);
    
    // Bind the session handler to the client connection
    $conn->session = $session;
    $conn->session->start();
    
    //We take the user from a session
    $userId = $conn->session->get(Auth::getName());
    return $userId;
}

```


####Nginx proxy

```php
map $http_upgrade $connection_upgrade {
    default upgrade;
    '' close;
}

upstream websocket {
    server you-web-site.com:5300;
}

server {
    listen 443;
    location / {
        proxy_pass http://websocket;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection $connection_upgrade;


            proxy_set_header Host $host;
            proxy_set_header X-Real-IP $remote_addr;
            proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
            proxy_set_header X-Forwarded-Proto https;
        proxy_redirect off;
    }
}
```


####Supervisor

```php
[program:laravel-socket]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/your-path/artisan socket:serve
autostart=true
autorestart=true
user=root
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/your-path/storage/logs/socket.log
```
