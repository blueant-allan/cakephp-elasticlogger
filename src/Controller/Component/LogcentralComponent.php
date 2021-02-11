<?php

namespace ElasticLogger\Controller\Component;

use Cake\Controller\Component;
use Cake\Log\Log;

class LogcentralComponent extends Component
{
    /**
     * Available method name
     */
    const METHOD_NAME_ACTIVITY_INFO = 'activityInfo';
    const METHOD_NAME_ACTIVITY_DEBUG = 'activityDebug';
    const METHOD_NAME_ACTIVITY_ERROR = 'activityError';
    const METHOD_NAME_ACTIVITY_WARNING = 'activityWarning';
    const METHOD_NAME_ACTIVITY_NOTICE = 'activityNotice';

    /**
     * Log activity file
     */
    const LOG_ACTIVITY = 'activity';

    /**
     * Log level
     * @var int
     */
    private $logLevel;


    /**
     * process the activity log
     *
     * Available method name
     *  activityInfo
     *  activityDebug
     *  activityError
     *  activityWarning
     *  activityNotice
     *
     * Expecting 2 to 3 parameters
     *
     * First param is the Event Type
     * Second param is the Log message
     * Third param is optional is the context array
     *
     * Sample usage:
     *      $this->Logcentral->activityInfo($this->Logcentral::EVENT_LOGIN, 'sample message ' . time());
     *
     * @param string $name
     * @param array $arguments
     * @return boolean|string
     */
    public function __call(string $name, array $arguments)
    {
        if (empty($arguments) || count($arguments) === 1) {
            return 'Missing parameters';
        }

        /**
         * set the log level
         */
        switch ($name) {
            case self::METHOD_NAME_ACTIVITY_INFO:
                $this->logLevel = LOG_INFO;
                break;
            case self::METHOD_NAME_ACTIVITY_DEBUG:
                $this->logLevel = LOG_DEBUG;
                break;
            case self::METHOD_NAME_ACTIVITY_ERROR:
                $this->logLevel = LOG_ERR;
                break;
            case self::METHOD_NAME_ACTIVITY_WARNING:
                $this->logLevel = LOG_WARNING;
                break;
            case self::METHOD_NAME_ACTIVITY_NOTICE:
                $this->logLevel = LOG_NOTICE;
                break;
        }

        $eventType = empty($arguments[0]) ? 'Event' : $arguments[0];
        $message = empty($arguments[1]) ? 'Empty message' : $arguments[1];
        $context = isset($arguments[2]) ? $arguments[2] : null;

        $log = '[' . $eventType . '] ' . $message;
        if (!empty($context)) {
            $log .= ' ' . json_encode($context);
        }

        Log::write($this->logLevel, $log, ['scope' => self::LOG_ACTIVITY]);
        return true;
    }
}