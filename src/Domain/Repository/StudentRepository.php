<?php

namespace Robso\PDO\Domain\Repository;

use Robso\PDO\Domain\Model\Student;

interface StudentRepository
{
    public function allStudents(): array;
    public function studentsBirthAt(\DateTimeInterface $birthdate): array;
    public function saveStudent(Student $student): bool;
    public function removeStudent(int $id): bool;
}