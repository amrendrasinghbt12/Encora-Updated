<?php
/**
 * Customproduct Script Module
 *
 * @category  Customproduct
 * @package   Customproduct_Script
 */
namespace Customproduct\Script\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Catalog\Model\Product;
use Psr\Log\LoggerInterface;
use Customproduct\Script\Model\Datamodel;

/**
 * Class Create
 * @package Customproduct\Script\Controller\Adminhtml\Index
 */
class Create extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Logger Interface
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * Create constructor.
     * @param Context $context
     * @param LoggerInterface $logger
     * @param ScopeConfigInterface $scopeConfig
     * @param PageFactory $resultPageFactory
     * @param Product $product
     * @param Data $transcript
     * @param \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory
     */
    public function __construct(
        Context $context,
        LoggerInterface $logger,
        ScopeConfigInterface $scopeConfig,
        PageFactory $resultPageFactory,
        Product $product,
        Datamodel $transcript,
        \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory
    )
    {
        $this->logger = $logger;
        $this->scopeConfig = $scopeConfig;
        $this->pageFactory = $resultPageFactory;
        $this->_product = $product;
        $this->transcript = $transcript;
        $this->resultRedirectFactory = $resultRedirectFactory;
        parent::__construct($context);
    }


    /**
     * Index Action*
     * @return $resultRedirect
     */
    public function execute()
    {
        try{
           
            $productId = $this->getRequest()->getParam('entity_id');
            $createProductNew = $this->transcript->createProductNew($productId);
            $createProductRefurnished = $this->transcript->createProductRefurbished($productId);
            if($createProductNew && $createProductRefurnished)
            {
                $this->addLogger("Customproduct_module :: Custom  Products are created :");
                $this->messageManager->addSuccess(__('Created Products Successfully'));
            }else{
               $this->addLogger("Customproduct_module :: Product is not created");
               $this->messageManager->addNotice(__('Product is not created'));
            }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('productscript/index/index');
        }catch (\Throwable $e) {
            
           
            $this->logger->critical("Customproduct :: Product  Error :" . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
        return $resultRedirect;
        
    }

    /**
     * Check Form List Permission.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Customproduct_Script::index_create');
        
    }

    /**
     * @param $log
     * @return mixed
     */
    protected function addLogger($log)
    {
        return $this->logger->addDebug("Customproduct :: Custom Product :: " . $log);
    }
}
