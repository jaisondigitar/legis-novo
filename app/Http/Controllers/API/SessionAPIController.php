<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSessionAPIRequest;
use App\Http\Requests\API\UpdateSessionAPIRequest;
use App\Models\Session;
use App\Repositories\SessionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class SessionController
 * @package App\Http\Controllers\API
 */

class SessionAPIController extends AppBaseController
{
    /** @var  SessionRepository */
    private $sessionRepository;

    public function __construct(SessionRepository $sessionRepo)
    {
        $this->sessionRepository = $sessionRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/sessions",
     *      summary="Get a listing of the Sessions.",
     *      tags={"Session"},
     *      description="Get all Sessions",
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
     *                  @SWG\Items(ref="#/definitions/Session")
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
        $this->sessionRepository->pushCriteria(new RequestCriteria($request));
        $this->sessionRepository->pushCriteria(new LimitOffsetCriteria($request));
        $sessions = $this->sessionRepository->all();

        return $this->sendResponse($sessions->toArray(), 'Sessions retrieved successfully');
    }

    /**
     * @param CreateSessionAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/sessions",
     *      summary="Store a newly created Session in storage",
     *      tags={"Session"},
     *      description="Store Session",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Session that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Session")
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
     *                  ref="#/definitions/Session"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSessionAPIRequest $request)
    {
        $input = $request->all();

        $sessions = $this->sessionRepository->create($input);

        return $this->sendResponse($sessions->toArray(), 'Session saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/sessions/{id}",
     *      summary="Display the specified Session",
     *      tags={"Session"},
     *      description="Get Session",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Session",
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
     *                  ref="#/definitions/Session"
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
        /** @var Session $session */
        $session = $this->sessionRepository->find($id);

        if (empty($session)) {
            return Response::json(ResponseUtil::makeError('Session not found'), 400);
        }

        return $this->sendResponse($session->toArray(), 'Session retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSessionAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/sessions/{id}",
     *      summary="Update the specified Session in storage",
     *      tags={"Session"},
     *      description="Update Session",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Session",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Session that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Session")
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
     *                  ref="#/definitions/Session"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSessionAPIRequest $request)
    {
        $input = $request->all();

        /** @var Session $session */
        $session = $this->sessionRepository->find($id);

        if (empty($session)) {
            return Response::json(ResponseUtil::makeError('Session not found'), 400);
        }

        $session = $this->sessionRepository->update($input, $id);

        return $this->sendResponse($session->toArray(), 'Session updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/sessions/{id}",
     *      summary="Remove the specified Session from storage",
     *      tags={"Session"},
     *      description="Delete Session",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Session",
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
        /** @var Session $session */
        $session = $this->sessionRepository->find($id);

        if (empty($session)) {
            return Response::json(ResponseUtil::makeError('Session not found'), 400);
        }

        $session->delete();

        return $this->sendResponse($id, 'Session deleted successfully');
    }
}
