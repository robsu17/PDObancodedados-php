<?php

namespace Robso\PDO\Infrastructure\Repository;

use http\Exception\RuntimeException;
use PDO;
use Robso\PDO\Domain\Model\Student;
use Robso\PDO\Domain\Repository\StudentRepository;

class PdoStudentRepository implements StudentRepository
{
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function allStudents(): array
    {
        $statement = $this->connection->query('SELECT * FROM students');
        $studentDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
        $studentList = [];

        foreach ($studentDataList as $studentData) {
            $studentList[] = new Student(
                $studentData['id'],
                $studentData['name'],
                new \DateTimeImmutable($studentData['birth_date'])
            );
        }

        return $studentList;
    }

    public function studentsBirthAt(\DateTimeInterface $birthdate): array
    {
        $statement = $this->connection->query('SELECT * FROM students');
        $studentDataList = $statement->fetchAll(PDO::FETCH_ASSOC);

        return array_filter($studentDataList, function ($student) use ($birthdate) {
            return $student['birth_date'] === $birthdate->format('Y-m-d');
        });
    }

    public function saveStudent(Student $student): bool
    {
        $statement = $this->connection->prepare('INSERT INTO students (name, birth_date) VALUES (:name, :birth_date)');

        if (!$statement) {
            throw new RuntimeException($this->connection->errorInfo()[2]);
        }

        return $statement->execute([
            ':name' => $student->getName(),
            ':birth_date' => $student->getBirthDate()
        ]);
    }

    public function removeStudent(int $id): bool
    {
        $statement = $this->connection->prepare('DELETE FROM students WHERE id = ?;');
        $statement->bindValue(1, $id, PDO::PARAM_INT);
        return $statement->execute();
    }
}