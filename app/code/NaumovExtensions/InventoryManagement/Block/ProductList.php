<?php
/**
 * @category NaumovExtensions
 * @package NaumovExtensions_InventoryManagement
 * @author Anton Naumov <anton2-2000@mail.ru>
 * @copyright Copyright (c) 2023 NaumovExtensions
 */

declare(strict_types=1);

namespace NaumovExtensions\InventoryManagement\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Model\ProductFactory;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use NaumovExtensions\InventoryManagement\Model\ResourceModel\InventoryCollection;
use NaumovExtensions\InventoryManagement\Model\ResourceModel\InventoryCollectionFactory;
use NaumovExtensions\InventoryManagement\Helper\Solver;
use Magento\Framework\App\ResourceConnection;

/**
 * class ProductList
 * @package NaumovExtensions\InventoryManagement\Block
 */
class ProductList extends Template
{
    /**
     * @var ResourceConnection
     */
    protected ResourceConnection $resourceConnection;

    /**
     * @var InventoryCollectionFactory
     */
    private InventoryCollectionFactory $inventoryCollectionFactory;

    /**
     * @var ProductFactory
     */
    protected ProductFactory $productFactory;
    /**
     * @var StockRegistryInterface
     */
    protected StockRegistryInterface $stockRegistry;

    /**
     * ProductList constructor.
     * @param Context $context
     * @param InventoryCollectionFactory $inventoryCollectionFactory ;
     * @param ProductFactory $productFactory
     * @param StockRegistryInterface $stockRegistry
     * @param ResourceConnection $resourceConnection
     * @param array $data
     */
    public function __construct(
        Context $context,
        InventoryCollectionFactory $inventoryCollectionFactory,
        ProductFactory $productFactory,
        StockRegistryInterface $stockRegistry,
        ResourceConnection $resourceConnection,
        array $data = []
    ) {
        $this->productFactory = $productFactory;
        $this->resourceConnection = $resourceConnection;
        $this->stockRegistry = $stockRegistry;
        $this->inventoryCollectionFactory = $inventoryCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * Get inventory collection
     *
     * @return InventoryCollection
     */
    public function getInventoryCollection(): InventoryCollection
    {
        $connection = $this->resourceConnection->getConnection();
        $productTable = $connection->getTableName('catalog_product_entity');
        $inventoryTable = $connection->getTableName('naumovinventorymanagement_inventory');
        $collection = $this->inventoryCollectionFactory->create();

        $insertQuery = "INSERT INTO $inventoryTable (product_id) SELECT sku FROM $productTable";

        $query = "DELETE FROM naumovinventorymanagement_inventory";

        $setIdQuery = "ALTER TABLE naumovinventorymanagement_inventory AUTO_INCREMENT=1;";

        $connection->query($query);
        $connection->query($setIdQuery);
        $connection->query($insertQuery);

        foreach ($collection as $inventory) {
            $product = $this->productFactory->create()->load($inventory->getProductId());
            $stockItem = $this->stockRegistry->getStockItem($product->getId(), $product->getStore()->getWebsiteId());

            $eoq = Solver::calculateEoq($product);
            $inventory->setData('eoq', $eoq);

            $rop = Solver::calculateRop($product, $stockItem);
            $inventory->setData('rop', $rop);

            $inventory->save();
        }

        return $collection;
    }
}
