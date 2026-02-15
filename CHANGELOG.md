# Changelog

All notable changes to `i18nertia` will be documented in this file.

- The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
- This project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html),
- Commits respect [Conventionnal commits](https://www.conventionalcommits.org/en/v1.0.0/) & use [Gitmoji](https://gitmoji.dev/).

## **[v0.1.0] - 23/12/2025**
Add new method in the `trans.ts` to add choice between singular/plural or masculine/feminine.

## **[v1.0.0] - 23/12/2025**
Change request for better reload data in inertia laravel
Add new validation for allowed locales
LoadAllTranslations middleware is now using cache and working
New middleware SetLocale to enforce the new locale in inertia app
New component for changing locale in inertia react app
Delete the json translator + InjectLocaleData.


