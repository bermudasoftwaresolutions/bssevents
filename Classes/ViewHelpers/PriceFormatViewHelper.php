<?php

namespace Bermuda\BssShop\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class PriceFormatViewHelper extends AbstractViewHelper
{

    use CompileWithRenderStatic;

    public function initializeArguments()
    {
        $this->registerArgument('price', 'string', 'Check if price has decimals', true);
        $this->registerArgument('currency', 'int', 'Check if is currency enabled', false);


    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    )

    {

        if (is_numeric($arguments['price']) && floor($arguments['price']) != $arguments['price']) {

            $arguments['price'] = number_format($arguments['price'], 2, '.', '\'');

        } else {
            if ($arguments['currency'] != NULL) {

                $arguments['price'] = '' . number_format($arguments['price'], 0, '.', '\'');

            } else {

                $arguments['price'] = '' . number_format($arguments['price'], 0, '.', '\'') . '.-';

            }
        }


        return $arguments['price'];
    }

}