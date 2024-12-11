<?php

namespace OCA\Helloworld;

use OCP\Files\Event\NodeReadEvent;
use OCP\Files\Node;

// //1210試しているもの
class HookHandler {
    /**
     * Handle the file download event
     *
     * @param NodeReadEvent $event
     */
    public static function onFileDownload(NodeReadEvent $event): void {
        $file = $event->getNode();
        if ($file instanceof Node) {
            $filePath = $file->getPath();
            // ログ出力やカスタム処理をここで実行
            \OCP\Util::writeLog('helloworld', "File downloaded: $filePath", \OCP\Util::INFO);
        }
    }
}
