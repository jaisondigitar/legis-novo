<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLegislatureAssemblymanAPIRequest;
use App\Http\Requests\API\UpdateLegislatureAssemblymanAPIRequest;
use App\Models\LegislatureAssemblyman;
use App\Repositories\LegislatureAssemblymanRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class LegislatureAssemblymanController
 * @package App\Http\Controllers\API
 */

class LegislatureAssemblymanAPIController extends AppBaseController
{
    /** @var  LegislatureAssemblymanRepository */
    private $legislatureAssemblymanRepository;

    public function __construct(LegislatureAssemblymanRepository $legislatureAssemblymanRepo)
    {
        $this->legislatureAssemblymanRepository = $legislatureAssemblymanRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/legislatureAssemblymen",
     *      summary="Get a listing of the LegislatureAssemblymen.",
     *      tags={"LegislatureAssemblyman"},
     *      description="Get all LegislatureAssemblymen",
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
     *                  @SWG\Items(ref="#/definitions/LegislatureAssemblyman")
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
        $this->legislatureAssemblymanRepository->pushCriteria(new RequestCriteria($request));
        $this->legislatureAssemblymanRepository->pushCriteria(new LimitOffsetCriteria($request));
        $legislatureAssemblymen = $this->legislatureAssemblymanRepository->all();

        return $this->sendResponse($legislatureAssemblymen->toArray(), 'LegislatureAssemblymen retrieved successfully');
    }

    /**
     * @param CreateLegislatureAssemblymanAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/legislatureAssemblymen",
     *      summary="Store a newly created LegislatureAssemblyman in storage",
     *      tags={"LegislatureAssemblyman"},
     *      description="Store LegislatureAssemblyman",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="LegislatureAssemblyman that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/LegislatureAssemblyman")
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
     *                  ref="#/definitions/LegislatureAssemblyman"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateLegislatureAssemblymanAPIRequest $request)
    {
        $input = $request->all();

        $legislatureAssemblymen = $this->legislatureAssemblymanRepository->create($input);

        return $this->sendResponse($legislatureAssemblymen->toArray(), 'LegislatureAssemblyman saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/legislatureAssemblymen/{id}",
     *      summary="Display the specified LegislatureAssemblyman",
     *      tags={"LegislatureAssemblyman"},
     *      description="Get LegislatureAssemblyman",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of LegislatureAssemblyman",
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
     *                  ref="#/definitions/LegislatureAssemblyman"
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
        /** @var LegislatureAssemblyman $legislatureAssemblyman */
        $legislatureAssemblyman = $this->legislatureAssemblymanRepository->find($id);

        if (empty($legislatureAssemblyman)) {
            return Response::json(ResponseUtil::makeError('LegislatureAssemblyman not found'), 400);
        }

        return $this->sendResponse($legislatureAssemblyman->toArray(), 'LegislatureAssemblyman retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateLegislatureAssemblymanAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/legislatureAssemblymen/{id}",
     *      summary="Update the specified LegislatureAssemblyman in storage",
     *      tags={"LegislatureAssemblyman"},
     *      description="Update LegislatureAssemblyman",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of LegislatureAssemblyman",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="LegislatureAssemblyman that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/LegislatureAssemblyman")
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
     *                  ref="#/definitions/LegislatureAssemblyman"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateLegislatureAssemblymanAPIRequest $request)
    {
        $input = $request->all();

        /** @var LegislatureAssemblyman $legislatureAssemblyman */
        $legislatureAssemblyman = $this->legislatureAssemblymanRepository->find($id);

        if (empty($legislatureAssemblyman)) {
            return Response::json(ResponseUtil::makeError('LegislatureAssemblyman not found'), 400);
        }

        $legislatureAssemblyman = $this->legislatureAssemblymanRepository->update($input, $id);

        return $this->sendResponse($legislatureAssemblyman->toArray(), 'LegislatureAssemblyman updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/legislatureAssemblymen/{id}",
     *      summary="Remove the specified LegislatureAssemblyman from storage",
     *      tags={"LegislatureAssemblyman"},
     *      description="Delete LegislatureAssemblyman",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of LegislatureAssemblyman",
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
        /** @var LegislatureAssemblyman $legislatureAssemblyman */
        $legislatureAssemblyman = $this->legislatureAssemblymanRepository->find($id);

        if (empty($legislatureAssemblyman)) {
            return Response::json(ResponseUtil::makeError('LegislatureAssemblyman not found'), 400);
        }

        $legislatureAssemblyman->delete();

        return $this->sendResponse($id, 'LegislatureAssemblyman deleted successfully');
    }
}
