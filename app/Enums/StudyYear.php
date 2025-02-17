<?php

namespace LCCA\Enums;

enum StudyYear: int
{
  case First = 1;
  case Second = 2;
  case Third = 3;
  case Fourth = 4;
  case Fifth = 5;

  function isFirstYear(): bool
  {
    return $this === self::First;
  }

  function isFifthYear(): bool
  {
    return $this === self::Fifth;
  }

  function ordinalValue(): string
  {
    return match ($this) {
      self::First => 'Primer',
      self::Second => 'Segundo',
      self::Third => 'Tercer',
      self::Fourth => 'Cuarto',
      self::Fifth => 'Quinto'
    } . ' año';
  }

  function getProgressPercent(): int
  {
    return ($this->value - 1) * 20;
  }

  function isGreaterOrEqualThan(self $studyYear): bool
  {
    return $this->value >= $studyYear->value;
  }

  function isGreaterThan(self $studyYear): bool
  {
    return $this->value > $studyYear->value;
  }
}
