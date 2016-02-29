# yii2-zohocrm
Yii2 component for ZohoCRM integration

Usage
-----
Add this to your config file
```php
'components' => [
    ...
    'zoho' => [
        'class' => 'WondersLabCorporation\Zoho',
        'authToken' => 'ZOHO_CRM_AUTH_TOKEN',
    ]
]
```


Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Add to your `composer.json` file

```json
"repositories": [
        {
            "url": "https://github.com/WondersLabCorporation/yii2-zohocrm.git",
            "type": "git"
        }
    ]
```
and run

```
composer require WondersLabCorporation/yii2-zohocrm:"dev-master"
```
