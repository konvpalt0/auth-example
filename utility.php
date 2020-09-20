<?php


function gen_uuid()
{
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),

        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

function startsWith($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}

function upload_image($image, $folder)
{
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid
    if (!isset($image["error"]) || is_array($image["error"])) {
        throw new RuntimeException("Invalid parameters.");
    }

    //Check $image["error"] value.
    switch ($image["error"]) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException("No file sent.");
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException("Exceeded filesize limit.");
        default:
            throw new RuntimeException("Unknow errors.");
    }

    // You should also check filesize here.
    if ($image["size"] > 1000000) {
        throw new RuntimeException("Exceeded filesize limit");
    }

    //DO NOT TRUST $image["mime"] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($image["tmp_name"]);
    $valid_image_types = [
        "jpg" => "image/jpeg",
        "png" => "image/png",
        "gif" => "image/gif"
    ];

    if (($ext = array_search($mime_type, $valid_image_types, true)) === false) {
        throw new RuntimeException("Invalid file format.");
    }

    // You should name it uniquely.
    // DO NOT USE $image["name"] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.

    $filename = sprintf("$folder/%s.%s", sha1_file($image["tmp_name"]), $ext);
    if (!move_uploaded_file($image["tmp_name"], $filename)) {
        throw new RuntimeException("Failed to move uploaded file.");
    }

    return $filename;
}