<?php

namespace App\Controller;


use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/category", name="category_")
 */

class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */

    public function index(EntityManagerInterface $entityManager): Response
    {

        $categories = $entityManager->getRepository(Category::class)
            ->findAll();


        return $this->render(

            'category/index.html.twig',

            ['categories' => $categories]

        );

    }
    /**
     * @Route("/{categoryName}",methods={"GET"}, name="show")
     */

    public function show(string $categoryName)
    {
        $category = $this->getDoctrine()

            ->getRepository(Category::class)

            ->findOneBy(['name' => $categoryName]);


        if (!$categoryName) {

            throw $this->createNotFoundException(

                'No program with Category : '.$categoryName.' found in program\'s table.'

            );



        }
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findByCategory($category->getId(), ['id' => 'DESC'], 3);

        return $this->render('category/show.html.twig', [

            'category' => $category,
            'programs' => $programs,

        ]);

    }



}