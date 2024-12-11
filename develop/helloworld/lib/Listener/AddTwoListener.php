<?php
//よくわからない。いるのか？
declare(strict_types=1);

namespace OCA\Helloworld\Event;

use OCA\Helloworld\Event\AddEvent;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;



class AddTwoListener implements IEventListener
{

	public function handle(Event $event): void
	{
		if (!($event instanceof AddEvent)) {
			return;
		}

		$event->addToCounter(2);
	}
}
