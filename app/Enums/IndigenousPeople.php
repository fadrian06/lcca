<?php

namespace LCCA\Enums;

enum IndigenousPeople: string
{
  case Arawacos = 'Arawacos';
  case Caribes = 'Caribes';
  case Guajiros = 'Guajiros';
  case Pemones = 'Pemones';
  case Timotocuicas = 'Timotocuicas';
  case Yanomamis = 'Yanomamis';
  case Wayuus = 'Wayúus';
  case Waraos = 'Waraos';
  case Yukpas = 'Yukpas';
  case Piaroas = 'Piaroas';
  case Baris = 'Barís';
  case Karinas = 'Kariñas';
  case Panares = 'Panares';
  case Pumes = 'Pumés';
  case Makiritares = 'Makiritares';

  /** @return string[] */
  static function valuesSorted(): array
  {
    $values = array_map(
      fn(self $indigenousPeople): string => $indigenousPeople->value,
      self::cases()
    );

    sort($values);

    return $values;
  }
}
