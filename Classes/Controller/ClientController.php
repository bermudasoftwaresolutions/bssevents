<?php
namespace Bermuda\BssShop\Controller;


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
 * ClientController
 */
class ClientController extends AbstractController
{

    /**
     * @var \Bermuda\BssShop\Domain\Repository\ClientRepository
     * @inject
     */
    protected $clientRepository = null;

    /**
     * @var \Bermuda\BssShop\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository;

    /**
     * countryRepository
     *
     * @var \SJBR\StaticInfoTables\Domain\Repository\CountryRepository
     * @inject
     */
    protected $countryRepository;

    /**
     * cartRepository
     *
     * @var \Bermuda\BssShop\Domain\Repository\CartRepository
     * @inject
     */

    protected $cartRepository;


    /**
     * action edit
     * 
     * @param \Bermuda\BssShop\Domain\Model\Client $client
     * @ignorevalidation $client
     * @return void
     */
    public function editAction(\Bermuda\BssShop\Domain\Model\Client $client)
    {
        $this->view->assign('categories',  $this->categoryRepository->tree())
                   ->assign('countries',  $this->countryRepository->findAll())
                   ->assign('cart',  $this->cartRepository->cart())
                   ->assign('client', $client);
    }

    /**
     * action update
     * 
     * @param \Bermuda\BssShop\Domain\Model\Client $client
     * @return void
     */
    public function updateAction(\Bermuda\BssShop\Domain\Model\Client $client)
    {
        $this->clientRepository->update($client);
        $this->view->assign('categories',  $this->categoryRepository->tree())
                   ->assign('countries',  $this->countryRepository->findAll())
                   ->assign('cart',  $this->cartRepository->cart())
                   ->assign('client', $client);
    }


}
