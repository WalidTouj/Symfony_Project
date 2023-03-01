<?php

namespace App\Controller;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{

    #[Route('/student', name: 'app_student')]
    public function listStudent(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Student::class);
        $students = $repo->findAll();
        return $this->render('student/index.html.twig', [
            'students' => $students
        ]);
    }

    #[Route('/addStudent', name: 'add_student')]
    public function index(): Response
    {
        return $this->render('student/addStudent.html.twig');
    }

    #[Route('/studentadded', name: 'student_added')]
    public function addStudent(StudentRepository $repo): Response
    {
        $student = new Student();
        $student->setEmail($_POST["email"]);
        $repo->save($student, true);
        return $this->redirectToRoute('app_student');
    }
    #[Route('/updatestudent/{id}', name: 'update_student')]
    public function index1($id): Response
    {
        return $this->render('student/modifyStudent.html.twig', [
            'id' => $id
        ]);
    }
    #[Route('/studentupdated/{id}', name: 'student_update')]
    public function UpdateStudent($id, StudentRepository $repo, ManagerRegistry $doctrine): Response
    {
        $student = $repo->find($id);
        $student->setEmail($_POST["email"]);
        $entitymanager = $doctrine->getManager();
        $entitymanager->flush();
        return $this->redirectToRoute('app_student');
    }
    #[Route('/removestudent/{id}', name: 'remove_student')]
    public function removeStudent($id, StudentRepository $repo): Response
    {
        $student = $repo->find($id);
        $repo->remove($student, true);
        return $this->redirectToRoute('app_student');
    }
}
