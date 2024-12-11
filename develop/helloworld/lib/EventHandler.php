<?php

namespace OCA\Helloworld;

use OCP\EventDispatcher\IEventDispatcher;
use OCA\Files_Sharing\Event\BeforeDirectFileDownloadEvent;
use OCP\Files\Events\BeforeDirectFileDownloadEvent as EventsBeforeDirectFileDownloadEvent;
use OCP\IUserSession;
use OCP\Files\IRootFolder;

class EventHandler
{
	public function registerDownloadEvents(
		IEventDispatcher $dispatcher,
		IUserSession $userSession,
		IRootFolder $rootFolder
	): void {
		// ファイルダウンロード時のイベントリスナー
		$dispatcher->addListener(
			EventsBeforeDirectFileDownloadEvent::class,
			function (EventsBeforeDirectFileDownloadEvent $event) use ($userSession): void {
				$filePath = $event->getPath();

				// ログにダウンロード情報を記録
				// \OCP\Util::writeLog('helloworld', "File is being downloadedです！: $filePath", \OCP\Util::INFO);

				// JavaScriptを使ってコンソールにメッセージを出力
				echo "<script>console.log('File is being downloadedです: $filePath');</script>";
			}
		);
	}
}
