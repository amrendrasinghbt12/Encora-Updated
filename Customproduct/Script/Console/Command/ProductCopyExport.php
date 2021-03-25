<?php
/**
 * ProductCopyExport.php
 * @package   Customproduct\Script\Console
 */

namespace Customproduct\Script\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\File\Csv;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ResourceConnection;
use Psr\Log\LoggerInterface as PsrLogger;


class ProductCopyExport extends Command
{
    const NAME = 'product:copy:ProductCopyExport';

    /**
     * @var $_logger
     */
    protected $_logger;


    /**
     * ProductCopyExport constructor.
     * @param Csv $csv
     * @param DirectoryList $directoryList
     * @param ResourceConnection $resource
     * @param PsrLogger $logger
     * @param null $name
     */
    public function __construct(
        Csv $csv,
        DirectoryList $directoryList,
        ResourceConnection $resource,
        PsrLogger $logger,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Customproduct\Script\Helper\Data $helper,
        \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection,
        \Magento\Framework\App\State $state,
        $name = null
    )
    {
        parent::__construct($name);
        $this->csv = $csv;
        $this->directoryList = $directoryList;
        $this->_logger = $logger;
        $this->scopeConfig = $scopeConfig;
        $this->helper = $helper;
        $this->productCollection = $productCollection;
        $this->state = $state;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::NAME);
        $this->setDescription('Prouct Transcript Copy');
        parent::configure();
    }

    /**
     * payment report orders
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {   
        $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_ADMINHTML);
        $productTranscript = $this->createProductTranscript($output);
        if($productTranscript){
            $output->writeln("Product Transcript Process done");
        }

    }

    protected function createProductTranscript($output)
    {

       try{
         //function execute handles saving product object
        $collection = $this->productCollection;
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('type_id', \Magento\Catalog\Model\Product\Type::TYPE_SIMPLE);
        foreach ($collection as $product) {
            $this->executeProducts($product->getId(),$output);
            $productCollectionArr[] = [
                    'type' => 'product',
                    'entity_id' => $product->getId(),
                    'priority' => 1,
                ];
        }
        return true;
        }catch (\Exception $e){
            $output->writeln($e->getMessage());
            //logs to catch and log errors 
            $this->_logger->critical($e->getMessage());
        }
    }


    /**
     * {@inheritdoc}
     */
    protected function executeProducts($entityId,$output)
    {
     try{
          $createProductNew = $this->helper->createProductNew($entityId);
          $createProductRefurnished = $this->helper->createProductRefurbished($entityId);
          if ($createProductNew && $createProductRefurnished ) {
              # code...
             return "Product Added Successfully";
          }else{
            return "No Products get Added";
          }

        }catch (\Exception $e){
            $output->writeln($e->getMessage());
            //logs to catch and log errors 
            $this->_logger->critical($e->getMessage());
        }

    }

}
