# Participation in development
----------

I appeal to everyone to make a contribution to the ORCHID project. You can find the latest version of the source code at GitHub by <https://github.com/orchidsoftware/platform>.

## Problem tracking

You can find outstanding issues on [GitHub Issues Tracker](https://github.com/orchidsoftware/platform/issues).
If you are going to work on a specific question, please leave a comment on the appropriate task to inform the other project participants.


For active development it is strongly recommended to use pull requests only, instead of bug reports. 

A bug report must contain title and a clear account of a problem. You must also include the information as detailed as possible and the code sample that would help in problem reproducing. The main objective of a bug report is to simplify tracing and reproducing of the problem and search for its solution.

As a reminder, bug reports are designed to let the other users with the same problem have a say in the matter. But it does not mean that the others will rush to your aid. A bug report is intended to help you and other users to start collaboration in problem solving.


## Participation in main discussions

You can offer new functions and enhancements of the ORCHID's current behavior. If you offer a new function, you should be ready to run at least the code samples required for a call/use of the function.

 Non-formal discussions concerning bugs/problems and new possibilities:
  1. [Telegram group @orchid_community](https://t.me/orchid_community)
  1. [Slack group ORCHID](https://lara-orchid.slack.com/messages/C6JJA6X0V/) 

## Security

If you have detected vulnerability within ORCHID, please send an email at `bliz48rus@gmail.com`.
All the appeals will be considered immediately. 


## Code writing style

ORCHID follows [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide-meta.md) and [PSR-4](Https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) standards.


You can use [PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer), to correct your code style before publishing.

To start, install the tool globally and check the code style by running the following command from the root directory terminal of your project:
````bash
php-cs-fixer fix
````



## Debug and sending a pull request.


This section is made for those who want to send a request for the first time if there are questions about debug and install.



### Install

To install the ORCHID package as a developer, laravel framework installation is necessary.

Go to folder and run:

```bash
git clone https://github.com/orchidsoftware/platform.git
```

Add the local repository at `composer.json` of the application:

```php
"repositories": [
    {
        "type": "path",
        "url": "/home/tabuna/orchid/platform"
    }
]
```

And add our package in dependence:

```bash
composer require orchid/platform:@dev
````
Composer will install the package from the storage you have chosen.
The other actions are according to the `Installation` section.

### Sending a pull request

Create a new branch as an example:

```bash
git checkout -b feature/issue_001
```

This will let you understand that the created branch adds a new functionality from the message number 001.


Make changes and fix them:

```bash
git commit -am 'ref #001 [Docs] Fix misprint'
```


To send your branch run the following:
```bash
git push origin feature/issue_001
```


