<?php
namespace Bermuda\BssEvents\Converter;

use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Property\TypeConverter\AbstractTypeConverter;

class FileReferenceConverter extends AbstractTypeConverter
{

    public function __construct()
    {
        $om = new ObjectManager();
        $this->fileRepository = $om->get(FileRepository::class);
    }

    /**
     * @var \TYPO3\CMS\Core\Resource\FileRepository
     * @inject
     */
    protected $fileRepository;

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
        return true;
    }

    /**
     * Converts $source to a \DateTime using the configured dateFormat
     *
     * @param string $source the string to be converted to a \DateTime object
     * @param string $targetType must be "DateTime"
     * @param array $convertedChildProperties not used currently
     * @param \TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationInterface $configuration
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function convertFrom($source, $targetType, array $convertedChildProperties = array(), \TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationInterface $configuration = NULL) {

        $test = $this->fileRepository->findFileReferenceByUid(intval($source));

        $ter = new FileReference();
        $ter->setOriginalResource($test);

        return $ter;

    }

}