CREATE TABLE IF NOT EXISTS users (
  id VARCHAR(255) PRIMARY KEY,
  name VARCHAR(255) NOT NULL CHECK (LENGTH(name) >= 3),
  idCard INTEGER UNIQUE NOT NULL CHECK (idCard >= 0),
  password VARCHAR(255) NOT NULL,
  role VARCHAR(255) NOT NULL CHECK (role IN ('Administrador', 'Docente')),
  secretQuestion VARCHAR(255) NOT NULL,
  secretAnswer VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS representatives (
  id VARCHAR(255) PRIMARY KEY,
  nationality VARCHAR(1) NOT NULL CHECK (nationality IN ('V', 'V')),
  idCard INTEGER UNIQUE NOT NULL CHECK (idCard > 0),
  names VARCHAR(255) NOT NULL CHECK (LENGTH(names) >= 3),
  lastNames VARCHAR(255) NOT NULL CHECK (LENGTH(lastNames) >= 3),
  educationLevel
    VARCHAR(255)
    NOT NULL
    CHECK (educationLevel IN (
      'Inicial',
      'Secundaria',
      'Técnico Superior',
      'Universitaria'
    )),
  job VARCHAR(255) NOT NULL,
  phone VARCHAR(11) UNIQUE NOT NULL CHECK (phone LIKE '___________'),
  email VARCHAR(255) UNIQUE NOT NULL CHECK (email LIKE '%@%'),
  bankAccountNumber
    VARCHAR(20)
    UNIQUE
    NOT NULL
    CHECK (bankAccountNumber LIKE '____________________'),
  occupation VARCHAR(255) NOT NULL,
  isFamilyBoss BOOL NOT NULL,
  works BOOL NOT NULL,
  jobRole VARCHAR(255),
  companyOrInstitutionName VARCHAR(255),
  monthlyFamilyIncome DECIMAL(10, 2) NOT NULL CHECK (monthlyFamilyIncome >= 0),

  UNIQUE (names, lastNames)
);

CREATE TABLE IF NOT EXISTS students (
  id VARCHAR(255) PRIMARY KEY,
  nationality VARCHAR(1) NOT NULL CHECK (nationality IN ('V', 'E')),
  idCard INTEGER UNIQUE NOT NULL CHECK (idCard > 0),
  names VARCHAR(255) NOT NULL CHECK (LENGTH(names) >= 3),
  lastNames VARCHAR(255) NOT NULL CHECK (LENGTH(lastNames) >= 3),
  birthDate DATE NOT NULL,
  birthPlace TEXT NOT NULL,
  federalEntity VARCHAR(255) NOT NULL,
  indigenousPeople VARCHAR(255),
  stature DECIMAL(10, 1) NOT NULL,
  weight DECIMAL(10, 1) NOT NULL,
  shoeSize INTEGER NOT NULL,
  shirtSize VARCHAR(2) NOT NULL CHECK (shirtSize IN ('S', 'M', 'L', 'XL')),
  pantsSize INTEGER NOT NULL,
  laterality
    VARCHAR(255)
    NOT NULL
    CHECK (laterality IN ('Diestro', 'Zurdo', 'Ambidiestro')),
  genre VARCHAR(255) NOT NULL CHECK (genre IN ('Masculino', 'Femenino')),
  haveBicentennialCollection BOOL NOT NULL,
  haveCanaima BOOL NOT NULL,
  pendingSubjects
    VARCHAR(255)
    CHECK (pendingSubjects LIKE '["%"]' OR pendingSubjects LIKE '[]'),
  disabilities
    VARCHAR(255)
    CHECK (disabilities LIKE '["%"]' OR pendingSubjects LIKE '[]'),
  disabilityAssistance
    VARCHAR(255)
    CHECK (disabilityAssistance LIKE '["%"]' OR pendingSubjects LIKE '[]'),
  representative_id VARCHAR(255) NOT NULL,

  UNIQUE (names, lastNames),
  FOREIGN KEY (representative_id) REFERENCES representatives (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS enrollments (
  id VARCHAR(255) PRIMARY KEY,
  student_id VARCHAR(255) NOT NULL,
  studyYear VARCHAR(2) NOT NULL CHECK (studyYear >= 1 AND studyYear <= 5),
  section VARCHAR(1) NOT NULL CHECK (section IN ('A', 'B')),
  teacher VARCHAR(255) NOT NULL,
  enrollmentDate DATE NOT NULL,

  FOREIGN KEY (student_id) REFERENCES students (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);
