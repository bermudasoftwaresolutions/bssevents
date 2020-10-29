<?php

namespace Bermuda\BssEvents\Domain\Model;


class AppointmentFileReference extends \TYPO3\CMS\Extbase\Domain\Model\AbstractFileFolder
{
    /**
     * Uid of the referenced sys_file. Needed for extbase to serialize the
     * reference correctly.
     *
     * @var int
     */
    protected $uidLocal;

    /**
     * title
     *
     * @var string
     */
    protected $title;

    /**
     * @param \TYPO3\CMS\Core\Resource\ResourceInterface $originalResource
     */
    public function setOriginalResource(\TYPO3\CMS\Core\Resource\ResourceInterface $originalResource) {
        $this->originalResource = $originalResource;
        $this->uidLocal = (int)$originalResource->getUid();
    }

    /**
     * @return \TYPO3\CMS\Core\Resource\FileReference
     */
    public function getOriginalResource()
    {
        if ($this->originalResource === null) {
            $this->originalResource = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance()->getFileReferenceObject($this->getUid());
        }

        return $this->originalResource;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}