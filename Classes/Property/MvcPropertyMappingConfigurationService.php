<?php

namespace Bermuda\BssEvents\Property;


use TYPO3\CMS\Extbase\Utility\ArrayUtility as ExtbaseArrayUtility;
use Bermuda\BssEvents\Utility\ArrayUtility as BermudaArrayUtility;

/**
 * Class MvcPropertyMappingConfigurationService
 */

class MvcPropertyMappingConfigurationService extends \TYPO3\CMS\Extbase\Mvc\Controller\MvcPropertyMappingConfigurationService
{

    public function initializePropertyMappingConfigurationFromRequest(\TYPO3\CMS\Extbase\Mvc\Request $request, \TYPO3\CMS\Extbase\Mvc\Controller\Arguments $controllerArguments) {
        $trustedPropertiesToken = $request->getInternalArgument('__trustedProperties');
        if (!is_string($trustedPropertiesToken)) {
            return;
        }
        $serializedTrustedProperties = $this->hashService->validateAndStripHmac($trustedPropertiesToken);
        $trustedProperties = unserialize($serializedTrustedProperties);
        foreach ($trustedProperties as $propertyName => $propertyConfiguration) {
            if (!$controllerArguments->hasArgument($propertyName)) {
                continue;
            }
            $propertyMappingConfiguration = $controllerArguments->getArgument($propertyName)->getPropertyMappingConfiguration();
            //
            // Extended from parent class - begin
            //
            if (is_array($propertyConfiguration)) {
                foreach (BermudaArrayUtility::getPathsToKey($propertyConfiguration, '*') as $path) {
                    $configurationTemplate = ExtbaseArrayUtility::getValueByPath($propertyConfiguration, $path . '.*');
                    $propertyConfiguration = ExtbaseArrayUtility::unsetValueByPath($propertyConfiguration, $path . '.*');
                    if ($request->hasArgument($propertyName) && is_array($request->getArgument($propertyName))) {
                        $rawArgument = ExtbaseArrayUtility::getValueByPath($request->getArgument($propertyName), $path);
                        $subPropertyConfiguration = ExtbaseArrayUtility::getValueByPath($propertyConfiguration, $path);
                        foreach ($rawArgument as $index => $_) {
                            if (!is_int($index) || array_key_exists($index, $subPropertyConfiguration)) {
                                continue;
                            }
                            $propertyConfiguration = ExtbaseArrayUtility::setValueByPath($propertyConfiguration, $path . '.' . $index, $configurationTemplate);
                        }
                    }
                }
            }
            //
            // Extended from parent class - end
            //
            $this->modifyPropertyMappingConfiguration($propertyConfiguration, $propertyMappingConfiguration);
        }
    }
}