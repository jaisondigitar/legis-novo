<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateOfficeComissionAPIRequest;
use App\Http\Requests\API\UpdateOfficeComissionAPIRequest;
use App\Models\OfficeComission;
use App\Repositories\OfficeComissionRepository;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class OfficeComissionController.
 */
class OfficeComissionAPIController extends AppBaseController
{
    /** @var OfficeComissionRepository */
    private $officeComissionRepository;

    public function __construct(OfficeComissionRepository $officeComissionRepo)
    {
        $this->officeComissionRepository = $officeComissionRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/officeComissions",
     *      summary="Get a listing of the OfficeComissions.",
     *      tags={"OfficeComission"},
     *      description="Get all OfficeComissions",
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
     *                  @SWG\Items(ref="#/definitions/OfficeComission")
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
        $this->officeComissionRepository->pushCriteria(new RequestCriteria($request));
        $this->officeComissionRepository->pushCriteria(new LimitOffsetCriteria($request));
        $officeComissions = $this->officeComissionRepository->all();

        return $this->sendResponse($officeComissions->toArray(), 'OfficeComissions retrieved successfully');
    }

    /**
     * @param CreateOfficeComissionAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/officeComissions",
     *      summary="Store a newly created OfficeComission in storage",
     *      tags={"OfficeComission"},
     *      description="Store OfficeComission",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="OfficeComission that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/OfficeComission")
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
     *                  ref="#/definitions/OfficeComission"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateOfficeComissionAPIRequest $request)
    {
        $input = $request->all();

        $officeComissions = $this->officeComissionRepository->create($input);

        return $this->sendResponse($officeComissions->toArray(), 'OfficeComission saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/officeComissions/{id}",
     *      summary="Display the specified OfficeComission",
     *      tags={"OfficeComission"},
     *      description="Get OfficeComission",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of OfficeComission",
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
     *                  ref="#/definitions/OfficeComission"
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
        /** @var OfficeComission $officeComission */
        $officeComission = $this->officeComissionRepository->find($id);

        if (empty($officeComission)) {
            return Response::json(ResponseUtil::makeError('OfficeComission not found'), 400);
        }

        return $this->sendResponse($officeComission->toArray(), 'OfficeComission retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateOfficeComissionAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/officeComissions/{id}",
     *      summary="Update the specified OfficeComission in storage",
     *      tags={"OfficeComission"},
     *      description="Update OfficeComission",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of OfficeComission",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="OfficeComission that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/OfficeComission")
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
     *                  ref="#/definitions/OfficeComission"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateOfficeComissionAPIRequest $request)
    {
        $input = $request->all();

        /** @var OfficeComission $officeComission */
        $officeComission = $this->officeComissionRepository->find($id);

        if (empty($officeComission)) {
            return Response::json(ResponseUtil::makeError('OfficeComission not found'), 400);
        }

        $officeComission = $this->officeComissionRepository->update($input, $id);

        return $this->sendResponse($officeComission->toArray(), 'OfficeComission updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/officeComissions/{id}",
     *      summary="Remove the specified OfficeComission from storage",
     *      tags={"OfficeComission"},
     *      description="Delete OfficeComission",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of OfficeComission",
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
        /** @var OfficeComission $officeComission */
        $officeComission = $this->officeComissionRepository->find($id);

        if (empty($officeComission)) {
            return Response::json(ResponseUtil::makeError('OfficeComission not found'), 400);
        }

        $officeComission->delete();

        return $this->sendResponse($id, 'OfficeComission deleted successfully');
    }
}
