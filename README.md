# api-generator
A Laravel api-generator Package for Laravel AdminPanel &lt; https://github.com/lbmadesia/laravel-adminpanel &gt;

# License
This api-generator is open-sourced software licensed under the MIT license

# Official Documentation
To get started with api-generator, use Composer to add the package to your project's dependencies:

```
composer require lbmadesia/api-generator
```

Since you would be having work of this api-generator, while creating your project, hence only require it in the dev environment.

### Configuration

After installing the Generator, register the `Lbmadesia\ApiGenerator\Provider\ApiCrudGeneratorServiceProvider` in your `config/app.php` configuration file:

```php
'providers' => [
    // Other service providers...

    Lbmadesia\ApiGenerator\Provider\ApiCrudGeneratorServiceProvider::class
],
```

you need to run below command for publish migration, view and config file:
```
php artisan vendor:publish --tag=api-generator
```

and you can get the title "Api Management" from package's translation file by using:

```
{{ trans('generator::menus.apis.management') }}
```
Link Api management with route 

```
{{ route('admin.apis.index') }}
```


# Contribute
You can contribute to this project, by just taking fork of it. We are open for suggestion and PRs. If you have any new suggestions or anything for that matter, contact me at lbmadesia@gmail.com


