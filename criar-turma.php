<?php

require_once 'vendor/autoload.php';

use Robso\PDO\Domain\Model\Student;
use Robso\PDO\Infrastructure\Persistence\ConnectionDatabase;
use Robso\PDO\Infrastructure\Repository\PdoStudentRepository;

$connection = ConnectionDatabase::createConnection();
$studentRepository = new PdoStudentRepository($connection);

$connection->beginTransaction();

try {
    $aStudent = new Student(
        null,
        'Nico Francisco',
        new DateTimeImmutable('1985-05-01')
    );
    $studentRepository->saveStudent($aStudent);

    $bStudent = new Student(
        null,
        'Hamilton',
        new DateTimeImmutable('1985-05-01')
    );
    $studentRepository->saveStudent($bStudent);

    $connection->commit();
} catch (RuntimeException $e) {
    echo $e->getMessage();
    $connection->rollBack();
}
