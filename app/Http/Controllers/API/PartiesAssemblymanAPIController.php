<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreatePartiesAssemblymanAPIRequest;
use App\Http\Requests\API\UpdatePartiesAssemblymanAPIRequest;
use App\Models\PartiesAssemblyman;
use App\Repositories\PartiesAssemblymanRepository;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class PartiesAssemblymanController.
 */
class PartiesAssemblymanAPIController extends AppBaseController
{
    /** @var PartiesAssemblymanRepository */
    private $partiesAssemblymanRepository;

    public function __construct(PartiesAssemblymanRepository $partiesAssemblymanRepo)
    {
        $this->partiesAssemblymanRepository = $partiesAssemblymanRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/partiesAssemblymen",
     *      summary="Get a listing of the PartiesAssemblymen.",
     *      tags={"PartiesAssemblyman"},
     *      description="Get all PartiesAssemblymen",
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
     *                  @SWG\Items(ref="#/definitions/PartiesAssemblyman")
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
        $this->partiesAssemblymanRepository->pushCriteria(new RequestCriteria($request));
        $this->partiesAssemblymanRepository->pushCriteria(new LimitOffsetCriteria($request));
        $partiesAssemblymen = $this->partiesAssemblymanRepository->all();

        return $this->sendResponse($partiesAssemblymen->toArray(), 'PartiesAssemblymen retrieved successfully');
    }

    /**
     * @param CreatePartiesAssemblymanAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/partiesAssemblymen",
     *      summary="Store a newly created PartiesAssemblyman in storage",
     *      tags={"PartiesAssemblyman"},
     *      description="Store PartiesAssemblyman",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="PartiesAssemblyman that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/PartiesAssemblyman")
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
     *                  ref="#/definitions/PartiesAssemblyman"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePartiesAssemblymanAPIRequest $request)
    {
        $input = $request->all();

        $partiesAssemblymen = $this->partiesAssemblymanRepository->create($input);

        return $this->sendResponse($partiesAssemblymen->toArray(), 'PartiesAssemblyman saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/partiesAssemblymen/{id}",
     *      summary="Display the specified PartiesAssemblyman",
     *      tags={"PartiesAssemblyman"},
     *      description="Get PartiesAssemblyman",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PartiesAssemblyman",
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
     *                  ref="#/definitions/PartiesAssemblyman"
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
        /** @var PartiesAssemblyman $partiesAssemblyman */
        $partiesAssemblyman = $this->partiesAssemblymanRepository->find($id);

        if (empty($partiesAssemblyman)) {
            return Response::json(ResponseUtil::makeError('PartiesAssemblyman not found'), 400);
        }

        return $this->sendResponse($partiesAssemblyman->toArray(), 'PartiesAssemblyman retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatePartiesAssemblymanAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/partiesAssemblymen/{id}",
     *      summary="Update the specified PartiesAssemblyman in storage",
     *      tags={"PartiesAssemblyman"},
     *      description="Update PartiesAssemblyman",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PartiesAssemblyman",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="PartiesAssemblyman that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/PartiesAssemblyman")
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
     *                  ref="#/definitions/PartiesAssemblyman"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePartiesAssemblymanAPIRequest $request)
    {
        $input = $request->all();

        /** @var PartiesAssemblyman $partiesAssemblyman */
        $partiesAssemblyman = $this->partiesAssemblymanRepository->find($id);

        if (empty($partiesAssemblyman)) {
            return Response::json(ResponseUtil::makeError('PartiesAssemblyman not found'), 400);
        }

        $partiesAssemblyman = $this->partiesAssemblymanRepository->update($input, $id);

        return $this->sendResponse($partiesAssemblyman->toArray(), 'PartiesAssemblyman updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/partiesAssemblymen/{id}",
     *      summary="Remove the specified PartiesAssemblyman from storage",
     *      tags={"PartiesAssemblyman"},
     *      description="Delete PartiesAssemblyman",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PartiesAssemblyman",
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
        /** @var PartiesAssemblyman $partiesAssemblyman */
        $partiesAssemblyman = $this->partiesAssemblymanRepository->find($id);

        if (empty($partiesAssemblyman)) {
            return Response::json(ResponseUtil::makeError('PartiesAssemblyman not found'), 400);
        }

        $partiesAssemblyman->delete();

        return $this->sendResponse($id, 'PartiesAssemblyman deleted successfully');
    }
}
