<?php

declare(strict_types=1);

namespace App\Services\Api\Company;


use App\Models\Company;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiCompanyService
{
    /**
     * @param array $paginate
     * @return Paginator
     */
    public function getCompaniesPaginationResult(array $paginate): Paginator
    {
        $items = $this->getCompaniesBuilder()->get();
        $page = $paginate['page'];
        $pagination = $paginate['pagination'];

        return new LengthAwarePaginator(
            $items->forPage($page, $pagination),
            $items->count(),
            $pagination,
        );
    }

    /**
     * @param int $company_id
     * @param array $paginate
     * @return Model
     */
    public function getSingleCompanyWithPaginationClientResult(int $company_id, array $paginate): Model
    {
        $company = $this->getCompaniesBuilder()->with('clients')->withCount('clients')->find($company_id);
        $company->extra = (object) $paginate;
        return $company;
    }

    /**
     * @return Builder
     */
    private function getCompaniesBuilder(): Builder
    {
        return Company::query();
    }
}
