<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDocumentModelsAPIRequest;
use App\Http\Requests\API\UpdateDocumentModelsAPIRequest;
use App\Models\DocumentModels;
use App\Repositories\DocumentModelsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class DocumentModelsController
 * @package App\Http\Controllers\API
 */

class DocumentModelsAPIController extends AppBaseController
{
    /** @var  DocumentModelsRepository */
    private $documentModelsRepository;

    public function __construct(DocumentModelsRepository $documentModelsRepo)
    {
        $this->documentModelsRepository = $documentModelsRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/documentModels",
     *      summary="Get a listing of the DocumentModels.",
     *      tags={"DocumentModels"},
     *      description="Get all DocumentModels",
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
     *                  @SWG\Items(ref="#/definitions/DocumentModels")
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
        $this->documentModelsRepository->pushCriteria(new RequestCriteria($request));
        $this->documentModelsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $documentModels = $this->documentModelsRepository->all();

        return $this->sendResponse($documentModels->toArray(), 'DocumentModels retrieved successfully');
    }

    /**
     * @param CreateDocumentModelsAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/documentModels",
     *      summary="Store a newly created DocumentModels in storage",
     *      tags={"DocumentModels"},
     *      description="Store DocumentModels",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="DocumentModels that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/DocumentModels")
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
     *                  ref="#/definitions/DocumentModels"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateDocumentModelsAPIRequest $request)
    {
        $input = $request->all();

        $documentModels = $this->documentModelsRepository->create($input);

        return $this->sendResponse($documentModels->toArray(), 'DocumentModels saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/documentModels/{id}",
     *      summary="Display the specified DocumentModels",
     *      tags={"DocumentModels"},
     *      description="Get DocumentModels",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DocumentModels",
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
     *                  ref="#/definitions/DocumentModels"
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
        /** @var DocumentModels $documentModels */
        $documentModels = $this->documentModelsRepository->find($id);

        if (empty($documentModels)) {
            return Response::json(ResponseUtil::makeError('DocumentModels not found'), 400);
        }

        return $this->sendResponse($documentModels->toArray(), 'DocumentModels retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateDocumentModelsAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/documentModels/{id}",
     *      summary="Update the specified DocumentModels in storage",
     *      tags={"DocumentModels"},
     *      description="Update DocumentModels",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DocumentModels",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="DocumentModels that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/DocumentModels")
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
     *                  ref="#/definitions/DocumentModels"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateDocumentModelsAPIRequest $request)
    {
        $input = $request->all();

        /** @var DocumentModels $documentModels */
        $documentModels = $this->documentModelsRepository->find($id);

        if (empty($documentModels)) {
            return Response::json(ResponseUtil::makeError('DocumentModels not found'), 400);
        }

        $documentModels = $this->documentModelsRepository->update($input, $id);

        return $this->sendResponse($documentModels->toArray(), 'DocumentModels updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/documentModels/{id}",
     *      summary="Remove the specified DocumentModels from storage",
     *      tags={"DocumentModels"},
     *      description="Delete DocumentModels",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DocumentModels",
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
        /** @var DocumentModels $documentModels */
        $documentModels = $this->documentModelsRepository->find($id);

        if (empty($documentModels)) {
            return Response::json(ResponseUtil::makeError('DocumentModels not found'), 400);
        }

        $documentModels->delete();

        return $this->sendResponse($id, 'DocumentModels deleted successfully');
    }
}
