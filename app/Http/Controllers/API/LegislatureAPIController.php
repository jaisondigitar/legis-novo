<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLegislatureAPIRequest;
use App\Http\Requests\API\UpdateLegislatureAPIRequest;
use App\Models\Legislature;
use App\Repositories\LegislatureRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class LegislatureController
 * @package App\Http\Controllers\API
 */

class LegislatureAPIController extends AppBaseController
{
    /** @var  LegislatureRepository */
    private $legislatureRepository;

    public function __construct(LegislatureRepository $legislatureRepo)
    {
        $this->legislatureRepository = $legislatureRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/legislatures",
     *      summary="Get a listing of the Legislatures.",
     *      tags={"Legislature"},
     *      description="Get all Legislatures",
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
     *                  @SWG\Items(ref="#/definitions/Legislature")
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
        $this->legislatureRepository->pushCriteria(new RequestCriteria($request));
        $this->legislatureRepository->pushCriteria(new LimitOffsetCriteria($request));
        $legislatures = $this->legislatureRepository->all();

        return $this->sendResponse($legislatures->toArray(), 'Legislatures retrieved successfully');
    }

    /**
     * @param CreateLegislatureAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/legislatures",
     *      summary="Store a newly created Legislature in storage",
     *      tags={"Legislature"},
     *      description="Store Legislature",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Legislature that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Legislature")
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
     *                  ref="#/definitions/Legislature"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateLegislatureAPIRequest $request)
    {
        $input = $request->all();

        $legislatures = $this->legislatureRepository->create($input);

        return $this->sendResponse($legislatures->toArray(), 'Legislature saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/legislatures/{id}",
     *      summary="Display the specified Legislature",
     *      tags={"Legislature"},
     *      description="Get Legislature",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Legislature",
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
     *                  ref="#/definitions/Legislature"
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
        /** @var Legislature $legislature */
        $legislature = $this->legislatureRepository->find($id);

        if (empty($legislature)) {
            return Response::json(ResponseUtil::makeError('Legislature not found'), 400);
        }

        return $this->sendResponse($legislature->toArray(), 'Legislature retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateLegislatureAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/legislatures/{id}",
     *      summary="Update the specified Legislature in storage",
     *      tags={"Legislature"},
     *      description="Update Legislature",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Legislature",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Legislature that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Legislature")
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
     *                  ref="#/definitions/Legislature"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateLegislatureAPIRequest $request)
    {
        $input = $request->all();

        /** @var Legislature $legislature */
        $legislature = $this->legislatureRepository->find($id);

        if (empty($legislature)) {
            return Response::json(ResponseUtil::makeError('Legislature not found'), 400);
        }

        $legislature = $this->legislatureRepository->update($input, $id);

        return $this->sendResponse($legislature->toArray(), 'Legislature updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/legislatures/{id}",
     *      summary="Remove the specified Legislature from storage",
     *      tags={"Legislature"},
     *      description="Delete Legislature",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Legislature",
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
        /** @var Legislature $legislature */
        $legislature = $this->legislatureRepository->find($id);

        if (empty($legislature)) {
            return Response::json(ResponseUtil::makeError('Legislature not found'), 400);
        }

        $legislature->delete();

        return $this->sendResponse($id, 'Legislature deleted successfully');
    }
}
