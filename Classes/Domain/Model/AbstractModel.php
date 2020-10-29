<?php

namespace Bermuda\BssEvents\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;


abstract class AbstractModel extends AbstractEntity
{

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     * @inject
     */
    protected $objectManager;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    public function save()
    {
        $this->repository->add($this);
        $this->persistenceManager->persistAll();
    }

}