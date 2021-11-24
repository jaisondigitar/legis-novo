<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateResponsibilityAssemblymanAPIRequest;
use App\Http\Requests\API\UpdateResponsibilityAssemblymanAPIRequest;
use App\Models\ResponsibilityAssemblyman;
use App\Repositories\ResponsibilityAssemblymanRepository;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ResponsibilityAssemblymanController.
 */
class ResponsibilityAssemblymanAPIController extends AppBaseController
{
    /** @var ResponsibilityAssemblymanRepository */
    private $responsibilityAssemblymanRepository;

    public function __construct(ResponsibilityAssemblymanRepository $responsibilityAssemblymanRepo)
    {
        $this->responsibilityAssemblymanRepository = $responsibilityAssemblymanRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/responsibilityAssemblymen",
     *      summary="Get a listing of the ResponsibilityAssemblymen.",
     *      tags={"ResponsibilityAssemblyman"},
     *      description="Get all ResponsibilityAssemblymen",
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
     *                  @SWG\Items(ref="#/definitions/ResponsibilityAssemblyman")
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
        $this->responsibilityAssemblymanRepository->pushCriteria(new RequestCriteria($request));
        $this->responsibilityAssemblymanRepository->pushCriteria(new LimitOffsetCriteria($request));
        $responsibilityAssemblymen = $this->responsibilityAssemblymanRepository->all();

        return $this->sendResponse($responsibilityAssemblymen->toArray(), 'ResponsibilityAssemblymen retrieved successfully');
    }

    /**
     * @param CreateResponsibilityAssemblymanAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/responsibilityAssemblymen",
     *      summary="Store a newly created ResponsibilityAssemblyman in storage",
     *      tags={"ResponsibilityAssemblyman"},
     *      description="Store ResponsibilityAssemblyman",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ResponsibilityAssemblyman that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ResponsibilityAssemblyman")
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
     *                  ref="#/definitions/ResponsibilityAssemblyman"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateResponsibilityAssemblymanAPIRequest $request)
    {
        $input = $request->all();

        $responsibilityAssemblymen = $this->responsibilityAssemblymanRepository->create($input);

        return $this->sendResponse($responsibilityAssemblymen->toArray(), 'ResponsibilityAssemblyman saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/responsibilityAssemblymen/{id}",
     *      summary="Display the specified ResponsibilityAssemblyman",
     *      tags={"ResponsibilityAssemblyman"},
     *      description="Get ResponsibilityAssemblyman",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ResponsibilityAssemblyman",
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
     *                  ref="#/definitions/ResponsibilityAssemblyman"
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
        /** @var ResponsibilityAssemblyman $responsibilityAssemblyman */
        $responsibilityAssemblyman = $this->responsibilityAssemblymanRepository->find($id);

        if (empty($responsibilityAssemblyman)) {
            return Response::json(ResponseUtil::makeError('ResponsibilityAssemblyman not found'), 400);
        }

        return $this->sendResponse($responsibilityAssemblyman->toArray(), 'ResponsibilityAssemblyman retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateResponsibilityAssemblymanAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/responsibilityAssemblymen/{id}",
     *      summary="Update the specified ResponsibilityAssemblyman in storage",
     *      tags={"ResponsibilityAssemblyman"},
     *      description="Update ResponsibilityAssemblyman",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ResponsibilityAssemblyman",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ResponsibilityAssemblyman that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ResponsibilityAssemblyman")
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
     *                  ref="#/definitions/ResponsibilityAssemblyman"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateResponsibilityAssemblymanAPIRequest $request)
    {
        $input = $request->all();

        /** @var ResponsibilityAssemblyman $responsibilityAssemblyman */
        $responsibilityAssemblyman = $this->responsibilityAssemblymanRepository->find($id);

        if (empty($responsibilityAssemblyman)) {
            return Response::json(ResponseUtil::makeError('ResponsibilityAssemblyman not found'), 400);
        }

        $responsibilityAssemblyman = $this->responsibilityAssemblymanRepository->update($input, $id);

        return $this->sendResponse($responsibilityAssemblyman->toArray(), 'ResponsibilityAssemblyman updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/responsibilityAssemblymen/{id}",
     *      summary="Remove the specified ResponsibilityAssemblyman from storage",
     *      tags={"ResponsibilityAssemblyman"},
     *      description="Delete ResponsibilityAssemblyman",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ResponsibilityAssemblyman",
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
        /** @var ResponsibilityAssemblyman $responsibilityAssemblyman */
        $responsibilityAssemblyman = $this->responsibilityAssemblymanRepository->find($id);

        if (empty($responsibilityAssemblyman)) {
            return Response::json(ResponseUtil::makeError('ResponsibilityAssemblyman not found'), 400);
        }

        $responsibilityAssemblyman->delete();

        return $this->sendResponse($id, 'ResponsibilityAssemblyman deleted successfully');
    }
}
