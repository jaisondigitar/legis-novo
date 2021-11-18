<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreatePartyAPIRequest;
use App\Http\Requests\API\UpdatePartyAPIRequest;
use App\Models\Party;
use App\Repositories\PartyRepository;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class PartyController.
 */
class PartyAPIController extends AppBaseController
{
    /** @var PartyRepository */
    private $partyRepository;

    public function __construct(PartyRepository $partyRepo)
    {
        $this->partyRepository = $partyRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/parties",
     *      summary="Get a listing of the Parties.",
     *      tags={"Party"},
     *      description="Get all Parties",
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
     *                  @SWG\Items(ref="#/definitions/Party")
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
        $this->partyRepository->pushCriteria(new RequestCriteria($request));
        $this->partyRepository->pushCriteria(new LimitOffsetCriteria($request));
        $parties = $this->partyRepository->all();

        return $this->sendResponse($parties->toArray(), 'Parties retrieved successfully');
    }

    /**
     * @param CreatePartyAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/parties",
     *      summary="Store a newly created Party in storage",
     *      tags={"Party"},
     *      description="Store Party",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Party that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Party")
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
     *                  ref="#/definitions/Party"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePartyAPIRequest $request)
    {
        $input = $request->all();

        $parties = $this->partyRepository->create($input);

        return $this->sendResponse($parties->toArray(), 'Party saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/parties/{id}",
     *      summary="Display the specified Party",
     *      tags={"Party"},
     *      description="Get Party",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Party",
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
     *                  ref="#/definitions/Party"
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
        /** @var Party $party */
        $party = $this->partyRepository->find($id);

        if (empty($party)) {
            return Response::json(ResponseUtil::makeError('Party not found'), 400);
        }

        return $this->sendResponse($party->toArray(), 'Party retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatePartyAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/parties/{id}",
     *      summary="Update the specified Party in storage",
     *      tags={"Party"},
     *      description="Update Party",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Party",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Party that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Party")
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
     *                  ref="#/definitions/Party"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePartyAPIRequest $request)
    {
        $input = $request->all();

        /** @var Party $party */
        $party = $this->partyRepository->find($id);

        if (empty($party)) {
            return Response::json(ResponseUtil::makeError('Party not found'), 400);
        }

        $party = $this->partyRepository->update($input, $id);

        return $this->sendResponse($party->toArray(), 'Party updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/parties/{id}",
     *      summary="Remove the specified Party from storage",
     *      tags={"Party"},
     *      description="Delete Party",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Party",
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
        /** @var Party $party */
        $party = $this->partyRepository->find($id);

        if (empty($party)) {
            return Response::json(ResponseUtil::makeError('Party not found'), 400);
        }

        $party->delete();

        return $this->sendResponse($id, 'Party deleted successfully');
    }
}
