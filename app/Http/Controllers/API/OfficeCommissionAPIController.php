<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateOfficeCommissionAPIRequest;
use App\Http\Requests\API\UpdateOfficeCommissionAPIRequest;
use App\Models\OfficeCommission;
use App\Repositories\OfficeCommissionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class OfficeCommissionController
 * @package App\Http\Controllers\API
 */

class OfficeCommissionAPIController extends AppBaseController
{
    /** @var  OfficeCommissionRepository */
    private $officeCommissionRepository;

    public function __construct(OfficeCommissionRepository $officeCommissionRepo)
    {
        $this->officeCommissionRepository = $officeCommissionRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/officeCommissions",
     *      summary="Get a listing of the OfficeCommissions.",
     *      tags={"OfficeCommission"},
     *      description="Get all OfficeCommissions",
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
     *                  @SWG\Items(ref="#/definitions/OfficeCommission")
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
        $this->officeCommissionRepository->pushCriteria(new RequestCriteria($request));
        $this->officeCommissionRepository->pushCriteria(new LimitOffsetCriteria($request));
        $officeCommissions = $this->officeCommissionRepository->all();

        return $this->sendResponse($officeCommissions->toArray(), 'OfficeCommissions retrieved successfully');
    }

    /**
     * @param CreateOfficeCommissionAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/officeCommissions",
     *      summary="Store a newly created OfficeCommission in storage",
     *      tags={"OfficeCommission"},
     *      description="Store OfficeCommission",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="OfficeCommission that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/OfficeCommission")
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
     *                  ref="#/definitions/OfficeCommission"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateOfficeCommissionAPIRequest $request)
    {
        $input = $request->all();

        $officeCommissions = $this->officeCommissionRepository->create($input);

        return $this->sendResponse($officeCommissions->toArray(), 'OfficeCommission saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/officeCommissions/{id}",
     *      summary="Display the specified OfficeCommission",
     *      tags={"OfficeCommission"},
     *      description="Get OfficeCommission",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of OfficeCommission",
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
     *                  ref="#/definitions/OfficeCommission"
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
        /** @var OfficeCommission $officeCommission */
        $officeCommission = $this->officeCommissionRepository->find($id);

        if (empty($officeCommission)) {
            return Response::json(ResponseUtil::makeError('OfficeCommission not found'), 400);
        }

        return $this->sendResponse($officeCommission->toArray(), 'OfficeCommission retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateOfficeCommissionAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/officeCommissions/{id}",
     *      summary="Update the specified OfficeCommission in storage",
     *      tags={"OfficeCommission"},
     *      description="Update OfficeCommission",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of OfficeCommission",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="OfficeCommission that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/OfficeCommission")
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
     *                  ref="#/definitions/OfficeCommission"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateOfficeCommissionAPIRequest $request)
    {
        $input = $request->all();

        /** @var OfficeCommission $officeCommission */
        $officeCommission = $this->officeCommissionRepository->find($id);

        if (empty($officeCommission)) {
            return Response::json(ResponseUtil::makeError('OfficeCommission not found'), 400);
        }

        $officeCommission = $this->officeCommissionRepository->update($input, $id);

        return $this->sendResponse($officeCommission->toArray(), 'OfficeCommission updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/officeCommissions/{id}",
     *      summary="Remove the specified OfficeCommission from storage",
     *      tags={"OfficeCommission"},
     *      description="Delete OfficeCommission",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of OfficeCommission",
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
        /** @var OfficeCommission $officeCommission */
        $officeCommission = $this->officeCommissionRepository->find($id);

        if (empty($officeCommission)) {
            return Response::json(ResponseUtil::makeError('OfficeCommission not found'), 400);
        }

        $officeCommission->delete();

        return $this->sendResponse($id, 'OfficeCommission deleted successfully');
    }
}
