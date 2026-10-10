# php-utils
PHP utilities and commons - C# like classes (if you are to it), more OOP and useful functions.
## Motivation
I write PHP the same way I write C#, so I keep the things I miss in one place instead of copying them from project to project. It is the base of my other packages ([php-enum](https://github.com/vosiz/php-enum), [va-tools](https://github.com/vosiz/va-tools)) and of everything I build on them. Made by personal need, so feel free to use it if it fits yours. MIT - use it however you like.
## Requirements
- PHP 7.4 or newer
- Composer
## Bug tracker
No tracked
## Features
Everything checked in the [Roadmap](#roadmap).
## Roadmap
- [x] Collection, Dictionary, KeyValuePair
- [x] Exceptionf - formatted exceptions with inner chain
- [x] SmartObject, Singleton
- [x] Is - type and emptiness checks
- [x] Conversions and string helpers (tostr, camel, snake, ...)
- [x] Crypto - PasswordHasher
- [x] TimeFormat
- [x] Io - Path, File, Dir, Inc
- [x] Tests
## Setup
```
composer require vosiz/php-utils
```
Namespaced classes go through an alias, the rest (functions, `Exceptionf`, `Is`, ...) is global.
```php
use Vosiz\Utils\Collections\Collection;
use Vosiz\Utils\Io;

$user = new Collection(['name' => 'Joe']);
echo $user->Name;

$path = Io\Path::Combine('/var/www', 'app', 'index.php');
```
### Tests
Docker is all you need, the suite runs on every supported PHP version.
```
./tests.sh
```
