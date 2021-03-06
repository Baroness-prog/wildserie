<?php

namespace App\Controller;

use App\Entity\Program;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/program", name="program_")
 */
Class ProgramController extends AbstractController

{
    /**
     * @Route("/", name="index")
     */

    public function index(EntityManagerInterface $entityManager): Response

    {

        $programs = $entityManager->getRepository(Program::class)
            ->findAll();


        return $this->render(

            'program/index.html.twig',

            ['programs' => $programs]

        );

    }

    /**
     * @Route("/{id}",requirements={"id"="\d+"}, methods={"GET"}, name="show")
     */
    public function show(int $id): Response
    {

        $program = $this->getDoctrine()

            ->getRepository(Program::class)

            ->findOneBy(['id' => $id]);


        if (!$program) {

            throw $this->createNotFoundException(

                'No program with id : '.$id.' found in program\'s table.'

            );

        }

        return $this->render('program/show.html.twig', [

            'program' => $program,

        ]);

    }

}