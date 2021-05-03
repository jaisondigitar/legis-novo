<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateParametersAPIRequest;
use App\Http\Requests\API\UpdateParametersAPIRequest;
use App\Models\Parameters;
use App\Repositories\ParametersRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ParametersController
 * @package App\Http\Controllers\API
 */

class ParametersAPIController extends AppBaseController
{
    /** @var  ParametersRepository */
    private $parametersRepository;

    public function __construct(ParametersRepository $parametersRepo)
    {
        $this->parametersRepository = $parametersRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/parameters",
     *      summary="Get a listing of the Parameters.",
     *      tags={"Parameters"},
     *      description="Get all Parameters",
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
     *                  @SWG\Items(ref="#/definitions/Parameters")
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
        $this->parametersRepository->pushCriteria(new RequestCriteria($request));
        $this->parametersRepository->pushCriteria(new LimitOffsetCriteria($request));
        $parameters = $this->parametersRepository->all();

        return $this->sendResponse($parameters->toArray(), 'Parameters retrieved successfully');
    }

    /**
     * @param CreateParametersAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/parameters",
     *      summary="Store a newly created Parameters in storage",
     *      tags={"Parameters"},
     *      description="Store Parameters",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Parameters that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Parameters")
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
     *                  ref="#/definitions/Parameters"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateParametersAPIRequest $request)
    {
        $input = $request->all();

        $parameters = $this->parametersRepository->create($input);

        return $this->sendResponse($parameters->toArray(), 'Parameters saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/parameters/{id}",
     *      summary="Display the specified Parameters",
     *      tags={"Parameters"},
     *      description="Get Parameters",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Parameters",
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
     *                  ref="#/definitions/Parameters"
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
        /** @var Parameters $parameters */
        $parameters = $this->parametersRepository->find($id);

        if (empty($parameters)) {
            return Response::json(ResponseUtil::makeError('Parameters not found'), 400);
        }

        return $this->sendResponse($parameters->toArray(), 'Parameters retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateParametersAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/parameters/{id}",
     *      summary="Update the specified Parameters in storage",
     *      tags={"Parameters"},
     *      description="Update Parameters",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Parameters",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Parameters that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Parameters")
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
     *                  ref="#/definitions/Parameters"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateParametersAPIRequest $request)
    {
        $input = $request->all();

        /** @var Parameters $parameters */
        $parameters = $this->parametersRepository->find($id);

        if (empty($parameters)) {
            return Response::json(ResponseUtil::makeError('Parameters not found'), 400);
        }

        $parameters = $this->parametersRepository->update($input, $id);

        return $this->sendResponse($parameters->toArray(), 'Parameters updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/parameters/{id}",
     *      summary="Remove the specified Parameters from storage",
     *      tags={"Parameters"},
     *      description="Delete Parameters",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Parameters",
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
        /** @var Parameters $parameters */
        $parameters = $this->parametersRepository->find($id);

        if (empty($parameters)) {
            return Response::json(ResponseUtil::makeError('Parameters not found'), 400);
        }

        $parameters->delete();

        return $this->sendResponse($id, 'Parameters deleted successfully');
    }
}
