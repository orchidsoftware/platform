# Contributor Guidelines
----------

I encourage everyone to contribute to the ORCHID project.
You can find the latest version of the GitHub code at <https://github.com/orchidsoftware/platform>.

## Problem Tracking

You can find unresolved issues on the [GitHub Issues Tracker](https://github.com/orchidsoftware/platform/issues).
If you intend to work on a specific issue, leave a comment on the relevant task to inform other project participants.


For active development, it is highly recommended to use only requests for adding changes `(pull requests)`, and not just bug reports.

If you created an error report, it should contain a title and a clear description of the problem.
You should also include as much information and code as possible to help you reproduce the problem.
The main purpose of the error report is to simplify the localization, the reproduction of the problem and the search for its solution.

Also, remember that error reports are created in the hope that other users with the same problems will be able to participate in their decision along with you.
But do not expect others to drop everything and start fixing your problem. The error report is designed to help you and others to start working together to solve the problem.



## Participation in the main discussions

You can suggest new features and improvements to existing ORCHID behavior.
If you are offering a new feature, please be prepared to perform at least the code samples that will be needed to call / use this function.


## Security

If you find a security vulnerability inside ORCHID, please send an e-mail to `bliz48rus(at)gmail.com`.
All such vulnerabilities will be immediately reviewed.




## Code writing style

ORCHID follows [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide-meta.md) and [PSR-4](Https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) standards.


You can use PHP-CS-Fixer to fix your code style before publishing.

To get started, install the tool at the global level and check the code style by running the following command from the terminal of the root directory of your project:

````php
php-cs-fixer fix
````
