<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateConfigAPIRequest;
use App\Http\Requests\API\UpdateConfigAPIRequest;
use App\Models\Config;
use App\Repositories\ConfigRepository;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ConfigController.
 */
class ConfigAPIController extends AppBaseController
{
    /** @var ConfigRepository */
    private $configRepository;

    public function __construct(ConfigRepository $configRepo)
    {
        $this->configRepository = $configRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/configs",
     *      summary="Get a listing of the Configs.",
     *      tags={"Config"},
     *      description="Get all Configs",
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
     *                  @SWG\Items(ref="#/definitions/Config")
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
        $this->configRepository->pushCriteria(new RequestCriteria($request));
        $this->configRepository->pushCriteria(new LimitOffsetCriteria($request));
        $configs = $this->configRepository->all();

        return $this->sendResponse($configs->toArray(), 'Configs retrieved successfully');
    }

    /**
     * @param CreateConfigAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/configs",
     *      summary="Store a newly created Config in storage",
     *      tags={"Config"},
     *      description="Store Config",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Config that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Config")
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
     *                  ref="#/definitions/Config"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateConfigAPIRequest $request)
    {
        $input = $request->all();

        $configs = $this->configRepository->create($input);

        return $this->sendResponse($configs->toArray(), 'Config saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/configs/{id}",
     *      summary="Display the specified Config",
     *      tags={"Config"},
     *      description="Get Config",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Config",
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
     *                  ref="#/definitions/Config"
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
        /** @var Config $config */
        $config = $this->configRepository->find($id);

        if (empty($config)) {
            return Response::json(ResponseUtil::makeError('Config not found'), 400);
        }

        return $this->sendResponse($config->toArray(), 'Config retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateConfigAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/configs/{id}",
     *      summary="Update the specified Config in storage",
     *      tags={"Config"},
     *      description="Update Config",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Config",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Config that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Config")
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
     *                  ref="#/definitions/Config"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateConfigAPIRequest $request)
    {
        $input = $request->all();

        /** @var Config $config */
        $config = $this->configRepository->find($id);

        if (empty($config)) {
            return Response::json(ResponseUtil::makeError('Config not found'), 400);
        }

        $config = $this->configRepository->update($input, $id);

        return $this->sendResponse($config->toArray(), 'Config updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/configs/{id}",
     *      summary="Remove the specified Config from storage",
     *      tags={"Config"},
     *      description="Delete Config",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Config",
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
        /** @var Config $config */
        $config = $this->configRepository->find($id);

        if (empty($config)) {
            return Response::json(ResponseUtil::makeError('Config not found'), 400);
        }

        $config->delete();

        return $this->sendResponse($id, 'Config deleted successfully');
    }
}
