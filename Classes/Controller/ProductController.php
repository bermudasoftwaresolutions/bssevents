<?php
namespace Bermuda\BssShop\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use SJBR\StaticInfoTables\Domain\Model\Country;

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
class ProductController extends AbstractController
{

    /**
     * @var \Bermuda\BssShop\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository;

    /**
     * @var \Bermuda\BssShop\Domain\Repository\ProductRepository
     * @inject
     */
    protected $productRepository;

    /**
     * @var \Bermuda\BssShop\Domain\Repository\CartRepository
     * @inject
     */
    protected $cartRepository;

    /**
     * buildRepository
     *
     * @var \Bermuda\BssShop\Domain\Repository\BuildRepository
     * @inject
     */
    protected $buildRepository;

    /**
     * @var \Bermuda\BssShop\Domain\Repository\ClientRepository
     * @inject
     */
    // protected $clientRepository;


    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        if(!$this->checkLogin()) return;

        $args = $this->request->getArguments();
        $category   = isset($args['category']) ? $args['category'] : NULL;
        $search     = isset($args['search'])   ? $args['search']   : NULL;
        $sort       = isset($args['sort'])     ? $args['sort']     : NULL;
        $offset     = isset($args['offset'])   ? $args['offset']   : 0;
        $limit      = isset($this->settings['list']['paginate']['itemsPerPage']) ? (int)$this->settings['list']['paginate']['itemsPerPage']  : 9;

        $this->view
            ->assign('search',           $search)
            ->assign('currentCategory',  is_array($category) ? $category['uid'] : $category)
            ->assign('sort',             $sort)
            ->assign('categories',       $this->categoryRepository->tree())
            ->assign('products',         $this->productRepository->search($category, $search, $sort, $offset, $limit))
            ->assign('cart',             $this->cartRepository->cart())
            ->assign('admin',            $this->userRepository->isAdmin($this->settings['merchant']['group']));
    }

    /**
     * action show
     *
     * @param \Bermuda\BssShop\Domain\Model\Product $product
     * @return void
     */
    public function showAction(\Bermuda\BssShop\Domain\Model\Product $product)
    {
        $args = $this->request->getArguments();
        $buildid   = isset($args['buildid']) ? (int)$args['buildid'] : NULL;

        $this->view
            ->assign('categories',  $this->categoryRepository->tree())
            ->assign('product',     $product)
            ->assign('cart',        $this->cartRepository->cart())
            ->assign('selectedBuild', $this->buildRepository->findByUid($buildid) );
    }

    /**
     * action selectedProductBuild
     ** @return void
     */
    public function selectedProductBuildAction()
    {
        $buildid  = isset($_POST['buildid']) ? $_POST['buildid'] : NULL;

        $view = $this->getStandaloneView();
        $view->setTemplate('Product/SelectedProductBuild');
        $view->assign('product',        $this->buildRepository->findByUid($buildid)->getProduct())
             ->assign('selectedBuild',  $this->buildRepository->findByUid($buildid));

        echo $view->render();
        die;
    }

    /**
     * action pagination
     *
     * @return void
     */
    public function paginationAction()
    {

        $args = $this->request->getArguments();
        $category   = !empty($_POST['category']) ? $_POST['category']     : NULL;
        $search     = isset($_POST['search'])    ? $_POST['search']       : NULL;
        $sort       = isset($_POST['sort'])      ? $_POST['sort']         : NULL;
        $offset     = isset($_POST['offset'])    ? (int)$_POST['offset']  : 0;
        $limit      = isset($_POST['limit'])     ? (int)$_POST['limit']        : 9;

        $rows = $offset;

//        debug($rows);
//        debug($limit);
//
//        debug(count($this->productRepository->search($category, $search, $sort, 0, 200)->toArray()));
//
//        debug($rows + (int)$limit);

        if(count($this->productRepository->search($category, $search, $sort, 0, 200)->toArray()) <= $rows + (int)$limit){

            $limit = $limit - ($rows + $limit-count($this->productRepository->search($category, $search, $sort, 0, 200)->toArray()));
            $limit = $limit ? $limit : 9;
            $rows = 'false';
        }

        $view = $this->getStandaloneView();
        $view->setTemplate('Product/Pagination');

        $view->assign('search',      $search)
             ->assign('sort',        $sort)
             ->assign('rows',        $rows)
             ->assign('categories',  $this->categoryRepository->tree())
             ->assign('products',    $this->productRepository->search($category, $search, $sort, $offset, $limit))
             ->assign('cart',        $this->cartRepository->cart());

        echo $view->render();
        die;
    }
}
