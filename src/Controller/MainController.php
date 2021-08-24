<?php

namespace App\Controller;

use App\Entity\ItemEntity;
use App\Entity\OfferEntity;
use App\Repository\ItemEntityRepository;
use App\Repository\OfferEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;

/**
 * @Route ("/api")
 **/
class MainController extends AbstractController{
    private $offerEntityRepository;
    private $itemEntityRepository;
    /**@var EntityManagerInterface**/
    private $entityManager;
    public function __construct(OfferEntityRepository $repository,ItemEntityRepository $itemRepository, EntityManagerInterface $entityManager){
        $this->offerEntityRepository = $repository;
        $this->itemEntityRepository= $itemRepository;
        $this->entityManager = $entityManager;
        $this->entityManager->getRepository(OfferEntity::class);
        $this->entityManager->getRepository(ItemEntity::class);
    }
    /**
     * @Route("/main", name="main")
     */
    public function index(): Response
    {
        $offer = $this->offerEntityRepository->findOneBy(['id'=>1]);
        $item = $this->itemEntityRepository->findOneBy(['id'=>1]);
        $collect = $offer->getItems();
        return $this->render('page.html.twig', [
            'offer'=> $offer,
            'items'=>$collect,
        ]);
    }
    /**
     * @Route ("/offers/", name="get_all_offers", methods={"GET"})
     **/
    public function getOffers():JsonResponse{
        $offers = $this->offerEntityRepository->findAll();
        $data = [];
        foreach ($offers as $offer){
            $data[]=[
                'id'=>$offer->getId(),
                'name'=>$offer->getManager()
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }
    /**
     * @Route("/offers/{id}", name="get_offer", methods={"GET"})
     **/
    public function getOffer($id):JsonResponse{
        $offer = $this->offerEntityRepository->findOneBy(['id'=>$id]);
        if($offer){
            $data=[
                'id'=>$offer->getId(),
                'name'=>$offer->getManager()
            ];
            return new JsonResponse($data, Response::HTTP_OK);
        }
        return new JsonResponse(['error'=>'Offer not found!'],Response::HTTP_NOT_FOUND);
    }
    /**
     * @Route("/offers/create", name="create_offer", methods={"POST"})
     **/
    public function createOffer(Request $request):JsonResponse{
        $offer = new OfferEntity();
        $constraints = new Collection([
            'b24_contact_id'=>[new NotBlank()],
            'b24_deal_id'=>[new NotBlank()],
            'b24_manager_id'=>[new NotBlank()],
            'manager'=>[new NotBlank()],
            'position'=>[new NotBlank()],
            'phone'=>[new NotBlank()],
            'avatar'=>[new NotBlank()],
            'status'=>[new NotBlank()],
            'date_end'=>[new NotBlank()],
            'createAt'=>[new NotBlank()],
        ]);
        $res = json_encode($request->query->all());
        $validator = Validation::createValidator();
        $errors = $validator->validate(json_decode($res, true), $constraints);
        if(count($errors) > 0){
            $message = "The attempt of providing parameters leads the following issues (".count($errors)."):";
            foreach ($errors as $error) {
                $message.= $error;
            }
            return new JsonResponse(["error"=>$message],Response::HTTP_NOT_ACCEPTABLE);
        }
        else{
            $offer->setB24ContactId($request->get('b24_contact_id'));
            $offer->setB24DealId($request->get('b24_deal_id'));
            $offer->setB24ManagerId($request->get('b24_manager_id'));
            $offer->setManager($request->get('manager'));
            $offer->setPosition($request->get('position'));
            $offer->setAvatar($request->get('avatar'));
            $offer->setPhone($request->get('phone'));
            $offer->setStatus($request->get('status'));
            $offer->setDateEnd( \DateTime::createFromFormat("Y-m-d",$request->get('date_end')));
            $offer->setCreateAt(\DateTime::createFromFormat("Y-m-d H:i:s",$request->get('createAt')));
            $this->entityManager->persist($offer);
            $this->entityManager->flush();
        }
        return new JsonResponse(["status"=>"Offer has been created successfully!"],Response::HTTP_OK);
    }
    /**
     * @Route("/offers/change/{id}", name="change_offer", methods={"PATCH"})
     **/
    public function changeOffer($id, Request $request):JsonResponse{
        $offer = $this->offerEntityRepository->findOneBy(['id'=>$id]);
        if($offer){
            $params = $request->query->all();
            foreach ($params as $param => $value) {
                switch ($param){
                    case 'b24_manager_id':
                        $offer->setB24ManagerId($value);break;
                    case 'manager':
                        $offer->setManager($value);break;
                    case 'position':
                        $offer->setPosition($value);break;
                    case 'avatar':
                        $offer->setAvatar($value);break;
                    case 'status':
                        $offer->setStatus($value);break;
                    case 'date_end':
                        $offer->setDateEnd($value);break;
                    default:break;
                }
            }
            $this->entityManager->persist($offer);
            $this->entityManager->flush();
            return new JsonResponse(['status'=>'Offer has been patched!'], Response::HTTP_OK);
        }
        return new JsonResponse(['error'=>'Offer not found!'],Response::HTTP_NOT_FOUND);
    }
    /**
     * @Route("/offers/delete/{id}", name="drop_offer", methods={"DELETE"})
     **/
    public function deleteOffer($id):JsonResponse{
        $offer = $this->offerEntityRepository->findOneBy(['id'=>$id]);
        if($offer){
            $this->entityManager->remove($offer);
            $this->entityManager->flush();
            return new JsonResponse(['status'=>'offer has been deleted successfully!'],Response::HTTP_OK);
        }
        return new JsonResponse(['error'=>'couldn`t find offer with provided parameter'],Response::HTTP_NOT_FOUND);
    }
    /**
     * @Route("/items/create/", name="create_item", methods={"POST"})
     **/
    public function createItem(Request $request):JsonResponse{
        $item = new ItemEntity();
        $offer = $this->offerEntityRepository->findOneBy(['id'=>$request->get('offer_id')]);
        if(isset($offer)){
            $item->setOffer($offer);
            $item->setCid($request->get('cid'));
            $item->setType($request->get('type'));
            $item->setSquare($request->get('square'));
            $item->setComplex($request->get('complex'));
            $item->setHouse($request->get('house'));
            $item->setDescription($request->get('description'));
            $item->setImages(json_decode($request->get('images')));
            $item->setLiked(false);
            $this->entityManager->persist($item);
            $this->entityManager->flush();
            return new JsonResponse(['status'=>'g2g'],Response::HTTP_OK);
        }
        return new JsonResponse(['error'=>'bad data, check it out'],Response::HTTP_NOT_FOUND);
    }
    /**
     * @Route("/items/delete/{id}", name="drop_item", methods={"DELETE"})
     **/
    public function deleteItem($id, Request $request):JsonResponse{
        $item = $this->itemEntityRepository->findOneBy(['id'=>$id]);
        if($item){
            $this->entityManager->remove($item);
            $this->entityManager->flush();
            return new JsonResponse(['status'=>'item has been deleted successfully!'],Response::HTTP_OK);
        }
        return new JsonResponse(['error'=>'couldn`t find item with provided parameter'],Response::HTTP_NOT_FOUND);
    }
}
