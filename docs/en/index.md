# Documentation
----------

## Welcome

This guide provides background information and covers the most important topics for developing business applications using the ORCHID platform.

The platform requires knowledge of the following technologies:
- PHP/JavaScript/HTML/CSS
- Relational databases
- Apache/nginx
- Laravel Framework


> To suggest improvements to this guide, create a new [issue](https://github.com/orchidsoftware/platform/issues).
In case of errors in the documentation, please indicate the chapter and the accompanying text to indicate the error.


Before installing and using, we recommend getting general information about what tasks the platform is solving. This little waste of time can help you in the long run.


## Introduction

ORCHID is a tool for [RAD](https://ru.wikipedia.org/wiki/RAD_ (% D0% BF% D1% 80% D0% BE% D0% B3% D1% 80% D0% B0% D0% BC% D0% BC% D0% B8% D1% 80% D0% BE% D0% B2% D0% B0% D0% BD% D0% B8% D0% B5)) development of websites and linear business applications.
Supplied as a package for Laravel and easily integrated with Composer, it
 Also works well with other PHP components.
 You can register additional third-party components for Laravel or found in [Packagist](https://packagist.org/).

Most business applications are of the "form over data" type and provide a user interface for viewing, adding, and modifying data.
When you use other development tools to create applications such as "forms over data", a significant amount of time is spent performing repetitive tasks.
You write code for interaction with the database, code for the user interface and code for business logic.
 
Using ORCHID saves you from many repetitive tasks, you only need to write one type of code - business logic.


## How to read the documentation

If you are a beginner, I recommend that you read the documentation "Laravel" from beginning to end, for example, on [laravel.su](http://laravel.su/docs).
The ORCHID documentation does not explain the capabilities of the framework. If you are already familiar with it, you can go on to read the following chapters.

This documentation begins with an explanation of the concept and architecture of ORCHID, before delving into specific topics.


## Features for Business Applications

Modern business applications require many features, for example: searching, sorting and reordering grids, and exporting data.
All these and many other features are already built into ORCHID applications. In addition, typical data operations, such as adding, updating, saving and deleting, are also built in as a basic data validation logic.

Using custom controls and extensions, you can use customizable field types to reduce the amount of code created and simplify formatting in the user interface.


## Results

ORCHID takes care of all the routine operations to develop business applications, giving users the opportunity to focus on a unique business logic that meets the necessary requirements.

Despite the apparent simplicity, it allows to solve many tasks with the help of standard tools, and, if necessary, expand its own functions.


Following the [instructions](/ docs/installation /) you quickly install and are ready to use it.
