<?php

namespace App\Services;

use App\Constants;
use App\Models\Company;
use App\Models\GoodOrService;
use App\Models\GoodOrServiceDetails;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GoodOrServiceService
{
    private GoodOrServiceDetailsService $goodOrServiceDetailsService;
    private PriceService $priceService;
    private PriceDiscountService $priceDiscountService;

    private TaxCategoryService $taxCategoryService;

    public function __construct(GoodOrServiceDetailsService $goodOrServiceDetailsService, PriceService $priceService,
                                PriceDiscountService        $priceDiscountService, TaxCategoryService $taxCategoryService)
    {
        $this->goodOrServiceDetailsService = $goodOrServiceDetailsService;
        $this->priceService = $priceService;
        $this->priceDiscountService = $priceDiscountService;
        $this->taxCategoryService = $taxCategoryService;
    }

    public function index(): array
    {
        $goods_or_services = GoodOrService::all();

        return ['goods_or_services' => $goods_or_services];
    }

    public function indexWithDetails(): array
    {
        $goods_or_services = GoodOrService::with('company', 'goodOrServiceDetails', 'prices', 'priceDiscounts',
            'UnitOfMeasure', 'TaxCategory')->get()->toArray();

        return ['goods_or_services' => $goods_or_services];
    }

    public function findByCompanyId($id): array
    {
        $company = (new Company)->find($id);

        if (!$company) {
            return ['success' => false, 'message' => Constants::COMPANY_NOT_FOUND . ': ' . $id];
        } else {
            $goods_or_services = $company->goodsOrServices;
        }

        if (!$goods_or_services) {
            return ['success' => false, 'message' => Constants::GOOD_OR_SERVICE_NOT_FOUND . ': ' . $id];
        } else {
            $goods_or_services->load('prices');
            $goods_or_services->load('goodOrServiceDetails');
            $goods_or_services->load('unitOfMeasure');
            $goods_or_services->load('taxCategory');
            $goods_or_services->load('priceDiscounts');
        }

        foreach ($goods_or_services as $good_or_service) {
            if (isset($good_or_service->taxCategory)) {
                $good_or_service->taxCategory['actual_tax_rate'] = $this->taxCategoryService->
                getActualTaxRate($good_or_service->taxCategory, Carbon::now());
            }
            if (isset($good_or_service->prices)) {
                $good_or_service['actual_price'] = $this->priceService->getActualPrice(
                    $good_or_service->prices, Carbon::now());
            }
            if (isset($good_or_service->priceDiscounts) || $good_or_service->priceDiscounts == []) {
                $good_or_service['actual_price_discount'] = $this->priceDiscountService->getActualPriceDiscount(
                    $good_or_service->priceDiscounts, Carbon::now());

                if ($good_or_service['actual_price_discount']) {
                    $base_price = $good_or_service['actual_price']['amount'];
                    $discounted_price = $base_price - ($base_price * (
                                $good_or_service['actual_price_discount']->percentage / 100));

                    $good_or_service['actual_price_with_discount'] = $discounted_price;
                }
            }
        }

        return ['success' => true, 'goods_or_services' => $goods_or_services];
    }

    public function show($id): array
    {
        $good_or_service = GoodOrService::with('company', 'goodOrServiceDetails', 'prices', 'priceDiscounts',
            'UnitOfMeasure', 'TaxCategory')->find($id);

        if (!$good_or_service) {
            return ['success' => false, 'message' => Constants::GOOD_OR_SERVICE_NOT_FOUND . ": " . $id];
        }

        return ['success' => true, 'message' => 'OK', 'good_or_service' => $good_or_service];
    }

    public function update(array $data, $id): array
    {
        $good_or_service = GoodOrService::find($id);

        if (!$good_or_service) {
            return ['success' => false, 'message' => Constants::GOOD_OR_SERVICE_NOT_FOUND . ": " . $id];
        }

        try {
            DB::beginTransaction();

            if (array_key_exists('good_or_service_details', $data)) {
                $data['good_or_service_details']['country'] = $data['country'];
                $this->goodOrServiceDetailsService->update($data['good_or_service_details'],
                    $good_or_service->good_or_service_details_id);
            }

            $data['company_id'] = $good_or_service->company_id;
            $data['good_or_service_details_id'] = $good_or_service->good_or_service_details_id;

            $validated_data = Validator::make($data, GoodOrService::$rules)->validate();

            try {
                $good_or_service->update($validated_data);
                DB::commit();
                return ['success' => true, 'message' => Constants::GOOD_OR_SERVICE_UPDATE_SUCCESS,
                    'good_or_service' => $good_or_service];
            } catch (Exception $e) {
                DB::rollBack();
                return ['success' => false,
                    'message' => Constants::GOOD_OR_SERVICE_UPDATE_FAIL . ': ' . $e->getMessage()];
            }
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false,
                'message' => Constants::GOOD_OR_SERVICE_UPDATE_FAIL . ': ' . $e->getMessage()];
        }
    }

    public function store(array $data, string $company_id): array
    {
        $data['company_id'] = $company_id;

        try {
            DB::beginTransaction();
            try {
                $good_or_service_details = [];

                if ($data['tax_category_id'] == 'other' || $data['tax_category_id'] == '') {
                    $data['tax_category_id'] = null;
                }

                if ($data['unit_of_measure_id'] == 'other' || $data['unit_of_measure_id'] == '') {
                    $data['unit_of_measure_id'] = null;
                }

                if (array_key_exists('good_or_service_details', $data)) {
                    $data['good_or_service_details']['country'] = $data['country'];
                    $good_or_service_details = $this->goodOrServiceDetailsService->store(
                        $data['good_or_service_details']);
                }

                $data['good_or_service_details_id'] = $good_or_service_details['good_or_service_details']['id'];

                $good_or_service_validate_data = Validator::make($data, GoodOrService::$rules)->validate();

                $good_or_service = GoodOrService::create($good_or_service_validate_data);

                if (array_key_exists('price_discount', $data)) {
                    $this->priceDiscountService->store($data['price_discount'],
                        $good_or_service->id);
                }

                if (array_key_exists('price', $data)) {
                    $this->priceService->store($data['price'], $good_or_service->id);
                }

                DB::commit();
                return ['success' => true, 'message' => Constants::GOOD_OR_SERVICE_SAVE_SUCCESS,
                    'good_or_service' => $good_or_service];
            } catch (Exception $e) {
                DB::rollBack();
                return ['success' => false, 'message' => Constants::GOOD_OR_SERVICE_SAVE_FAIL . ": " . $e->getMessage()];
            }
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => Constants::INVOICE_SAVE_FAIL . ': ' . $e->getMessage()];
        }
    }

    public function destroy($id): array
    {
        $good_or_service = GoodOrService::find($id);

        if (!$good_or_service) {
            return ['success' => false, 'message' => Constants::GOOD_OR_SERVICE_NOT_FOUND . ': ' . $id];
        }

        try {
            DB::beginTransaction();

            $good_or_service_details_id = $good_or_service->good_or_service_details_id;
            $good_or_service->good_or_service_details_id = null;
            $good_or_service->tax_category_id = null;
            $good_or_service->unit_of_measure_id = null;
            $good_or_service->update($good_or_service->toArray());

            $good_or_service_details = GoodOrServiceDetails::find($good_or_service_details_id);
            if ($good_or_service_details) {
                $good_or_service_details->delete();
            }

            $prices = $good_or_service->prices;
            foreach ($prices as $price) {
                $price->delete();
            }

            $price_discounts = $good_or_service->priceDiscounts;
            foreach ($price_discounts as $price_discount) {
                $price_discount->delete();
            }

            $good_or_service->delete();

            DB::commit();
            return ['success' => true, 'message' => Constants::GOOD_OR_SERVICE_DELETE_SUCCESS,
                'good_or_service' => $good_or_service];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => Constants::GOOD_OR_SERVICE_DELETE_FAIL . ': ' . $e->getMessage(),
                'good_or_service' => $good_or_service];
        }
    }
}
