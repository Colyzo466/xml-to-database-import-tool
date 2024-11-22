<?php
function parseXML($filePath)
{
    if (!file_exists($filePath)) {
        error_log("Error: File $filePath not found.\n", 3, 'logs/error.log');
        return false;
    }

    libxml_use_internal_errors(true);
    $xml = simplexml_load_file($filePath);
    if (!$xml) {
        foreach (libxml_get_errors() as $error) {
            error_log("XML Error: {$error->message}\n", 3, 'logs/error.log');
        }
        libxml_clear_errors();
        return false;
    }

    return $xml;
}
