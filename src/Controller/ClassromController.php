<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassromController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function list(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Classroom::class);
        $classrooms = $repo->findAll();
        return $this->render('classrom/index.html.twig', [
            'controller_name' => 'ClassromController',
            'classrooms' => $classrooms
        ]);
    }
    #[Route('/addclassroom', name: 'add_classroom')]
    public function index(): Response
    {
        return $this->render('classrom/addClassroom.html.twig');
    }
    #[Route('/classroomadded', name: 'classroom_added')]
    public function addClassroom(ClassroomRepository $repo): Response
    {
        $classroom = new Classroom();
        $classroom->setName($_POST["name"]);
        $repo->save($classroom, true);
        return $this->redirectToRoute('app_classroom');
    }
    #[Route('/updateclassroom/{id}', name: 'update_classroom')]
    public function index1($id): Response
    {
        return $this->render('classrom/modifyClassroom.html.twig', [
            'id' => $id
        ]);
    }
    #[Route('/classroomupdated/{id}', name: 'classroom_update')]
    public function UpdateClassroom($id, ClassroomRepository $repo, ManagerRegistry $doctrine): Response
    {
        $classroom = $repo->find($id);
        $classroom->setName($_POST["name"]);
        $entitymanager = $doctrine->getManager();
        $entitymanager->flush();
        return $this->redirectToRoute('app_classroom');
    }
    #[Route('/removeclassroom/{id}', name: 'remove_classroom')]
    public function removeClassroom($id, ClassroomRepository $repo): Response
    {
        $classroom = $repo->find($id);
        $repo->remove($classroom, true);
        return $this->redirectToRoute('app_classroom');
    }
}
