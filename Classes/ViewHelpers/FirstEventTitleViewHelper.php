<?php
namespace Bermuda\BssEvents\ViewHelpers;

use Bermuda\BssEvents\Domain\Model\Event;

class FirstEventTitleViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $events
     * @return string HTML Event Element
     */
    public function render($events) {

        $res = '';

        /** @var Event $event */
        $event = $events->getFirst();

        if($event)
            $res = $event->getTitle();

        return $res;
    }
}