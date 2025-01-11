### Installation

Install the package via Composer:
```php
composer require mimachh/i18nertia
```


If you need to customize the middleware configuration, you can publish it:

```php
php artisan vendor:publish --tag=i18nertia-middleware

```

If you're using React + Inertia with shadcn/ui, you can leverage the provided switch-locale component. First, publish the component:
```php
php artisan vendor:publish --tag=i18nertia-assets

```
Then, modify the component as needed to suit your application.


### Translation with JSON
To use translations, create a locales folder in your app directory:
```
app/
    locales/
        fr.json   <---- root file is a fallback file. 
        fr/
            global.json <---- global translation, available on every page/component of your inertia app.
            <folder-name/file-name following the route-name>
               
```

The folder structure should match your route names. For example, if you are on the route `front.post.index`, you should add the corresponding translation keys in a file located at `locales/fr/front/post/index.json`.

Example Folder Structure:

```
app/
    locales/
        fr.json
        fr/
            global.json
            front/
                post/
                    index.json
```

Example Translation File (.json):

```json
// your json file are classical key:value

{
    "blog_list": {
        "title": "Articles list"
    },

    "date": {
        "published_at": "Published at {date}"
    },
    "welcome": "Welcome on :siteName",
}
```
Then you can use the translation in your react component 
```tsx
    const { translate } = translation();
    {translate("welcome", { siteName: appName })}
```
### Advices
For small projects, you can store all your translations in a single file like `locales/${locale}.json`. This simplifies usage and maintenance.

However, in larger projects with extensive translations, this approach can lead to performance issues. Instead, organize your translations into separate files that match your app's route structure for better scalability and maintainability.


### Classic Laravel Translation
Using `LoadAllTranslations.php` middleware you'll have access to the laravel lang:publish files. You can add your own files in here.

Using `SelectedTranslations.php` middleware you can pass array of files in the lang:publish files : `middleware('<alias>:auth,validation')`

By default this middlewares have default aliases : 
```php
$router->aliasMiddleware('translations', Translation::class);
$router->aliasMiddleware('selected_translations', SelectedTranslation::class);
```
You can override it if needed.