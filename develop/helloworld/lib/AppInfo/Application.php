<?php

// declare(strict_types=1);

namespace OCA\HelloWorld\AppInfo;

use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\EventDispatcher\IEventDispatcher; //web記事の
use OCA\Files\Event\LoadAdditionalScriptsEvent; //web記事の
use OCP\Util;
use Psr\Log\LoggerInterface; // ロガーをインポート
use OCP\Files\Events\BeforeDirectFileDownloadEvent; //ダウンロード時に発火するイベント
use OCA\Files_Trashbin\Events\MoveToTrashEvent; //ゴミ箱に移動時に発火するイベント


//このファイルはロードされる度に実行される
class Application extends App implements IBootstrap
{
	public const APP_ID = 'helloworld';
	/** @var LoggerInterface */
	private $logger;

	/** @psalm-suppress PossiblyUnusedMethod */
	public function __construct()
	{
		parent::__construct(self::APP_ID);
		// var_dump(self::APP_ID);//helloworldでてる！
		$this->logger = $this->getContainer()->get(LoggerInterface::class);
		$this->logger->error('Application cunstructor----------------!!!!!!');
	}

	public function register(IRegistrationContext $context): void
	{

		//web記事のもの
		//https://dev.to/daphnemuller/developing-with-nextcloud-part-2-developing-your-first-app-24h7
		$container = $this->getContainer();
		$eventDispatcher = $container->get(IEventDispatcher::class);

		//検証１
		//ファイル一覧ページにアクセス時にjsを読み込む。こちらはとおる。
		$eventDispatcher->addListener(LoadAdditionalScriptsEvent::class, function () {
			$this->logger->error('LoadAdditionalScriptsEvent add_listener1_subscribe----------------!!!!!!');
			// var_dump('Application リスナー1を登録します');

			Util::addscript(self::APP_ID, 'filesplugin', 'files');
		});


		//検証２
		//EventsBeforeDirectFileDownloadEvent　を試そうとしたもの。通らない。
		$eventDispatcher->addListener(BeforeDirectFileDownloadEvent::class, function (BeforeDirectFileDownloadEvent $event) {

			$this->logger->error('BeforeDirectFileDownloadEvent add_listener2_subscribe--------!!!!!!'); //これはでない

			$filePath = $event->getPath();
			$this->logger->error('Before file download: ' . $filePath);

			// ダウンロードの処理が開始される前に実行したいアクションを追加
			// 例えば、ダウンロードを中止したい場合は
			// $event->setSuccessful(false);
		});


		//検証３
		//MoveToTrashEvent　を試そうとしたもの。
		$eventDispatcher->addListener(MoveToTrashEvent::class, function (MoveToTrashEvent $event) {
			$this->logger->error('MoveToTrashEvent add_listener3_subscribe---------!!!!!!!');

			//以下を書くと削除時に反応はした！
			//headers already sent by (output started at /var/www/html/apps-extra/helloworld/lib/AppInfo/Application.php:72) at /var/www/html/3rdparty/sabre/http/lib/Sapi.php#66"
			//var_dump($event->getNode());
			//var_dump('Application リスナー3を登録します');
		});
	}

	public function boot(IBootContext $context): void {}
}
