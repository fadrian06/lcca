<?php

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ExampleUnitTest extends TestCase
{
  #[Test]
  function example_test(): void
  {
    self::assertTrue(true);
  }
}
