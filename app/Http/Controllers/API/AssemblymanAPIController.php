<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAssemblymanAPIRequest;
use App\Http\Requests\API\UpdateAssemblymanAPIRequest;
use App\Models\Assemblyman;
use App\Repositories\AssemblymanRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class AssemblymanController
 * @package App\Http\Controllers\API
 */

class AssemblymanAPIController extends AppBaseController
{
    /** @var  AssemblymanRepository */
    private $assemblymanRepository;

    public function __construct(AssemblymanRepository $assemblymanRepo)
    {
        $this->assemblymanRepository = $assemblymanRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/assemblymen",
     *      summary="Get a listing of the Assemblymen.",
     *      tags={"Assemblyman"},
     *      description="Get all Assemblymen",
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
     *                  @SWG\Items(ref="#/definitions/Assemblyman")
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
        $this->assemblymanRepository->pushCriteria(new RequestCriteria($request));
        $this->assemblymanRepository->pushCriteria(new LimitOffsetCriteria($request));
        $assemblymen = $this->assemblymanRepository->all();

        return $this->sendResponse($assemblymen->toArray(), 'Assemblymen retrieved successfully');
    }

    /**
     * @param CreateAssemblymanAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/assemblymen",
     *      summary="Store a newly created Assemblyman in storage",
     *      tags={"Assemblyman"},
     *      description="Store Assemblyman",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Assemblyman that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Assemblyman")
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
     *                  ref="#/definitions/Assemblyman"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAssemblymanAPIRequest $request)
    {
        $input = $request->all();

        $assemblymen = $this->assemblymanRepository->create($input);

        return $this->sendResponse($assemblymen->toArray(), 'Assemblyman saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/assemblymen/{id}",
     *      summary="Display the specified Assemblyman",
     *      tags={"Assemblyman"},
     *      description="Get Assemblyman",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Assemblyman",
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
     *                  ref="#/definitions/Assemblyman"
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
        /** @var Assemblyman $assemblyman */
        $assemblyman = $this->assemblymanRepository->find($id);

        if (empty($assemblyman)) {
            return Response::json(ResponseUtil::makeError('Assemblyman not found'), 400);
        }

        return $this->sendResponse($assemblyman->toArray(), 'Assemblyman retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateAssemblymanAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/assemblymen/{id}",
     *      summary="Update the specified Assemblyman in storage",
     *      tags={"Assemblyman"},
     *      description="Update Assemblyman",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Assemblyman",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Assemblyman that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Assemblyman")
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
     *                  ref="#/definitions/Assemblyman"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAssemblymanAPIRequest $request)
    {
        $input = $request->all();

        /** @var Assemblyman $assemblyman */
        $assemblyman = $this->assemblymanRepository->find($id);

        if (empty($assemblyman)) {
            return Response::json(ResponseUtil::makeError('Assemblyman not found'), 400);
        }

        $assemblyman = $this->assemblymanRepository->update($input, $id);

        return $this->sendResponse($assemblyman->toArray(), 'Assemblyman updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/assemblymen/{id}",
     *      summary="Remove the specified Assemblyman from storage",
     *      tags={"Assemblyman"},
     *      description="Delete Assemblyman",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Assemblyman",
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
        /** @var Assemblyman $assemblyman */
        $assemblyman = $this->assemblymanRepository->find($id);

        if (empty($assemblyman)) {
            return Response::json(ResponseUtil::makeError('Assemblyman not found'), 400);
        }

        $assemblyman->delete();

        return $this->sendResponse($id, 'Assemblyman deleted successfully');
    }
}
