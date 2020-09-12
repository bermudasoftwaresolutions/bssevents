<?php
namespace Bermuda\BssShop\Domain\Repository;


/***
 *
 * This file is part of the "Bss Shop" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Bermuda Software <info@bermuda-software.ch>, Bermuda Software
 *
 ***/
/**
 * The repository for User
 */

class UserRepository extends \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
{
    
    public function isUser(){
        return ($GLOBALS['TSFE']->fe_user->user !== NULL);
    }

    public function uid()
    {
        if (!$this->isUser()) {
            throw new \Exception('No FE User.');
        }
        
        return $GLOBALS['TSFE']->fe_user->user['uid'];
    }

    // https://hotexamples.com/examples/typo3.cms.extbase.domain.repository/FrontendUserRepository/findByUid/php-frontenduserrepository-findbyuid-method-examples.html
    public function user()
    {
        if (!$this->isUser()) {
            throw new \Exception('No FE User.');
        }
        
        return $this->findByUid($this->uid());
    }

    public function isAdmin($adminGroups){

        $userGroups = explode(',', $GLOBALS['TSFE']->fe_user->user['usergroup']);

        $isAdmin =  count(array_intersect( explode(',', $adminGroups),  $userGroups));

        $isAdmin =  ($isAdmin > 0)   ? TRUE  : FALSE;

        return $isAdmin;
    }
}