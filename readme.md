# 簡単に利用できる投票機能を持ったWeb投稿システム
このPHPスクリプトは、Setup.phpを書き換え、DBを用意するだけで利用開始できます。
This PHP script is easy to use. create 'setup.php'. done.

```PHP:setup.php
<?php
//template
$page = array();
$page['title'] = '';
$page['site_name'] = '';
$page['domain'] = '';

$page['og_description'] = '';
$page['og_image'] = '';
$page['logo'] = '';
$page['twitter'] = '';

$page['main_image'] = '";
$page['main_description'] = '';

$db = array();
$db['host'] = '';
$db['username'] = '';
$db['password'] = '';
$db['dbname'] = '';
$db['table'] = '';
```
