<?php
/**
 * @category NaumovExtensions
 * @package NaumovExtensions_IntegrationLogs
 * @author Anton Naumov <anton2-2000@mail.ru>
 * @copyright Copyright (c) 2023 NaumovExtensions
 */

declare(strict_types=1);

namespace NaumovExtensions\IntegrationLogs\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Config
 * @package NaumovExtensions/IntegrationLogs/Model
 */
class Config
{
    /**
     *
     */
    const XML_PATH_LOG_DAYS_TO_KEEP = 'naumovextensions_integration_logs/settings/log_days';

    /**
     * @var ScopeConfigInterface
     */
    protected ScopeConfigInterface $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return int
     */
    public function getLogDaysToKeep(): int
    {
        return (int)$this->scopeConfig->getValue(
            self::XML_PATH_LOG_DAYS_TO_KEEP,
            ScopeInterface::SCOPE_STORE
        );
    }
}
