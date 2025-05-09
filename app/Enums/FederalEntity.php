<?php

namespace LCCA\Enums;

enum FederalEntity: string
{
  case Amazonas = 'Amazonas';
  case Anzoategui = 'Anzoátegui';
  case Apure = 'Apure';
  case Aragua = 'Aragua';
  case Barinas = 'Barinas';
  case Bolivar = 'Bolívar';
  case Carabobo = 'Carabobo';
  case Cojedes = 'Cojedes';
  case DeltaAmacuro = 'Delta Amacuro';
  case DistritoCapital = 'Distrito Capital';
  case Falcon = 'Falcón';
  case Guarico = 'Guárico';
  case Lara = 'Lara';
  case Merida = 'Mérida';
  case Miranda = 'Miranda';
  case Monagas = 'Monagas';
  case NuevaEsparta = 'Nueva Esparta';
  case Portuguesa = 'Portuguesa';
  case Sucre = 'Sucre';
  case Tachira = 'Táchira';
  case Trujillo = 'Trujillo';
  case Vargas = 'Vargas';
  case Yaracuy = 'Yaracuy';
  case Zulia = 'Zulia';
  case DependenciasFederales = 'Dependencias Federales';

  /** @return array<string, self[]> */
  static function casesByInitial(): array
  {
    $initials = [];

    foreach (self::cases() as $federalEntity) {
      $initials[$federalEntity->value[0]][] = $federalEntity;
    }

    return $initials;
  }

  function fullValue(): string {
    return match ($this) {
      self::DependenciasFederales, self::DistritoCapital => $this->value,
      default => "Edo. $this->value"
    };
  }
}
