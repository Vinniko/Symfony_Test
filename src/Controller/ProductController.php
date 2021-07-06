<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
    * @Route("/products", methods={"GET"})
    */
    public function index(Request $request): Response
    {
        $number = random_int(0, 100);

        return $this->render('product/product.html.twig', [
            'number' => $number,
        ]);
    }

    /**
     * @Route("/show/{id}", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Request $request): Response
    {
        $number = random_int(0, 100);

        return $this->render('product/product.html.twig', [
            'number' => $number,
        ]);
    }

    /**
     * @Route("/store", methods={"POST"})
     */
    public function store(Request $request): Response
    {
        $number = random_int(0, 100);

        return $this->render('product/product.html.twig', [
            'number' => $number,
        ]);
    }

    /**
     * @Route("/update/{id}", methods={"PUT"}, requirements={"id"="\d+"})
     */
    public function update(Request $request): Response
    {
        $number = random_int(0, 100);

        return $this->render('product/product.html.twig', [
            'number' => $number,
        ]);
    }

    /**
     * @Route("/delete/{id}", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request): Response
    {
        $number = random_int(0, 100);

        return $this->render('product/product.html.twig', [
            'number' => $number,
        ]);
    }
}
