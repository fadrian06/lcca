<?php

namespace LCCA\Enums;

enum Genre: string
{
  case Male = 'Masculino';
  case Female = 'Femenino';

  function isMale(): bool
  {
    return $this === self::Male;
  }

  function isFemale(): bool
  {
    return $this === self::Female;
  }
}
