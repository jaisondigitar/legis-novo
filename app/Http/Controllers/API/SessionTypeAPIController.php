<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSessionTypeAPIRequest;
use App\Http\Requests\API\UpdateSessionTypeAPIRequest;
use App\Models\SessionType;
use App\Repositories\SessionTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class SessionTypeController
 * @package App\Http\Controllers\API
 */

class SessionTypeAPIController extends AppBaseController
{
    /** @var  SessionTypeRepository */
    private $sessionTypeRepository;

    public function __construct(SessionTypeRepository $sessionTypeRepo)
    {
        $this->sessionTypeRepository = $sessionTypeRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/sessionTypes",
     *      summary="Get a listing of the SessionTypes.",
     *      tags={"SessionType"},
     *      description="Get all SessionTypes",
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
     *                  @SWG\Items(ref="#/definitions/SessionType")
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
        $this->sessionTypeRepository->pushCriteria(new RequestCriteria($request));
        $this->sessionTypeRepository->pushCriteria(new LimitOffsetCriteria($request));
        $sessionTypes = $this->sessionTypeRepository->all();

        return $this->sendResponse($sessionTypes->toArray(), 'SessionTypes retrieved successfully');
    }

    /**
     * @param CreateSessionTypeAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/sessionTypes",
     *      summary="Store a newly created SessionType in storage",
     *      tags={"SessionType"},
     *      description="Store SessionType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SessionType that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SessionType")
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
     *                  ref="#/definitions/SessionType"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSessionTypeAPIRequest $request)
    {
        $input = $request->all();

        $sessionTypes = $this->sessionTypeRepository->create($input);

        return $this->sendResponse($sessionTypes->toArray(), 'SessionType saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/sessionTypes/{id}",
     *      summary="Display the specified SessionType",
     *      tags={"SessionType"},
     *      description="Get SessionType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SessionType",
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
     *                  ref="#/definitions/SessionType"
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
        /** @var SessionType $sessionType */
        $sessionType = $this->sessionTypeRepository->find($id);

        if (empty($sessionType)) {
            return Response::json(ResponseUtil::makeError('SessionType not found'), 400);
        }

        return $this->sendResponse($sessionType->toArray(), 'SessionType retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSessionTypeAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/sessionTypes/{id}",
     *      summary="Update the specified SessionType in storage",
     *      tags={"SessionType"},
     *      description="Update SessionType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SessionType",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SessionType that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SessionType")
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
     *                  ref="#/definitions/SessionType"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSessionTypeAPIRequest $request)
    {
        $input = $request->all();

        /** @var SessionType $sessionType */
        $sessionType = $this->sessionTypeRepository->find($id);

        if (empty($sessionType)) {
            return Response::json(ResponseUtil::makeError('SessionType not found'), 400);
        }

        $sessionType = $this->sessionTypeRepository->update($input, $id);

        return $this->sendResponse($sessionType->toArray(), 'SessionType updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/sessionTypes/{id}",
     *      summary="Remove the specified SessionType from storage",
     *      tags={"SessionType"},
     *      description="Delete SessionType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SessionType",
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
        /** @var SessionType $sessionType */
        $sessionType = $this->sessionTypeRepository->find($id);

        if (empty($sessionType)) {
            return Response::json(ResponseUtil::makeError('SessionType not found'), 400);
        }

        $sessionType->delete();

        return $this->sendResponse($id, 'SessionType deleted successfully');
    }
}
