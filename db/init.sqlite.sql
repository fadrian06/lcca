CREATE TABLE IF NOT EXISTS users (
  id VARCHAR(255) PRIMARY KEY,
  name VARCHAR(255) NOT NULL CHECK (LENGTH(name) >= 3),
  idCard INTEGER UNIQUE NOT NULL CHECK (idCard >= 0),
  password VARCHAR(255) NOT NULL,
  role VARCHAR(255) NOT NULL CHECK (role IN ('Coordinador', 'Docente')),
  signature BLOB UNIQUE,
  secretQuestion VARCHAR(255) NOT NULL,
  secretAnswer VARCHAR(255) NOT NULL,
  deletedDate DATE
);

CREATE TABLE IF NOT EXISTS subjects (
  id VARCHAR(255) PRIMARY KEY,
  name VARCHAR(255) UNIQUE NOT NULL,
  imageUrl VARCHAR(255) UNIQUE,
  deletedDate DATE
);

CREATE TABLE IF NOT EXISTS representatives (
  id VARCHAR(255) PRIMARY KEY,
  nationality VARCHAR(1) NOT NULL CHECK (nationality IN ('V', 'E')),
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
  hasBicentennialCollection BOOL NOT NULL,
  hasCanaima BOOL NOT NULL,
  disabilities
    VARCHAR(255)
    CHECK (disabilities LIKE '["%"]' OR disabilities LIKE '[]'),
  disabilityAssistance
    VARCHAR(255)
    CHECK (disabilityAssistance LIKE '["%"]' OR disabilityAssistance LIKE '[]'),
  graduatedDate DATE,
  retiredDate DATE,

  UNIQUE (names, lastNames)
);

CREATE TABLE IF NOT EXISTS representativeHistory (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  student_id VARCHAR(255) NOT NULL,
  representative_id VARCHAR(255) NOT NULL,

  FOREIGN KEY (student_id) REFERENCES students (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (representative_id) REFERENCES representatives (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS pendingSubjects (
  student_id VARCHAR(255) NOT NULL,
  subject_id VARCHAR(255) NOT NULL,

  FOREIGN KEY (student_id) REFERENCES students (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (subject_id) REFERENCES subjects (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS enrollments (
  id VARCHAR(255) PRIMARY KEY,
  student_id VARCHAR(255) NOT NULL,
  teacher_id VARCHAR(255) NOT NULL,
  studyYear INTEGER NOT NULL CHECK (studyYear >= 1 AND studyYear <= 5),
  section VARCHAR(1) NOT NULL CHECK (section IN ('A', 'B')),
  enrollmentDate DATE NOT NULL,

  FOREIGN KEY (student_id) REFERENCES students (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (teacher_id) REFERENCES users (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS notes (
  student_id VARCHAR(255) NOT NULL,
  subject_id VARCHAR(255) NOT NULL,
  studyYear INTEGER NOT NULL CHECK (studyYear >= 1 AND studyYear <= 5),
  note INTEGER NOT NULL CHECK (note >= 0 AND note <= 20),

  FOREIGN KEY (student_id) REFERENCES students (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (subject_id) REFERENCES subjects (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

INSERT INTO subjects (id, name, imageUrl) VALUES
('674204999c288', 'Castellano', './assets/images/subjects/espanol.png'),
('67420503ba72e', 'Inglés Y Otras Lenguas Lenguas Extranjeras', './assets/images/subjects/ingles.png'),
('67420520bdc89', 'Matemáticas', './assets/images/subjects/matematicas.png'),
('6742052bcc962', 'Educación Física', './assets/images/subjects/educacion-fisica.png'),
('6742053decd27', 'Arte y Patrimonio', './assets/images/subjects/arte.png'),
('67420550e8b15', 'Ciencias Naturales', './assets/images/subjects/ciencias.avif'),
('6742055ad2dbc', 'Geografía, Historia Y Ciudadanía', './assets/images/subjects/geografia.png'),
('674205840178d', 'Física', './assets/images/subjects/fisica.png'),
('6742058d05fe1', 'Química', './assets/images/subjects/laboratorio.png'),
('67420594e677e', 'Biología', './assets/images/subjects/biologia.png'),
('6742059cddca5', 'Formación Para La Soberanía Nacional', './assets/images/subjects/soberania.png'),
('674205bd9d8ce', 'Ciencias De La Tierra', './assets/images/subjects/tierra.png');
