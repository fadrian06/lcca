<?php

namespace LCCA\Controllers;

use Error;
use LCCA\App;

abstract readonly class Controller
{
  /**
   * @return string File URL relative path.
   * @throws Error If file isn't provided.
   */
  final protected static function ensureThatFileIsSaved(
    string $fileParam,
    string $urlParam,
    string $fileId,
    string $destinationFolder,
    string $errorMessage
  ): string {
    $url = App::request()->data[$urlParam];
    $files = App::request()->files;
    $fileName = "$fileId.jpg";

    if (is_string($url) && $url !== '') {
      $image = file_get_contents($url);

      $filePath = [
        'rel' => "assets/images/$destinationFolder/$fileName",
        'abs' => dirname(__DIR__, 2) . "/assets/images/$destinationFolder/$fileName"
      ];

      file_put_contents($filePath['abs'], $image);

      return $filePath['rel'];
    }

    if (!$files[$fileParam]['size']) {
      throw new Error($errorMessage);
    }

    $temporalFileAbsPath = $files[$fileParam]['tmp_name'];

    $filePath = [
      'rel' => "assets/images/$destinationFolder/$fileName",
      'abs' => dirname(__DIR__, 2) . "/assets/images/$destinationFolder/$fileName"
    ];

    copy($temporalFileAbsPath, $filePath['abs']);

    return $filePath['rel'];
  }
}
