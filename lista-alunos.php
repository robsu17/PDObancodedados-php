<?php

use Robso\PDO\Infrastructure\Persistence\ConnectionDatabase;
use Robso\PDO\Infrastructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';

$connection = ConnectionDatabase::createConnection();
$studentRepository = new PdoStudentRepository($connection);

echo print_r($studentRepository->allStudents(), true);