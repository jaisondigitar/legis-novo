<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProtocolTypeAPIRequest;
use App\Http\Requests\API\UpdateProtocolTypeAPIRequest;
use App\Models\ProtocolType;
use App\Repositories\ProtocolTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ProtocolTypeController
 * @package App\Http\Controllers\API
 */

class ProtocolTypeAPIController extends AppBaseController
{
    /** @var  ProtocolTypeRepository */
    private $protocolTypeRepository;

    public function __construct(ProtocolTypeRepository $protocolTypeRepo)
    {
        $this->protocolTypeRepository = $protocolTypeRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/protocolTypes",
     *      summary="Get a listing of the ProtocolTypes.",
     *      tags={"ProtocolType"},
     *      description="Get all ProtocolTypes",
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
     *                  @SWG\Items(ref="#/definitions/ProtocolType")
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
        $this->protocolTypeRepository->pushCriteria(new RequestCriteria($request));
        $this->protocolTypeRepository->pushCriteria(new LimitOffsetCriteria($request));
        $protocolTypes = $this->protocolTypeRepository->all();

        return $this->sendResponse($protocolTypes->toArray(), 'ProtocolTypes retrieved successfully');
    }

    /**
     * @param CreateProtocolTypeAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/protocolTypes",
     *      summary="Store a newly created ProtocolType in storage",
     *      tags={"ProtocolType"},
     *      description="Store ProtocolType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ProtocolType that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ProtocolType")
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
     *                  ref="#/definitions/ProtocolType"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateProtocolTypeAPIRequest $request)
    {
        $input = $request->all();

        $protocolTypes = $this->protocolTypeRepository->create($input);

        return $this->sendResponse($protocolTypes->toArray(), 'ProtocolType saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/protocolTypes/{id}",
     *      summary="Display the specified ProtocolType",
     *      tags={"ProtocolType"},
     *      description="Get ProtocolType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ProtocolType",
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
     *                  ref="#/definitions/ProtocolType"
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
        /** @var ProtocolType $protocolType */
        $protocolType = $this->protocolTypeRepository->find($id);

        if (empty($protocolType)) {
            return Response::json(ResponseUtil::makeError('ProtocolType not found'), 400);
        }

        return $this->sendResponse($protocolType->toArray(), 'ProtocolType retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateProtocolTypeAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/protocolTypes/{id}",
     *      summary="Update the specified ProtocolType in storage",
     *      tags={"ProtocolType"},
     *      description="Update ProtocolType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ProtocolType",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ProtocolType that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ProtocolType")
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
     *                  ref="#/definitions/ProtocolType"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateProtocolTypeAPIRequest $request)
    {
        $input = $request->all();

        /** @var ProtocolType $protocolType */
        $protocolType = $this->protocolTypeRepository->find($id);

        if (empty($protocolType)) {
            return Response::json(ResponseUtil::makeError('ProtocolType not found'), 400);
        }

        $protocolType = $this->protocolTypeRepository->update($input, $id);

        return $this->sendResponse($protocolType->toArray(), 'ProtocolType updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/protocolTypes/{id}",
     *      summary="Remove the specified ProtocolType from storage",
     *      tags={"ProtocolType"},
     *      description="Delete ProtocolType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ProtocolType",
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
        /** @var ProtocolType $protocolType */
        $protocolType = $this->protocolTypeRepository->find($id);

        if (empty($protocolType)) {
            return Response::json(ResponseUtil::makeError('ProtocolType not found'), 400);
        }

        $protocolType->delete();

        return $this->sendResponse($id, 'ProtocolType deleted successfully');
    }
}
