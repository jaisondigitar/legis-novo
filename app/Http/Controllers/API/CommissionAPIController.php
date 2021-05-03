<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCommissionAPIRequest;
use App\Http\Requests\API\UpdateCommissionAPIRequest;
use App\Models\Commission;
use App\Repositories\CommissionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CommissionController
 * @package App\Http\Controllers\API
 */

class CommissionAPIController extends AppBaseController
{
    /** @var  CommissionRepository */
    private $commissionRepository;

    public function __construct(CommissionRepository $commissionRepo)
    {
        $this->commissionRepository = $commissionRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/commissions",
     *      summary="Get a listing of the Commissions.",
     *      tags={"Commission"},
     *      description="Get all Commissions",
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
     *                  @SWG\Items(ref="#/definitions/Commission")
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
        $this->commissionRepository->pushCriteria(new RequestCriteria($request));
        $this->commissionRepository->pushCriteria(new LimitOffsetCriteria($request));
        $commissions = $this->commissionRepository->all();

        return $this->sendResponse($commissions->toArray(), 'Commissions retrieved successfully');
    }

    /**
     * @param CreateCommissionAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/commissions",
     *      summary="Store a newly created Commission in storage",
     *      tags={"Commission"},
     *      description="Store Commission",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Commission that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Commission")
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
     *                  ref="#/definitions/Commission"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCommissionAPIRequest $request)
    {
        $input = $request->all();

        $commissions = $this->commissionRepository->create($input);

        return $this->sendResponse($commissions->toArray(), 'Commission saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/commissions/{id}",
     *      summary="Display the specified Commission",
     *      tags={"Commission"},
     *      description="Get Commission",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Commission",
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
     *                  ref="#/definitions/Commission"
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
        /** @var Commission $commission */
        $commission = $this->commissionRepository->find($id);

        if (empty($commission)) {
            return Response::json(ResponseUtil::makeError('Commission not found'), 400);
        }

        return $this->sendResponse($commission->toArray(), 'Commission retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCommissionAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/commissions/{id}",
     *      summary="Update the specified Commission in storage",
     *      tags={"Commission"},
     *      description="Update Commission",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Commission",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Commission that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Commission")
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
     *                  ref="#/definitions/Commission"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCommissionAPIRequest $request)
    {
        $input = $request->all();

        /** @var Commission $commission */
        $commission = $this->commissionRepository->find($id);

        if (empty($commission)) {
            return Response::json(ResponseUtil::makeError('Commission not found'), 400);
        }

        $commission = $this->commissionRepository->update($input, $id);

        return $this->sendResponse($commission->toArray(), 'Commission updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/commissions/{id}",
     *      summary="Remove the specified Commission from storage",
     *      tags={"Commission"},
     *      description="Delete Commission",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Commission",
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
        /** @var Commission $commission */
        $commission = $this->commissionRepository->find($id);

        if (empty($commission)) {
            return Response::json(ResponseUtil::makeError('Commission not found'), 400);
        }

        $commission->delete();

        return $this->sendResponse($id, 'Commission deleted successfully');
    }
}
