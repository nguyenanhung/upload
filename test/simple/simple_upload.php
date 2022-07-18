<?php
/**
 * Project upload
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 18/07/2022
 * Time: 23:14
 */
require_once __DIR__ . '/../../vendor/autoload.php';

use nguyenanhung\Upload\Simple\SimpleUpload;


$config = array(
    'prefixFilename' => 'Bear_',
    'uploadPath'     => realpath(__DIR__ . '/../../storage') . '/',
    'formId'         => 'fileToUpload',
    'maxFileSize'    => '5M',
    'fileExtension'  => 'jpg',
    'mediaType'      => 'image/jpeg',
);

$upload = new SimpleUpload($config);
$upload->setFormId('fileToUpload')->handleUpload();

echo "<pre>";
print_r($upload->getUploadResult());
echo "</pre>";
