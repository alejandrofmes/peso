<?php

namespace App\Livewire\Public;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class SearchProfiles extends Component
{

    use WithPagination;

    #[Url]
    public $q;

    public function render()
    {

        $this->q = str_replace("'", "", $this->q);

        // Fetch employees with related user data
        $employeeQuery = DB::table('employee')
            ->leftJoin('barangay', 'employee.barangay_id', '=', 'barangay.barangay_id')
            ->leftJoin('municipality', 'barangay.municipality_id', '=', 'municipality.municipality_id')
            ->leftJoin('users', 'employee.user_id', '=', 'users.id')
            ->select(
                DB::raw("'employee' as type"),
                'employee.employee_id as id',
                'employee.empStatus as empStatus',
                'employee.pimg as pimage',
                DB::raw("CONCAT_WS(' ', employee.fname, employee.mname, employee.lname) as name"),
                DB::raw("'' as trade_name"),
                DB::raw("'' as company_Type"),
                DB::raw("'' as employer_Type"),
                'barangay.barangay_Name as barangay_name',
                'municipality.municipality_Name as municipality_name',
                DB::raw("(
                    (employee.fname LIKE '%$this->q%') +
                    (employee.mname LIKE '%$this->q%') +
                    (employee.lname LIKE '%$this->q%')
                ) as relevance_score")
            )
            ->where('users.usertype', '=', '4')
            ->where('users.userstatus', '=', '1')
            ->when(true, function ($query) {
                if (Auth::user()->usertype == 4) {
                    // Add a condition if userstatus is 1
                    $query->where('employee.empprofile', 3);
                } else if (Auth::user()->usertype == 6) {
                    // Else, if userstatus is not 1, apply another condition
                    $query->whereIn('employee.empprofile', [2, 3]);
                }
            })
            ->where(function ($query) {
                $query->where('employee.fname', 'like', '%' . $this->q . '%')
                    ->orWhere('employee.mname', 'like', '%' . $this->q . '%')
                    ->orWhere('employee.lname', 'like', '%' . $this->q . '%');
            });

        // Fetch companies with related user data
        $companyQuery = DB::table('company')
            ->leftJoin('barangay', 'company.barangay_id', '=', 'barangay.barangay_id')
            ->leftJoin('municipality', 'barangay.municipality_id', '=', 'municipality.municipality_id')
            ->leftJoin('users', 'company.user_id', '=', 'users.id')
            ->select(
                DB::raw("'company' as type"),
                'company.company_Id as id',
                DB::raw("'' as empStatus"),
                'company.company_img as pimage',
                'company.business_Name as name',
                'company.trade_Name as trade_name',
                'company.company_Type as company_Type',
                'company.employer_Type as employer_Type',
                'barangay.barangay_Name as barangay_name',
                'municipality.municipality_Name as municipality_name',
                DB::raw("(
                    (company.business_Name LIKE '%$this->q%') +
                    (company.trade_Name LIKE '%$this->q%')
                ) as relevance_score")
            )
            ->where('users.usertype', '=', '6')
            ->where('users.userstatus', '=', '1')
            ->where(function ($query) {
                $query->where('company.business_Name', 'like', '%' . $this->q . '%')
                    ->orWhere('company.trade_Name', 'like', '%' . $this->q . '%');
            });

        // Fetch PESO with related municipality data
        $pesoQuery = DB::table('peso')
            ->leftJoin('municipality', 'peso.municipality_id', '=', 'municipality.municipality_id')
            ->select(
                DB::raw("'peso' as type"),
                'peso.peso_id as id',
                DB::raw("'' as empStatus"),
                'peso.peso_Img as pimage',
                DB::raw("CONCAT('PESO ', municipality.municipality_Name) as name"),
                DB::raw("'' as trade_name"),
                DB::raw("'' as company_Type"),
                DB::raw("'' as employer_Type"),
                DB::raw("'' as barangay_name"),

                'municipality.municipality_Name as municipality_name',
                DB::raw("(
                    (peso.peso_Description LIKE '%$this->q%') +
                    (municipality.municipality_Name LIKE '%$this->q%') +
                    ('PESO ' LIKE '%$this->q%')
                ) as relevance_score")
            )
            ->where(function ($query) {
                $query->where('peso.peso_Description', 'like', '%' . $this->q . '%')
                    ->orWhere('municipality.municipality_Name', 'like', '%' . $this->q . '%')
                    ->orWhere(DB::raw("CONCAT('PESO ', municipality.municipality_Name)"), 'like', '%' . $this->q . '%');
            });

        // Combine all queries and order by relevance_score
        $results = $employeeQuery->union($companyQuery)
            ->union($pesoQuery)
            ->orderByDesc('relevance_score')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.public.search-profiles', compact('results'));
    }

}
