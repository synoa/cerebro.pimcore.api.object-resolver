<?php

namespace ApiProductsBundle\Controller;

use CoreShop\Bundle\ProductBundle\Pimcore\Repository\ProductRepository;
use CoreShop\Component\Core\Repository\ProductRepositoryInterface;
use Pimcore\Bundle\AdminBundle\Controller\Rest\Element\AbstractElementController;
use Pimcore\Model\DataObject;
use Pimcore\Model\Webservice\Data\Mapper;
use Pimcore\Model\Webservice\Service;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractElementController
{
//    protected $repository;

    public function __construct(Service $service)
    {
        parent::__construct($service);
    }

    /**
     * @Route("/webservice/rest/synoa/objects")
     */
    public function indexAction(Request $request, ValidatorInterface $validator)
    {
        // check permission on admin session or api key
        $this->checkPermission('objects');

        // getting request params and setting default values
        $requestParams = array(
            'objectClass' => $request->get('objectClass', ""),
            'last_modified' => $request->get('last_modified', "0"),
            'offset' => $request->get('offset', "0"),
            'limit' => $request->get('limit', "10"),
        );

        // setting up validation constraints
        $constraints = new Assert\Collection([
            'objectClass' => [
                new Assert\NotBlank()
            ],
            'last_modified' => [
                new Assert\GreaterThanOrEqual(0),
                new Assert\Type('digit')
            ],
            'offset' => [
                new Assert\GreaterThanOrEqual(0),
                new Assert\Type('digit')
            ],
            'limit' => [
                new Assert\GreaterThan(0),
                new Assert\LessThanOrEqual(100),
                new Assert\Type('digit')
            ]
        ]);

        // validate
        $validationErrors = $validator->validate($requestParams, $constraints);

        // check on validation errors
        if (count($validationErrors) > 0) {
            $messages = array();

            foreach ($validationErrors as $validationError) {
                $messages[] = $validationError->getPropertyPath() . ': ' . $validationError->getMessage();
            }
            return $this->createErrorResponse(array('msg' => 'Validation Error', 'data' => $messages), Response::HTTP_BAD_REQUEST);
        }

        // getting products
        $objectClassName = '\\Pimcore\\Model\\DataObject\\' . ucfirst($requestParams['objectClass']);
        if (!\Pimcore\Tool::classExists($objectClassName)) {
            return $this->createErrorResponse(array('msg' => 'object class does not exist'), Response::HTTP_BAD_REQUEST);
        }

        $listClassName = $objectClassName . '\\Listing';

        $entries = new $listClassName;
        $entries->addConditionParam('o_modificationDate > ?', $requestParams['last_modified']);
        $entries->setLimit($requestParams['limit']);
        $entries->setOffset($requestParams['offset']);
        $products = $entries->load();

        // init data
        $mappedProducts = array();

        // map every product
        foreach ($products as $product) {
            // load all data (eg. lazy loaded fields like relational data types ...)
            //Service::loadAllObjectFields($product);

            $mappedProducts[] = Mapper::map($product, '\\Pimcore\\Model\\Webservice\\Data\\DataObject\\Concrete\\Out', 'out');
        }

        // create the response
        return $this->createCollectionSuccessResponse($mappedProducts);
    }
}
