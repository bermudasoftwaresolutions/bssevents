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
 * The repository for Clients
 */
class ClientRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{


    /**
     * @var \Bermuda\BssShop\Domain\Repository\UserRepository
     * @inject
     */
    protected $userRepository;

    /**
     * @var \Bermuda\BssShop\Domain\Repository\CartRepository
     * @inject
     */
    protected $cartRepository;



    public function client()
    {
        $clients = $this->findByUser($this->userRepository->uid())->toArray();
        switch (count($clients)) {
            case 0:
                $client =  new \Bermuda\BssShop\Domain\Model\Client();
                $client->setUser(     ($this->userRepository->user()->getUid()) ? $this->userRepository->user()->getUid() : '');
                $client->setName(     ($this->userRepository->user()->getFirstName()) ? $this->userRepository->user()->getFirstName() : '');
                $client->setEmail(   ($this->userRepository->user()->getemail()) ? $this->userRepository->user()->getemail() : '');
                $client->setStreet(   ($this->userRepository->user()->getAddress()) ? $this->userRepository->user()->getAddress() : '');
                $client->setZip(      ($this->userRepository->user()->getZip()) ? $this->userRepository->user()->getZip() : '');
                $client->setCity(     ($this->userRepository->user()->getCity()) ? $this->userRepository->user()->getCity() : '');
//                $client->setCountry(  ($this->userRepository->user()->getCountry()) ? $this->userRepository->user()->getCountry() : '');
                $client->setPhone(    ($this->userRepository->user()->getTelephone()) ? $this->userRepository->user()->getTelephone() : '');
                $this->add($client);
                $this->persistenceManager->persistAll();
                $this->cartRepository->addClient($client);

                break;

            case 1:

                $client = $clients[0];
                $this->cartRepository->addClient($clients[0]);

                break;

            default:
                throw new \Exception('More than one client attached to user.');
                return NULL;
        }

        return $client;


    }



}
