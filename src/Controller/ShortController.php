<?php

namespace App\Controller;

use App\Entity\Short;
use App\Repository\ShortRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ShortController extends AbstractController
{
    /**
     * @Route("/short", name="short")
     */
    public function index(ShortRepository $shortRepo ): Response
    {
        $shorts = $shortRepo->findAll();

        return $this->json($shorts,200);
    }
    /**
     * @Route("/short/create", name="short_create" , methods={"POST"})
     */
    public function create(Request $requete, SerializerInterface $serializer , EntityManagerInterface $manager): Response
    {
        $json = $requete->getContent();

        $short = $serializer->deserialize($json, Short::class , 'json');

        $manager->persist($short);
        $manager->flush();
        return $this->json($short);
    }
    /**
     * @Route("/short/delete/{id}", name="short_delete" , methods={"DELETE"})
     */
    public function delete(EntityManagerInterface $manager , Short $short): Response{


        $manager->remove($short);
        $manager->flush();
        $reponse = "bien supprimer";
        return $this->json($reponse);
    }
}
