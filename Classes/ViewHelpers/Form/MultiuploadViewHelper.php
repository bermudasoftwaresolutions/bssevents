<?php


namespace Bermuda\BssEvents\ViewHelpers\Form;


class MultiuploadViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\UploadViewHelper
{
    /**
     * @var \TYPO3\CMS\Extbase\Property\PropertyMapper
     * @inject
     */
    protected $propertyMapper;
    /**
     * @param string|null $resources
     * @return string
     */
    public function render() {
        $name = $this->getName();
        foreach (array('type', 'tmp_name', 'error', 'size') as $fieldName) {
            $this->registerFieldNameForFormTokenGeneration(sprintf('%s[*][%s]', $name, $fieldName));
        }
        $resources = 'resources';

        $this->tag->addAttribute('type', 'file');
        $this->tag->addAttribute('name', $name . '[]');
        $this->tag->addAttribute('multiple', '1');
        $this->tag->addAttribute('value', $name . '[]');
        $this->setErrorClassAttribute();
        $output = $this->tag->render();

        $this->viewHelperVariableContainer->add('Bermuda\\BssEvents\\ViewHelpers\\Form\\MultiuploadViewHelper', 'fileReferenceIndex', 10000);
        if (!$resources === NULL) {
            $output .= $this->renderChildren();
        } else {
            $this->templateVariableContainer->add($resources, $this->getUploadedResources());
            $output .= $this->renderChildren();
            $this->templateVariableContainer->remove($resources);
        }
        $this->viewHelperVariableContainer->remove('Bermuda\\BssEvents\\ViewHelpers\\Form\\MultiuploadViewHelper', 'fileReferenceIndex');
        return $output;
    }

    /**
     * Return all resources that are already stored in the file system. This includes
     * file references that are already persisted and files that were uploaded, but
     * are not persisted yet because a mapping/validation error occured.
     *
     * @return array<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */

    protected function getUploadedResources() {
        // TODO: If a mapping error occurs and Extbase redirects to the edit action,
        // the properties of the form object still contain the mapped values, not
        // the persisted ones! So if you unceck an image in the Multiupload.Delete
        // viewhelper, it disappears from the property and we lose it here as well.
        // This means: we need another way to remember which file references were
        // rendered the first time somewhere ...
        $resources = $this->getPropertyValue();
        if ($resources instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage || $resources instanceof \TYPO3\CMS\Extbase\Persistence\QueryResultInterface) {
            $resources = $resources->toArray();
        } else if (!is_array($resources)) {
            $resources = array();
        }
        if ($this->configurationManager->isFeatureEnabled('rewrittenPropertyMapper') && $this->hasMappingErrorOccurred()) {
            foreach ($this->getLastSubmittedFormData() as $lastSubmittedRecord) {
                $convertedResource = $this->propertyMapper->convert($lastSubmittedRecord, 'TYPO3\\CMS\\Extbase\\Domain\\Model\\FileReference');
                if ($convertedResource !== NULL && !in_array($convertedResource, $resources)) {
                    $resources[] = $convertedResource;
                }
            }
        }
        return $resources;
    }
}