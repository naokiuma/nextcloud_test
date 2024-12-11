<?php

// declare(strict_types=1);

namespace OCA\HelloWorld\AppInfo;

use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\EventDispatcher\IEventDispatcher; //web記事の
use OCA\Files\Event\LoadAdditionalScriptsEvent; //web記事の
use OCA\Files_Sharing\Listener\BeforeDirectFileDownloadListener;
use OCP\Util;

use Psr\Log\LoggerInterface; // ロガーをインポート
use OCP\Files\Events\BeforeDirectFileDownloadEvent as EventsBeforeDirectFileDownloadEvent;


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
		$this->logger->info('Application コンストラクタ〜〜〜');

		//web記事のもの
		//https://dev.to/daphnemuller/developing-with-nextcloud-part-2-developing-your-first-app-24h7
		$container = $this->getContainer();
		$eventDispatcher = $container->get(IEventDispatcher::class);
		$eventDispatcher->addListener(LoadAdditionalScriptsEvent::class, function () {
			$this->logger->info('LoadAdditionalScriptsEvent リスナーを登録します');
			Util::addscript(self::APP_ID, 'filesplugin', 'files');
		});

		//EventsBeforeDirectFileDownloadEvent　を試そうとしたもの
		$dispatcher = $this->getContainer()->get(IEventDispatcher::class);
		$dispatcher->addListener(EventsBeforeDirectFileDownloadEvent::class, function (EventsBeforeDirectFileDownloadEvent $event) {

			$this->logger->info('BeforeDirectFileDownloadEvent リスナーを登録します');
			$filePath = $event->getPath();
			// var_dump($filePath);
			$this->logger->info('Before file downloadの時: ' . $filePath);

			// ダウンロードの処理が開始される前に実行したいアクションを追加
			// 例えば、ダウンロードを中止したい場合は
			// $event->setSuccessful(false);
		});
	}

	public function register(IRegistrationContext $context): void {}

	public function boot(IBootContext $context): void {}
}
