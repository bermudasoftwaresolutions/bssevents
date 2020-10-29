<?php
namespace Bermuda\BssEvents\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class PreviousNextYearViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    use CompileWithRenderStatic;

    public function initializeArguments()
    {
        $this->registerArgument('year', 'string', 'Year', true);
        $this->registerArgument('prevNext', 'string', 'Previous or Next', true);

    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    )



    {

        $res = (int)$arguments['year'] - (int)$arguments['prevNext'];

        return $res;
    }

}