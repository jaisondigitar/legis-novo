<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateResponsibilityAPIRequest;
use App\Http\Requests\API\UpdateResponsibilityAPIRequest;
use App\Models\Responsibility;
use App\Repositories\ResponsibilityRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ResponsibilityController
 * @package App\Http\Controllers\API
 */

class ResponsibilityAPIController extends AppBaseController
{
    /** @var  ResponsibilityRepository */
    private $responsibilityRepository;

    public function __construct(ResponsibilityRepository $responsibilityRepo)
    {
        $this->responsibilityRepository = $responsibilityRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/responsibilities",
     *      summary="Get a listing of the Responsibilities.",
     *      tags={"Responsibility"},
     *      description="Get all Responsibilities",
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
     *                  @SWG\Items(ref="#/definitions/Responsibility")
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
        $this->responsibilityRepository->pushCriteria(new RequestCriteria($request));
        $this->responsibilityRepository->pushCriteria(new LimitOffsetCriteria($request));
        $responsibilities = $this->responsibilityRepository->all();

        return $this->sendResponse($responsibilities->toArray(), 'Responsibilities retrieved successfully');
    }

    /**
     * @param CreateResponsibilityAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/responsibilities",
     *      summary="Store a newly created Responsibility in storage",
     *      tags={"Responsibility"},
     *      description="Store Responsibility",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Responsibility that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Responsibility")
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
     *                  ref="#/definitions/Responsibility"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateResponsibilityAPIRequest $request)
    {
        $input = $request->all();

        $responsibilities = $this->responsibilityRepository->create($input);

        return $this->sendResponse($responsibilities->toArray(), 'Responsibility saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/responsibilities/{id}",
     *      summary="Display the specified Responsibility",
     *      tags={"Responsibility"},
     *      description="Get Responsibility",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Responsibility",
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
     *                  ref="#/definitions/Responsibility"
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
        /** @var Responsibility $responsibility */
        $responsibility = $this->responsibilityRepository->find($id);

        if (empty($responsibility)) {
            return Response::json(ResponseUtil::makeError('Responsibility not found'), 400);
        }

        return $this->sendResponse($responsibility->toArray(), 'Responsibility retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateResponsibilityAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/responsibilities/{id}",
     *      summary="Update the specified Responsibility in storage",
     *      tags={"Responsibility"},
     *      description="Update Responsibility",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Responsibility",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Responsibility that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Responsibility")
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
     *                  ref="#/definitions/Responsibility"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateResponsibilityAPIRequest $request)
    {
        $input = $request->all();

        /** @var Responsibility $responsibility */
        $responsibility = $this->responsibilityRepository->find($id);

        if (empty($responsibility)) {
            return Response::json(ResponseUtil::makeError('Responsibility not found'), 400);
        }

        $responsibility = $this->responsibilityRepository->update($input, $id);

        return $this->sendResponse($responsibility->toArray(), 'Responsibility updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/responsibilities/{id}",
     *      summary="Remove the specified Responsibility from storage",
     *      tags={"Responsibility"},
     *      description="Delete Responsibility",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Responsibility",
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
        /** @var Responsibility $responsibility */
        $responsibility = $this->responsibilityRepository->find($id);

        if (empty($responsibility)) {
            return Response::json(ResponseUtil::makeError('Responsibility not found'), 400);
        }

        $responsibility->delete();

        return $this->sendResponse($id, 'Responsibility deleted successfully');
    }
}
