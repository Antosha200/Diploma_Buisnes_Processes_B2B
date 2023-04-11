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
        $deleteQuery = "DELETE FROM $inventoryTable";
        $setIdQuery = "ALTER TABLE $inventoryTable AUTO_INCREMENT=1;";

        $connection->query($deleteQuery);
        $connection->query($setIdQuery);
        $connection->query($insertQuery);

        foreach ($collection as $inventory) {
            $productId = $inventory->getProductId();
            $query = "SELECT entity_id FROM catalog_product_entity WHERE sku = '$productId'";
            $product_id = $connection->fetchAll($query);

            $product = $this->productFactory->create()->load($product_id);
            $stockItem = $this->stockRegistry->getStockItem($product->getId(), $product->getStore()->getWebsiteId());
            $qty = $stockItem->getQty();

            $eoq = Solver::calculateEoq($product);
            if ($eoq <= 0) {
                $eoq = '<span style="color:red;">' . $eoq . '</span>';
            } else {
                $eoq = '<span style="color:blue;">' . $eoq . '</span>';
            }
            $inventory->setData('eoq', $eoq);

            $rop = Solver::calculateRop($product, $qty);

            //kstl
            if ($rop < 0) {
                $res = Solver::calculateEoq($product) / 2;
                $rop = '<span style="color:blue;">' . $res . '</span>';
            } else {
                $rop = '<span style="color:blue;">' . $rop . '</span>';
            }
            $inventory->setData('rop', $rop);
            $inventory->setData('stock', $qty);

            if (Solver::calculateRop($product, $qty) > $qty) {
                $status = 0;
            } else {
                $status = 1;
            }

            $inventory->setData('status', $status);
            $inventory->save();
        }

        return $collection;
    }
}
