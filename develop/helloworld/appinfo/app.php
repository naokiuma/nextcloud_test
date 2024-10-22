<?php
// appinfo/app.php

namespace OCA\helloworld\AppInfo;

use OCP\AppFramework\App;
use OCA\helloworld\lib\Hooks;

class Application extends App {
    public function __construct() {
        parent::__construct('helloworld');
        Hooks::register();  // フックを登録

		\OCP\Util::addScript('helloworld', 'app');  // 'helloworld'はアプリ名、'app'はJavaScriptファイル名
    }
}

// アプリケーションの初期化
$app = new Application();
