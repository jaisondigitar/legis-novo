<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateSectorAPIRequest;
use App\Http\Requests\API\UpdateSectorAPIRequest;
use App\Models\Sector;
use App\Repositories\SectorRepository;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class SectorController.
 */
class SectorAPIController extends AppBaseController
{
    /** @var SectorRepository */
    private $sectorRepository;

    public function __construct(SectorRepository $sectorRepo)
    {
        $this->sectorRepository = $sectorRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/sectors",
     *      summary="Get a listing of the Sectors.",
     *      tags={"Sector"},
     *      description="Get all Sectors",
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
     *                  @SWG\Items(ref="#/definitions/Sector")
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
        $this->sectorRepository->pushCriteria(new RequestCriteria($request));
        $this->sectorRepository->pushCriteria(new LimitOffsetCriteria($request));
        $sectors = $this->sectorRepository->all();

        return $this->sendResponse($sectors->toArray(), 'Sectors retrieved successfully');
    }

    /**
     * @param CreateSectorAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/sectors",
     *      summary="Store a newly created Sector in storage",
     *      tags={"Sector"},
     *      description="Store Sector",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Sector that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Sector")
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
     *                  ref="#/definitions/Sector"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSectorAPIRequest $request)
    {
        $input = $request->all();

        $sectors = $this->sectorRepository->create($input);

        return $this->sendResponse($sectors->toArray(), 'Sector saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/sectors/{id}",
     *      summary="Display the specified Sector",
     *      tags={"Sector"},
     *      description="Get Sector",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Sector",
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
     *                  ref="#/definitions/Sector"
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
        /** @var Sector $sector */
        $sector = $this->sectorRepository->find($id);

        if (empty($sector)) {
            return Response::json(ResponseUtil::makeError('Sector not found'), 400);
        }

        return $this->sendResponse($sector->toArray(), 'Sector retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSectorAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/sectors/{id}",
     *      summary="Update the specified Sector in storage",
     *      tags={"Sector"},
     *      description="Update Sector",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Sector",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Sector that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Sector")
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
     *                  ref="#/definitions/Sector"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSectorAPIRequest $request)
    {
        $input = $request->all();

        /** @var Sector $sector */
        $sector = $this->sectorRepository->find($id);

        if (empty($sector)) {
            return Response::json(ResponseUtil::makeError('Sector not found'), 400);
        }

        $sector = $this->sectorRepository->update($input, $id);

        return $this->sendResponse($sector->toArray(), 'Sector updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/sectors/{id}",
     *      summary="Remove the specified Sector from storage",
     *      tags={"Sector"},
     *      description="Delete Sector",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Sector",
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
        /** @var Sector $sector */
        $sector = $this->sectorRepository->find($id);

        if (empty($sector)) {
            return Response::json(ResponseUtil::makeError('Sector not found'), 400);
        }

        $sector->delete();

        return $this->sendResponse($id, 'Sector deleted successfully');
    }
}
