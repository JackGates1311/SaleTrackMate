<?php

namespace App\Services;

use App\Constants;
use App\Models\Company;
use App\Models\GoodOrService;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GoodOrServiceService
{
    private GoodOrServiceDetailsService $goodOrServiceDetailsService;

    public function __construct(GoodOrServiceDetailsService $goodOrServiceDetailsService)
    {
        $this->goodOrServiceDetailsService = $goodOrServiceDetailsService;
    }

    public function index(): array
    {
        $goods_or_services = GoodOrService::with('company', 'goodOrServiceDetails')->get()->toArray();

        return ['goods_or_services' => $goods_or_services];
    }

    public function findByCompanyId($id): array
    {
        $company = (new Company)->find($id);

        if (!$company) {
            return ['success' => false, 'message' => Constants::GOOD_OR_SERVICE_NOT_FOUND . ': ' . $id];
        } else {
            $goods_or_services = $company->goods_or_services;
        }

        if (!$goods_or_services) {
            return ['success' => false, 'message' => Constants::GOOD_OR_SERVICE_NOT_FOUND . ': ' . $id];
        }

        return ['success' => true, 'goods_or_services' => $goods_or_services];
    }

    public function show($id): array
    {
        $good_or_service = GoodOrService::with('company', 'goodOrServiceDetails')->find($id);

        if (!$good_or_service) {
            return ['success' => false, 'message' => Constants::GOOD_OR_SERVICE_NOT_FOUND . ": " . $id];
        }

        return ['success' => true, 'message' => 'OK', 'good_or_service' => $good_or_service];
    }

    /**
     * @throws ValidationException
     */
    public function update(array $data, $id): array
    {
        $validated_data = Validator::make($data, GoodOrService::$rules)->validate();

        $good_or_service = GoodOrService::find($id);

        if (!$good_or_service) {
            return ['success' => false, 'message' => Constants::GOOD_OR_SERVICE_NOT_FOUND . ": " . $id];
        }

        try {
            $good_or_service->update($validated_data);
            return ['success' => true, 'message' => Constants::GOOD_OR_SERVICE_UPDATE_SUCCESS, 'good_or_service' => $good_or_service];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::GOOD_OR_SERVICE_UPDATE_FAIL . ': ' . $e->getMessage()];
        }
    }

    /**
     * @throws ValidationException
     */
    public function store(array $data, string $company_id): array
    {
        $data['company_id'] = $company_id;
        $validated_data = Validator::make($data, GoodOrService::$rules)->validate();

        try {
            $good_or_service = GoodOrService::create($validated_data);

            if (array_key_exists('good_or_service_details', $data)) {
                $this->goodOrServiceDetailsService->store($data['good_or_service_details']);
            }

            return ['success' => true, 'message' => Constants::GOOD_OR_SERVICE_SAVE_SUCCESS,
                'good_or_service' => $good_or_service];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::GOOD_OR_SERVICE_SAVE_FAIL . ": " . $e->getMessage()];
        }
    }
}
