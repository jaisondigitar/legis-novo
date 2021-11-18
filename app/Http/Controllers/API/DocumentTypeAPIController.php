<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateDocumentTypeAPIRequest;
use App\Http\Requests\API\UpdateDocumentTypeAPIRequest;
use App\Models\DocumentType;
use App\Repositories\DocumentTypeRepository;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class DocumentTypeController.
 */
class DocumentTypeAPIController extends AppBaseController
{
    /** @var DocumentTypeRepository */
    private $documentTypeRepository;

    public function __construct(DocumentTypeRepository $documentTypeRepo)
    {
        $this->documentTypeRepository = $documentTypeRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/documentTypes",
     *      summary="Get a listing of the DocumentTypes.",
     *      tags={"DocumentType"},
     *      description="Get all DocumentTypes",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/DocumentType")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->documentTypeRepository->pushCriteria(new RequestCriteria($request));
        $this->documentTypeRepository->pushCriteria(new LimitOffsetCriteria($request));
        $documentTypes = $this->documentTypeRepository->all();

        return $this->sendResponse($documentTypes->toArray(), 'DocumentTypes retrieved successfully');
    }

    /**
     * @param CreateDocumentTypeAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/documentTypes",
     *      summary="Store a newly created DocumentType in storage",
     *      tags={"DocumentType"},
     *      description="Store DocumentType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="DocumentType that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/DocumentType")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/DocumentType"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateDocumentTypeAPIRequest $request)
    {
        $input = $request->all();

        $documentTypes = $this->documentTypeRepository->create($input);

        return $this->sendResponse($documentTypes->toArray(), 'DocumentType saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/documentTypes/{id}",
     *      summary="Display the specified DocumentType",
     *      tags={"DocumentType"},
     *      description="Get DocumentType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DocumentType",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/DocumentType"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var DocumentType $documentType */
        $documentType = $this->documentTypeRepository->find($id);

        if (empty($documentType)) {
            return Response::json(ResponseUtil::makeError('DocumentType not found'), 400);
        }

        return $this->sendResponse($documentType->toArray(), 'DocumentType retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateDocumentTypeAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/documentTypes/{id}",
     *      summary="Update the specified DocumentType in storage",
     *      tags={"DocumentType"},
     *      description="Update DocumentType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DocumentType",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="DocumentType that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/DocumentType")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/DocumentType"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateDocumentTypeAPIRequest $request)
    {
        $input = $request->all();

        /** @var DocumentType $documentType */
        $documentType = $this->documentTypeRepository->find($id);

        if (empty($documentType)) {
            return Response::json(ResponseUtil::makeError('DocumentType not found'), 400);
        }

        $documentType = $this->documentTypeRepository->update($input, $id);

        return $this->sendResponse($documentType->toArray(), 'DocumentType updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/documentTypes/{id}",
     *      summary="Remove the specified DocumentType from storage",
     *      tags={"DocumentType"},
     *      description="Delete DocumentType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DocumentType",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var DocumentType $documentType */
        $documentType = $this->documentTypeRepository->find($id);

        if (empty($documentType)) {
            return Response::json(ResponseUtil::makeError('DocumentType not found'), 400);
        }

        $documentType->delete();

        return $this->sendResponse($id, 'DocumentType deleted successfully');
    }
}
