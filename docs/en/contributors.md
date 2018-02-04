# Participation in development
----------

I encourage everyone to contribute to the ORCHID project. You can find the latest version of the code on GitHub at <https://github.com/orchidsoftware/platform>.

## Problem Tracking

You can find unresolved issues on [GitHub Issues Tracker](https://github.com/orchidsoftware/platform/issues).
 If you intend to work on a specific issue, leave a comment on the relevant task to inform other project participants.
 

For active development, it is highly recommended to use only requests to add `pull requests`, and not just bug reports.

If you created an error report, it should contain the title and a clear description of the problem. You should also include as much information and code as possible to help you reproduce the problem. The main purpose of the error report is to simplify localization, reproduce the problem and find its solution.

Also, remember that error reports are created in the hope that other users with the same problems will be able to participate in their decision along with you. But do not expect others to drop everything and start fixing your problem. The error report is designed to help you and others start working together to solve the problem.


## Participation in the main discussions

You can suggest new features and enhancements to existing ORCHID behavior. If you are offering a new feature, please be prepared to perform at least the code samples that will be needed to call/use this function.

Informal discussion about errors/problems and new opportunities:
 1. [Telegram group @orchid_community](https://t.me/orchid_community)
 1. [Slack group ORCHID](https://lara-orchid.slack.com/messages/C6JJA6X0V/)

## Security

If you find a vulnerability in the security inside ORCHID, please send an e-mail message to the email `bliz48rus @ gmail.com`.
All appeals will be immediately reviewed.


## Code writing style

ORCHID follows [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide-meta.md) and [PSR-4](Https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) standards.


You can use [PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) to fix your code style before publishing.

To get started, install the tool at the global level and check the code style by running the following command from the terminal of the root directory of your project:
```` bash
php-cs-fixer fix
````



## Debugging and sending a change request


At the stage of project assistance, you may have questions related to debugging and installation,
This section was created for those who want to send a request for the first time.


### Installation

To install the ORCHID package as a developer, you need to install the laravel framework.

Go to the directory and run:

```bash
git clone https://github.com/orchidsoftware/platform.git
```

Add a local repository in the composer.json application:

```php
"repositories": [
    {
        "type": "path",
        "url": "/ home/tabuna/orchid/platform"
    }
]
```

And add our package depending:

```bash
composer require orchid/platform: @dev
````
Composer will deliver the package from the repository you specified.
The rest of the actions correspond to the `Setup` section.

### Sending a Change Request

Create a new branch like this:

```bash
git checkout -b feature/issue_001
```

This will almost immediately understand that the created branch adds a new functionality from the message number 001.


Make changes and fix them:

```bash
git commit -am 'ref # 001 [Docs] Fix misprint'
```


To send your branch you need to:
```bash
git push origin feature/issue_001
```
