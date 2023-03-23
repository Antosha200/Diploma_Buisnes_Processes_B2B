<?php
/**
 * @category NaumovExtensions
 * @package NaumovExtensions_IntegrationLogs
 * @author Anton Naumov <anton2-2000@mail.ru>
 * @copyright Copyright (c) 2023 NaumovExtensions
 */

declare(strict_types=1);

namespace NaumovExtensions\IntegrationLogs\Cron;

use Exception;
use NaumovExtensions\IntegrationLogs\Model\Config;
use NaumovExtensions\IntegrationLogs\Helper\Logger;

/**
 * Class Grid
 * @package NaumovExtensions/IntegrationLogs/Cron
 */
class Cleanup
{
    /**
     * @var Logger
     */
    protected Logger $logger;

    /**
     * @var Config
     */
    protected Config $config;

    /**
     * @param Logger $logger
     * @param Config $config
     */
    public function __construct(Config $config, Logger $logger)
    {
        $this->logger = $logger;
        $this->config = $config;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function execute(): void
    {
        $daysToKeep = $this->config->getLogDaysToKeep();

        if ($daysToKeep) {
            $this->logger->deleteOldLogs($daysToKeep);
        }
    }
}
