<?php
namespace App\Controller;

use App\Entity\Option;
use App\Entity\ProductOption;
use App\Repository\OptionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function store(Request $request, OptionRepository $optionRepository, ValidatorInterface $validator): Response
    {
        $serializer = SerializerBuilder::create()->build();
        $data = $request->toArray();
        $product = new Product();
        if(array_key_exists('title', $data))$product->setTitle($data['title']);
        if(array_key_exists('qty', $data))$product->setQty($data['qty']);
        if(array_key_exists('price', $data))$product->setPrice($data['price']);
        $errors = $validator->validate($product);
        if(count($errors) != 0){
            return new Response(
                $serializer->serialize(
                    [
                        "errors" => $errors
                    ], 'json'),
                Response::HTTP_OK,
                ['Content-Type' => 'application/json']
            );
        }
        $this->getDoctrine()->getManager()->persist($product);
        $this->getDoctrine()->getManager()->flush();
        if(array_key_exists('options', $data)) {
            foreach ($data['options'] as $option){
                if(array_key_exists('id', $option) && array_key_exists('value', $option)){
                    $productOption = new ProductOption();
                    $productOption->setProductId($product);
                    $productOption->setOptionId($optionRepository->find($option['id']));
                    $productOption->setValue($option['value']);
                    $errors = $validator->validate($productOption);
                    if(count($errors) != 0){
                        return new Response(
                            $serializer->serialize(
                                [
                                    "errors" => $errors
                                ], 'json'),
                            Response::HTTP_OK,
                            ['Content-Type' => 'application/json']
                        );
                    }
                    $this->getDoctrine()->getManager()->persist($productOption);
                    $this->getDoctrine()->getManager()->flush();
                }
            }
        }
        return new Response(
            $serializer->serialize($this->getDoctrine()
                ->getRepository(Product::class)
                ->find($product->getId()), 'json'),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * @Route("/update/{id}", methods={"PUT"}, requirements={"id"="\d+"})
     */
    public function update(Request $request, int $id, OptionRepository $optionRepository, ValidatorInterface $validator): Response
    {
        $serializer = SerializerBuilder::create()->build();
        $data = $request->toArray();
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);
        if (!$product) {
            return new JsonResponse([
                "message" => "Product doesn't exist"
            ]);
        }
        if(array_key_exists('title', $data))$product->setTitle($data['title']);
        if(array_key_exists('qty', $data))$product->setQty($data['qty']);
        if(array_key_exists('price', $data))$product->setPrice($data['price']);
        $errors = $validator->validate($product);
        if(count($errors) != 0){
            return new Response(
                $serializer->serialize(
                    [
                        "errors" => $errors
                    ], 'json'),
                Response::HTTP_OK,
                ['Content-Type' => 'application/json']
            );
        }
        $this->getDoctrine()->getManager()->persist($product);
        $this->getDoctrine()->getManager()->flush();
        foreach($product->getProductOptions() as $productOption){
            $optionRepository->find($productOption->getOptionId()->removeProductOption($productOption));
            $product->removeProductOption($productOption);
        }
        if(array_key_exists('options', $data)) {
            foreach ($data['options'] as $option){
                if(array_key_exists('id', $option) && array_key_exists('value', $option)){
                    $productOption = new ProductOption();
                    $productOption->setProductId($product);
                    $productOption->setOptionId($optionRepository->find($option['id']));
                    $productOption->setValue($option['value']);
                    $errors = $validator->validate($productOption);
                    if(count($errors) != 0){
                        return new Response(
                            $serializer->serialize(
                                [
                                    "errors" => $errors
                                ], 'json'),
                            Response::HTTP_OK,
                            ['Content-Type' => 'application/json']
                        );
                    }
                    $this->getDoctrine()->getManager()->persist($productOption);
                    $this->getDoctrine()->getManager()->flush();
                }
            }
        }
        return new Response(
            $serializer->serialize($this->getDoctrine()
                ->getRepository(Product::class)
                ->find($product->getId()), 'json'),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * @Route("/delete/{id}", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, int $id): Response
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);
        if (!$product) {
            return new JsonResponse([
                "message" => "Product doesn't exist"
            ]);
        }
        $this->getDoctrine()->getManager()->remove($product);
        $this->getDoctrine()->getManager()->flush();
        return new JsonResponse([
            "message" => "Product has been deleted"
        ]);
    }
}
