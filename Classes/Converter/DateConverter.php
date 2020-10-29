<?php
namespace Bermuda\BssEvents\Converter;

use TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter;

class DateConverter extends DateTimeConverter
{

    /**
     * @var integer
     */
    protected $priority = 5;


    /**
     * Empty strings can't be converted
     *
     * @param string $source
     * @param string $targetType
     * @return boolean
     */
    public function canConvertFrom($source, $targetType) {
        if ($targetType !== 'DateTime') {
            return FALSE;
        }
        if (is_array($source)) {
            return TRUE;
        }
        return is_string($source);
    }

    /**
     * Converts $source to a \DateTime using the configured dateFormat
     *
     * @param string $source the string to be converted to a \DateTime object
     * @param string $targetType must be "DateTime"
     * @param array $convertedChildProperties not used currently
     * @param \TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationInterface $configuration
     * @return \DateTime
     */
    public function convertFrom($source, $targetType, array $convertedChildProperties = array(), \TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationInterface $configuration = NULL) {
        $dateFormat = $this->getDefaultDateFormat($configuration);

        // override date format
        $dateFormat = 'd.m.Y H:i';

        //$test = date($dateFormat);

        if (is_string($source)) {
            $dateAsString = $source;
        } else {
            if (!isset($source['date']) || !is_string($source['date'])) {
                return new \TYPO3\CMS\Extbase\Error\Error( 'Could not convert the given source into a DateTime object because it was not an array with a valid date as a string', 1308003914);
            }
            $dateAsString = $source['date'];
            if (isset($source['dateFormat']) && strlen($source['dateFormat']) > 0) {
                $dateFormat = $source['dateFormat'];
            }
        }
        $date = \DateTime::createFromFormat($dateFormat, $dateAsString);
        if ($date === FALSE || $dateAsString === '') {
            return new \TYPO3\CMS\Extbase\Validation\Error('The string "' . $dateAsString . '" could not be converted to DateTime with format "' . $dateFormat . '"', 1307719788);
        }
        if (is_array($source)) {
            $this->overrideTimeIfSpecified($date, $source);
            $this->overrideTimezoneIfSpecified($date, $source);
        }
        return $date;
    }

}