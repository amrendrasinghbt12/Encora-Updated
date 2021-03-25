<?php
/**
 * Customproduct Script Module
 *
 * @category  Customproduct
 * @package   Customproduct_Script
 */
namespace Customproduct\Script\Model;

use Magento\Framework\Model\AbstractModel;
use Customproduct\Script\Api\MessageInterface;
use Customproduct\Script\Api\SubscriberInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductFactory;
use Psr\Log\LoggerInterface;
use Customproduct\Script\Model\Datamodel;

/**
 * Class Subscriber
 * @package Customproduct\Script\Model
 */
class Subscriber implements SubscriberInterface
{
    const NEW_KEY_DATA = 'New';

    const USED_KEY_DATA = 'used';

    const REFURBISHED_KEY_DATA = 'refurbished';

    const USED_SKU_DATA = 'NEW';

    const NEW_REFURBISHED_KEY_DATA = 'REFURBISHED';

    const NEW_SKU_DATA = 'USED';

    const NEW_URL_DATA = 'new';

    const USED_URL_DATA = 'used';

    const NEW_TITLE_DATA = 'new';

    const USED_TITLE_DATA = 'used';

    /**
     * Logger Interface
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Consumer constructor.
     * @param StoreManagerInterface $storeManagerInterface
     * @param Product $product
     * @param ProductFactory $productFactory
     * @param Product\Copier $productCopier
     * @param LoggerInterface $logger
     * @param  \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection
     * @param Data $transcript
     */
    public function __construct(
        StoreManagerInterface $storeManagerInterface,
        Product $product,
        ProductFactory $productFactory,
        \Magento\Catalog\Model\Product\Copier $productCopier,
        LoggerInterface $logger,
        \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection,
        Datamodel $transcript
    )
    {
        $this->context = $context;
        $this->scopeConfig = $scopeConfig;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->_product = $product;
        $this->_productFactory = $productFactory;
        $this->productCopier = $productCopier;
        $this->logger = $logger;
        $this->productCollection = $productCollection;
        $this->transcript = $transcript;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    public function processMessage(MessageInterface $message)
    {
        try{
         //function execute handles saving product object
        $collection = $this->productCollection->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('type_id', \Magento\Catalog\Model\Product\Type::TYPE_SIMPLE);
        foreach ($collection as $product) {
            $this->executeProducts($product->getId());
            echo 'Product Added: ' . $product->getId() . PHP_EOL;   
        }
        }catch (\Exception $e){
            //logs to catch and log errors 
            $this->logger->critical($e->getMessage());
        }

        
    }


    /**
     * {@inheritdoc}
     */
    protected function executeProducts($entityId)
    {
     try{
          $createProductNew = $this->transcript->createProductNew($entityId);
          $createProductRefurnished = $this->transcript->createProductRefurbished($productId);
          if ($createProductNew && $createProductRefurnished ) {
              # code...
             return "Queue add Successfully";
          }else{
            return "No product added";
          }

        }catch (\Exception $e){
            //logs to catch and log errors 
            $this->logger->critical($e->getMessage());
        }

    }
}