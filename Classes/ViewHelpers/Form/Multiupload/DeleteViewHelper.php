<?php

namespace  Bermuda\BssEvents\ViewHelpers\Form\Multiupload;


use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\ViewHelpers\Form\AbstractFormFieldViewHelper;

class DeleteViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\CheckboxViewHelper {


    /**
     * @var \TYPO3\CMS\Extbase\Security\Cryptography\HashService
     * @inject
     */
    protected $hashService;

    /**
     * Initialize the arguments.
     *
     * @api
     */
    public function initializeArguments()
    {
        $this->registerArgument('additionalAttributes', 'array', 'Additional tag attributes. They will be added directly to the resulting HTML tag.', false);
        $this->registerArgument('data', 'array', 'Additional data-* attributes. They will each be added with a "data-" prefix.', false);
        $this->registerArgument('name', 'string', 'Name of input tag');
        $this->registerArgument('value', 'mixed', 'Value of input tag');
        $this->registerArgument(
            'property',
            'string',
            'Name of Object Property. If used in conjunction with <f:form object="...">, "name" and "value" properties will be ignored.'
        );
        $this->registerTagAttribute(
            'disabled',
            'string',
            'Specifies that the input element should be disabled when the page loads'
        );
        $this->registerArgument(
            'errorClass',
            'string',
            'CSS class to set if there are errors for this view helper',
            false,
            'f3-form-error'
        );
        $this->overrideArgument('value', 'string', 'Value of input tag. Required for checkboxes', true);
        $this->registerUniversalTagAttributes();
        $this->registerArgument('multiple', 'bool', 'Specifies whether this checkbox belongs to a multivalue (is part of a checkbox group)', false, false);
    }

    /**
     * Renders the checkbox.
     *
     * @param boolean $checked Specifies that the input element should be preselected
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     * @return string
     * @api
     */
    public function render($checked = TRUE) {
        if (!$this->arguments['value'] instanceof \TYPO3\CMS\Extbase\Domain\Model\FileReference) {
            var_dump($this->arguments['value']);
            throw new \InvalidArgumentException('The value assigned to Form.Multiupload.DeleteViewhelper must be of type FileReference', 1421848917);
        }
        $resourcePointerValue = $this->arguments['value']->getUid();
        if ($resourcePointerValue === NULL) {

            $resourcePointerValue = 'file:' . $this->arguments['value']->getOriginalResource()->getOriginalFile()->getUid();
        }
        $index = $this->viewHelperVariableContainer->get('Bermuda\\BssEvents\\ViewHelpers\\Form\\MultiuploadViewHelper', 'fileReferenceIndex');
        $this->viewHelperVariableContainer->addOrUpdate('Bermuda\\BssEvents\\ViewHelpers\\Form\\MultiuploadViewHelper', 'fileReferenceIndex', ++$index);

        $name = $this->getName();
        $name = (strpos($name, '[__identity]') === FALSE ? $name : substr($name, 0, -strlen('[__identity]'))) . '[' . $index . ']';
        $this->registerFieldNameForFormTokenGeneration($name);
        $this->tag->addAttribute('name', $name . '[submittedFile][resourcePointer]');
        $this->tag->addAttribute('type', 'checkbox');
        $this->tag->addAttribute('value', htmlspecialchars($this->hashService->appendHmac((string) $resourcePointerValue)));
        if ($checked) {
            $this->tag->addAttribute('checked', 'checked');
        }
        return $this->tag->render();
    }


}
