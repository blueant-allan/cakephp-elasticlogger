<?php

namespace ElasticLogger;

use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use Cake\Log\Log;

/**
 * Plugin for ElasticLogger
 */
class Plugin extends BasePlugin
{
    /**
     * plugin bootstrap
     * @param PluginApplicationInterface $app
     */
    public function bootstrap(PluginApplicationInterface $app)
    {
        parent::bootstrap($app);

        /**
         * Define the Log configuration
         */
        Log::config('activity', [
            'className' => 'File',
            'path' => LOGS,
            'levels' => ['notice', 'info', 'debug', 'error'],
            'file' => 'activity',
            'scopes' => ['activity'],
        ]);
    }
}
