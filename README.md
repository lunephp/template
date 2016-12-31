# Lune\Template
PHP templates


## Installation
Template is available on [Composer](http://getcomposer.org)

```
composer require lune/template
```

## Usage

```php
$templates = new \Lune\Template\Engine('path/to/templates');
$template = $templates->template('template.php');
$template->render();
```
### Passing variables
There are numerous ways to pass variables:

```php
$templates = new \Lune\Template\Engine('path/to/templates', ['foo'=>'bar']);
$template = $templates->template('template.php', ['foo'=>'bar']);
$template->render(['foo'=>'bar']);
```

### Registering functions

```php
$templates->registerFunction('error', function($message){
   return sprintf('<span class="error">%s</span>', $message);
});
```