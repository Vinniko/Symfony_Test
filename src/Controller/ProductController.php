<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializerBuilder;
/**
 * @Route("/api/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/index/{page}", methods={"GET"}, defaults={"page": 1})
     */
    public function index(Request $request, int $page): Response
    {
        $latestProducts = $this->getDoctrine()
                ->getRepository(Product::class)
                ->findLatest($page, 3);
        $serializer = SerializerBuilder::create()->build();
        return new Response(
            $serializer->serialize($latestProducts, 'json'),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * @Route("/filter/{page}", methods={"GET"}, defaults={"page": 1})
     */
    public function filter(Request $request, int $page): Response
    {
        $data = $request->toArray();
        if(array_key_exists('filters', $data)){
            $filters = $data['filters'];
        }
        $filteredProducts =  $this->getDoctrine()
            ->getRepository(Product::class)
            ->findByFilter($page, 3, $filters);
        $serializer = SerializerBuilder::create()->build();
        return new Response(
            $serializer->serialize($filteredProducts, 'json'),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * @Route("/show/{id}", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Request $request, int $id): Response
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);
        if (!$product) {
            return new JsonResponse([
                "message" => "Product doesn't exist"
            ]);
        }
        $serializer = SerializerBuilder::create()->build();
        return new Response(
            $serializer->serialize($product, 'json'),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * @Route("/store", methods={"POST"})
     */
    public function store(Request $request): Response
    {
        $number = random_int(0, 100);
        #$product = new Product();
        #$product->set(...
        /*$errors = $validator->validate($product);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }*/
        return $this->render('product/product.html.twig', [
            'number' => $number,
        ]);
    }

    /**
     * @Route("/update/{id}", methods={"PUT"}, requirements={"id"="\d+"})
     */
    public function update(Request $request, int $id): Response
    {
        $number = random_int(0, 100);

        return $this->render('product/product.html.twig', [
            'number' => $number,
        ]);
    }

    /**
     * @Route("/delete/{id}", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, int $id): Response
    {
        $number = random_int(0, 100);

        return $this->render('product/product.html.twig', [
            'number' => $number,
        ]);
    }
}
