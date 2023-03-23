<?php
/**
 * @category NaumovExtensions
 * @package NaumovExtensions_IntegrationLogs
 * @author Anton Naumov <anton2-2000@mail.ru>
 * @copyright Copyright (c) 2023 NaumovExtensions
 */

declare(strict_types=1);

namespace NaumovExtensions\IntegrationLogs\Helper;

use Exception;
use NaumovExtensions\IntegrationLogs\Model\LogFactory as LogModelFactory;
use Magento\Framework\Model\AbstractModel;
use NaumovExtensions\IntegrationLogs\Model\ResourceModel\Database;
use DateTime;
use DateInterval;

/**
 * Class Logger
 * @package NaumovExtensions/IntegrationLogs/Helper
 */
class Logger extends AbstractModel
{
    /**
     * @var LogModelFactory
     */
    protected LogModelFactory $logModelFactory;

    /**
     * @var array
     */
    protected array $messages = [];

    /**
     * @var string
     */
    protected string $logObject;

    /**
     * @var string
     */
    protected string $logEvent;

    /**
     * @var int
     */
    protected int $logStatus = 0;

    /**
     * @var string
     */
    protected string $logData;

    /**
     * @param LogModelFactory $logModelFactory
     */
    public function __construct(LogModelFactory $logModelFactory)
    {
        $this->logModelFactory = $logModelFactory;
        $this->_init(Database::class);
    }

    /**
     * @param string $message
     * @return array
     */
    public function addMessage(string $message): array
    {
        $this->messages[] = $message;
        return $this->messages;
    }

    /**
     * @param int $status
     * @return int
     */
    public function setStatus(int $status): int
    {
        $this->logStatus = $status;
        return $this->logStatus;
    }

    /**
     * @param string $object
     * @return string
     */
    public function setObject(string $object): string
    {
        $this->logObject = $object;
        return $this->logObject;
    }

    /**
     * @param string $event
     * @return string
     */
    public function setEvent(string $event): string
    {
        $this->logEvent = $event;
        return $this->logEvent;
    }

    /**
     * @param $data
     * @return $this
     */
    public function setLogData($data): Logger
    {
        if (is_array($data)) {
            $this->logData = json_encode($data);
        } else {
            $this->logData = $data;
        }

        return $this;
    }

    /**
     * @throws Exception
     */
    public function save(): void
    {
        $logMessage = implode("\n", $this->messages);

        $logModel = $this->logModelFactory->create();
        $logModel->setData([
            'status' => $this->logStatus,
            'object' => $this->logObject,
            'event' => $this->logEvent,
            'message' => $logMessage,
            'data' => $this->logData,
            'created_at' => (new DateTime())->format('Y-m-d H:i:s')
        ]);
        $logModel->save();

        $this->messages = [];
    }

    /**
     * @param $daysToKeep
     * @return void
     */
    public function deleteOldLogs($daysToKeep): void
    {
        $date = new DateTime();
        $date->sub(new DateInterval("P{$daysToKeep}D"));
        $deleteDate = $date->format('Y-m-d H:i:s');

        $this->getResource()->deleteLogsOlderThan($deleteDate);
    }
}
