<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMeetingAPIRequest;
use App\Http\Requests\API\UpdateMeetingAPIRequest;
use App\Models\Meeting;
use App\Repositories\MeetingRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class MeetingController
 * @package App\Http\Controllers\API
 */

class MeetingAPIController extends AppBaseController
{
    /** @var  MeetingRepository */
    private $meetingRepository;

    public function __construct(MeetingRepository $meetingRepo)
    {
        $this->meetingRepository = $meetingRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/meetings",
     *      summary="Get a listing of the Meetings.",
     *      tags={"Meeting"},
     *      description="Get all Meetings",
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
     *                  @SWG\Items(ref="#/definitions/Meeting")
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
        $this->meetingRepository->pushCriteria(new RequestCriteria($request));
        $this->meetingRepository->pushCriteria(new LimitOffsetCriteria($request));
        $meetings = $this->meetingRepository->all();

        return $this->sendResponse($meetings->toArray(), 'Meetings retrieved successfully');
    }

    /**
     * @param CreateMeetingAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/meetings",
     *      summary="Store a newly created Meeting in storage",
     *      tags={"Meeting"},
     *      description="Store Meeting",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Meeting that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Meeting")
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
     *                  ref="#/definitions/Meeting"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateMeetingAPIRequest $request)
    {
        $input = $request->all();

        $meetings = $this->meetingRepository->create($input);

        return $this->sendResponse($meetings->toArray(), 'Meeting saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/meetings/{id}",
     *      summary="Display the specified Meeting",
     *      tags={"Meeting"},
     *      description="Get Meeting",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Meeting",
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
     *                  ref="#/definitions/Meeting"
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
        /** @var Meeting $meeting */
        $meeting = $this->meetingRepository->find($id);

        if (empty($meeting)) {
            return Response::json(ResponseUtil::makeError('Meeting not found'), 400);
        }

        return $this->sendResponse($meeting->toArray(), 'Meeting retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateMeetingAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/meetings/{id}",
     *      summary="Update the specified Meeting in storage",
     *      tags={"Meeting"},
     *      description="Update Meeting",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Meeting",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Meeting that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Meeting")
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
     *                  ref="#/definitions/Meeting"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateMeetingAPIRequest $request)
    {
        $input = $request->all();

        /** @var Meeting $meeting */
        $meeting = $this->meetingRepository->find($id);

        if (empty($meeting)) {
            return Response::json(ResponseUtil::makeError('Meeting not found'), 400);
        }

        $meeting = $this->meetingRepository->update($input, $id);

        return $this->sendResponse($meeting->toArray(), 'Meeting updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/meetings/{id}",
     *      summary="Remove the specified Meeting from storage",
     *      tags={"Meeting"},
     *      description="Delete Meeting",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Meeting",
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
        /** @var Meeting $meeting */
        $meeting = $this->meetingRepository->find($id);

        if (empty($meeting)) {
            return Response::json(ResponseUtil::makeError('Meeting not found'), 400);
        }

        $meeting->delete();

        return $this->sendResponse($id, 'Meeting deleted successfully');
    }
}
