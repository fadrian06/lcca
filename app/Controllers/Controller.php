<?php

namespace LCCA\Controllers;

use Error;
use LCCA\App;
use Leaf\Anchor;
use Leaf\Flash;
use Throwable;

abstract readonly class Controller
{
  protected object $data;

  function __construct()
  {
    $this->data = (object) Anchor::sanitize(App::request()->data->getData());
  }

  /** @return object|never */
  function getValidatedData(array $validationSet): object
  {
    $validated = form()->validate((array) $this->data, $validationSet);

    if (!$validated) {
      $errors = form()->errors();

      foreach ($errors as &$error) {
        $error = str_replace('_', ' ', $error);
      }

      Flash::set($errors, 'errors');
      Flash::set($this->data, 'lastData');
      App::redirect(App::request()->referrer);

      exit;
    }

    return (object) $validated;
  }

  /**
   * @template TReturn
   * @param callable(): TReturn $callable
   * @return TReturn|never
   */
  function tryOfFail(callable $callable): mixed
  {
    try {
      return $callable();
    } catch (Throwable $exception) {
      Flash::set([__METHOD__ => $exception->getMessage()], 'errors');
      Flash::set($this->data, 'lastData');
      App::redirect(App::request()->referrer);

      exit;
    }
  }

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

    if ($files[$fileParam]['size'] === 0) {
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
