<?php
defined('AUTOUPDATER_LIB') or die;

AutoUpdater_Loader::loadClass('Command_Base');

foreach (new DirectoryIterator(AUTOUPDATER_LIB_PATH . 'Command') as $file_info) {
    if (!$file_info->isFile() || $file_info->getExtension() !== 'php') {
        continue;
    }

    $command = strtolower($file_info->getBasename('.php'));
    if ($command === 'base') {
        continue;
    }

    $class_name = AutoUpdater_Loader::loadClass('Command_' . $file_info->getBasename('.php'));
    WP_CLI::add_command('autoupdater ' . $command, $class_name, array(
        'before_invoke' => $class_name . '::beforeInvoke'
    ));
}
