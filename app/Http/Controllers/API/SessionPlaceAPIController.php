<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateSessionPlaceAPIRequest;
use App\Http\Requests\API\UpdateSessionPlaceAPIRequest;
use App\Models\SessionPlace;
use App\Repositories\SessionPlaceRepository;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class SessionPlaceController.
 */
class SessionPlaceAPIController extends AppBaseController
{
    /** @var SessionPlaceRepository */
    private $sessionPlaceRepository;

    public function __construct(SessionPlaceRepository $sessionPlaceRepo)
    {
        $this->sessionPlaceRepository = $sessionPlaceRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/sessionPlaces",
     *      summary="Get a listing of the SessionPlaces.",
     *      tags={"SessionPlace"},
     *      description="Get all SessionPlaces",
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
     *                  @SWG\Items(ref="#/definitions/SessionPlace")
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
        $this->sessionPlaceRepository->pushCriteria(new RequestCriteria($request));
        $this->sessionPlaceRepository->pushCriteria(new LimitOffsetCriteria($request));
        $sessionPlaces = $this->sessionPlaceRepository->all();

        return $this->sendResponse($sessionPlaces->toArray(), 'SessionPlaces retrieved successfully');
    }

    /**
     * @param CreateSessionPlaceAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/sessionPlaces",
     *      summary="Store a newly created SessionPlace in storage",
     *      tags={"SessionPlace"},
     *      description="Store SessionPlace",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SessionPlace that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SessionPlace")
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
     *                  ref="#/definitions/SessionPlace"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSessionPlaceAPIRequest $request)
    {
        $input = $request->all();

        $sessionPlaces = $this->sessionPlaceRepository->create($input);

        return $this->sendResponse($sessionPlaces->toArray(), 'SessionPlace saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/sessionPlaces/{id}",
     *      summary="Display the specified SessionPlace",
     *      tags={"SessionPlace"},
     *      description="Get SessionPlace",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SessionPlace",
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
     *                  ref="#/definitions/SessionPlace"
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
        /** @var SessionPlace $sessionPlace */
        $sessionPlace = $this->sessionPlaceRepository->find($id);

        if (empty($sessionPlace)) {
            return Response::json(ResponseUtil::makeError('SessionPlace not found'), 400);
        }

        return $this->sendResponse($sessionPlace->toArray(), 'SessionPlace retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSessionPlaceAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/sessionPlaces/{id}",
     *      summary="Update the specified SessionPlace in storage",
     *      tags={"SessionPlace"},
     *      description="Update SessionPlace",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SessionPlace",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SessionPlace that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SessionPlace")
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
     *                  ref="#/definitions/SessionPlace"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSessionPlaceAPIRequest $request)
    {
        $input = $request->all();

        /** @var SessionPlace $sessionPlace */
        $sessionPlace = $this->sessionPlaceRepository->find($id);

        if (empty($sessionPlace)) {
            return Response::json(ResponseUtil::makeError('SessionPlace not found'), 400);
        }

        $sessionPlace = $this->sessionPlaceRepository->update($input, $id);

        return $this->sendResponse($sessionPlace->toArray(), 'SessionPlace updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/sessionPlaces/{id}",
     *      summary="Remove the specified SessionPlace from storage",
     *      tags={"SessionPlace"},
     *      description="Delete SessionPlace",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SessionPlace",
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
        /** @var SessionPlace $sessionPlace */
        $sessionPlace = $this->sessionPlaceRepository->find($id);

        if (empty($sessionPlace)) {
            return Response::json(ResponseUtil::makeError('SessionPlace not found'), 400);
        }

        $sessionPlace->delete();

        return $this->sendResponse($id, 'SessionPlace deleted successfully');
    }
}
