<?php
namespace Bermuda\BssEvents\ViewHelpers;

class ShowAdditionalEventsViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $events
     * @return string HTML Event Element
     */
    public function render($events) {

        $ret = "";
        $count = $events->count();

        if($count > 1){
            $ret = "<span class=\"plus_count\">+ ".($count-1)."<div>";

            for($c = 1; $c < $count; $c++){

                $ret .=
                    "<div class='additionalEvent' style=\"background-color: ".$events[$c]->getCategories()->getArray()[0]->getColor()."\">
                        <span>".$events[$c]->getTitle()."</span>
                    </div>";
            }

            $ret .= "</div></span>";
        }

        return $ret;
    }
}