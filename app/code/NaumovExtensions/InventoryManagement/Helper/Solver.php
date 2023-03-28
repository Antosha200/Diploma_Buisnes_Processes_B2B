<?php
/**
 * @category NaumovExtensions
 * @package NaumovExtensions_InventoryManagement
 * @author Anton Naumov <anton2-2000@mail.ru>
 * @copyright Copyright (c) 2023 NaumovExtensions
 */

declare(strict_types=1);

namespace NaumovExtensions\InventoryManagement\Helper;

use Magento\Catalog\Model\Product;
use Magento\CatalogInventory\Api\Data\StockItemInterface;

/**
 * class Solver
 * @package NaumovExtensions\InventoryManagement\Helper
 */
class Solver
{
    //TODO: (NEXT) - Content on Detail page.
    /**
     * Calculates the EOQ for a given product
     *
     * @param Product $product
     * @return float
     */
    public static function calculateEoq(Product $product)
    {
        $demandPerYear = $product->getData('demand_per_year');
        $orderingCost = $product->getPrice();
        $holdingCost = $product->getData('holding_cost');

        if ($holdingCost != 0) {
            return round(sqrt((2 * $demandPerYear * $orderingCost) / $holdingCost), 0, PHP_ROUND_HALF_DOWN);
        } else {

            return 0;
        }
    }

    /**
     * Calculates the ROP for a given product and stock item
     *
     * @param Product $product
     * @param StockItemInterface $stockItem
     * @return float
     */
    public static function calculateRop(Product $product, StockItemInterface $stockItem): float
    {
        $leadTime = $product->getData('lead_time');
        $demandPerDay = $product->getData('demand_per_day');
        $safetyStock = $product->getData('safety_stock');

        return round($leadTime * $demandPerDay + $safetyStock - $stockItem->getQty(), 0, PHP_ROUND_HALF_DOWN);
    }
}
