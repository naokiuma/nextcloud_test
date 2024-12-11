<?php
// lib/Hooks.php

namespace OCA\Helloworld\lib;

use OCP\Files\Node;
use OCP\Files;
use OCP\Util;

class Hooks {

    // フックの登録
    public static function register() {　
        // ファイルがアップロードされたときのフック
        \OCP\Util::connectHook('OC_Filesystem', 'post_create', 'OCA\helloworld\lib\Hooks', 'onFileUpload');
        // ファイルが削除された後のフック
        \OCP\Util::connectHook('OC_Filesystem', 'post_delete', 'OCA\helloworld\lib\Hooks', 'onFileDelete');
    }

	// ファイル削除の処理
	public static function onFileDownload(array $params) {
		$path = $params['path'];
		// ログにメッセージを出力
		Util::writeLog('helloworld', "ファイルダウンロード！: $path", Util::INFO);
	}

    // ファイルアップロードの処理
    public static function onFileUpload(array $params) {
        $path = $params['path'];

		// JavaScriptでログを出力するためのコードを出力
		echo "<script>logUpload('$path');</script>";
		Util::writeLog('helloworld', "ファイルアップ！: $path", Util::INFO);

        // // ログにメッセージを出力
        // Util::writeLog('helloworld', "ファイルアップ！: $path", Util::INFO);
    }

    // ファイル削除の処理
    public static function onFileDelete(array $params) {
        $path = $params['path'];
        // ログにメッセージを出力
        Util::writeLog('helloworld', "ファイル削除！: $path", Util::INFO);
    }

}
