<?php

namespace App\Livewire\Admin\LocationManagement;

use App\Models\Barangay;
use App\Models\Municipality;
use App\Models\Province;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Location extends Component
{
    use WithPagination;
    use WithoutUrlPagination;

    public $defaultFilter;

    // barangay
    public $barPost, $bcodePost, $munSelect, $munHidden;
    public $editbarID, $editbarPost, $editbcodePost, $editmunSelect, $editmunHidden;

    // municipality
    public $munPost, $mcodePost, $provSelect, $provHidden;
    public $editmunID, $editmunPost, $editmcodePost, $editprovSelect, $editprovHidden;

    // province
    public $provPost, $pcodePost;
    public $editprovID, $editprovPost, $editpcodePost;

    public $search, $searchMun, $searchProv;

    public function mount()
    {
        // Initialize the public key
        $this->defaultFilter = 'Barangay';
    }

    public function locationFilter($newValue)
    {
        // Update the public key
        $this->defaultFilter = $newValue;
        $this->resetPage();
    }

    public function saveLocation($type)
    {
        // Define rules and messages for each type
        $validationData = [
            'barangay' => [
                'rules' => [
                    'barPost' => ['required', 'string', Rule::unique('barangay', 'barangay_Name')
                            ->where(function ($query) {
                                return $query->where('municipality_id', $this->munHidden);
                            })],
                    'bcodePost' => ['required', 'string', 'max:10', Rule::unique('barangay', 'barangay_Code')
                            ->where(function ($query) {
                                return $query->where('municipality_id', $this->munHidden);
                            })],
                    'munSelect' => ['required', 'string'],
                    'munHidden' => ['required'],
                ],
                'messages' => [
                    'barPost.required' => 'The barangay is required.',
                    'barPost.unique' => 'The barangay has already been taken.',
                    'bcodePost.required' => 'The barangay code is required.',
                    'bcodePost.unique' => 'The barangay code has already been taken.',
                    'bcodePost.max' => 'The municipality barangay must not exceed 10 characters.',
                    'munSelect.required' => 'The municipality selection is required.',
                ],
                'model' => Barangay::class,
                'data' => [
                    'municipality_id' => 'munHidden',
                    'barangay_Name' => 'barPost',
                    'barangay_Code' => 'bcodePost',
                ],
                'successMessage' => 'Barangay Added!',
            ],
            'municipality' => [
                'rules' => [
                    'munPost' => ['required', 'string', Rule::unique('municipality', 'municipality_Name')
                            ->where(function ($query) {
                                return $query->where('province_id', $this->provHidden);
                            })],
                    'mcodePost' => ['required', 'string', 'max:10', Rule::unique('municipality', 'municipality_Code')
                            ->where(function ($query) {
                                return $query->where('province_id', $this->provHidden);
                            })],
                    'provSelect' => ['required', 'string'],
                ],
                'messages' => [
                    'munPost.required' => 'The municipality is required.',
                    'munPost.unique' => 'The municipality has already been taken.',
                    'mcodePost.required' => 'The municipality code is required.',
                    'mcodePost.unique' => 'The municipality code has already been taken.',
                    'mcodePost.max' => 'The municipality code must not exceed 10 characters.',
                    'provSelect.required' => 'The province selection is required.',
                ],
                'model' => Municipality::class,
                'data' => [
                    'province_id' => 'provHidden',
                    'municipality_Name' => 'munPost',
                    'municipality_Code' => 'mcodePost',
                ],
                'successMessage' => 'Municipality Added!',
            ],
            'province' => [
                'rules' => [
                    'provPost' => ['required', 'string', Rule::unique('province', 'province_Name')],
                    'pcodePost' => ['required', 'string', 'max:10', Rule::unique('province', 'province_Code')],
                ],
                'messages' => [
                    'provPost.required' => 'The province is required.',
                    'provPost.unique' => 'The province has already been taken.',
                    'pcodePost.required' => 'The province code is required.',
                    'pcodePost.unique' => 'The province code has already been taken.',
                    'pcodePost.max' => 'The province code must not exceed 10 characters.',
                ],
                'model' => Province::class,
                'data' => [
                    'province_Name' => 'provPost',
                    'province_Code' => 'pcodePost',
                ],
                'successMessage' => 'Province Added!',
            ],
        ];

        // Validate input
        if (isset($validationData[$type])) {
            $this->validate($validationData[$type]['rules'], $validationData[$type]['messages']);

            try {
                // Create the record
                $dataToCreate = $this->prepareData($validationData[$type]['data']);
                // dd($dataToCreate);
                $validationData[$type]['model']::create($dataToCreate);

                toastr()->success($validationData[$type]['successMessage']);
                $this->resetExcept('defaultFilter');
            } catch (\Exception $e) {
                dd($e->getMessage());
                toastr()->error('There was an Error');
            }
        } else {
            toastr()->error('Invalid location type');
        }
    }

    private function prepareData($data)
    {
        return array_map(function ($key) {
            return strtoupper($this->{$key});
        }, $data);
    }

    public function selectLocation($type, $id)
    {
        if ($type == 'municipality') {
            $municipality = Municipality::findOrFail($id);

            // Check if the municipality exists
            if ($municipality) {
                // Get the province name using the 'province' relationship
                $provinceName = $municipality->province->province_Name;

                // Combine the municipality name and province name
                $result = $municipality->municipality_Name . ' , ' . $provinceName;

                // Return the result
                $this->munSelect = $result;
                $this->munHidden = $id;
            } else {
                toastr()->error('There was an error fetching the data.');
            }

        } elseif ($type == 'province') {
            $province = Province::findOrFail($id);

            // Check if the municipality exists
            if ($province) {

                $this->provSelect = $province->province_Name;
                $this->provHidden = $id;
            }
        } else {
            toastr()->error('There was an error fetching the data.');
        }

    }

    public function editLocation($type, $id)
    {
        if ($type == 'barangay') {
            $barangay = Barangay::with('municipality.province')->find($id);

            if ($barangay) {
                $this->editbarID = $barangay->barangay_id;
                $this->editbarPost = $barangay->barangay_Name;
                $this->editbcodePost = $barangay->barangay_Code;
                $this->editmunSelect = $barangay->municipality->municipality_Name . ', ' . $barangay->municipality->province->province_Name;
                $this->editmunHidden = $barangay->municipality->municipality_id;

                $this->dispatch('open-modal', 'bar-edit-modal');
            } else {
                toastr()->error('There was an error fetching the data.');
            }

        } else if ($type == 'municipality') {
            $municipality = Municipality::with('province')->find($id);

            if ($municipality) {
                $this->editmunID = $municipality->municipality_id;
                $this->editmunPost = $municipality->municipality_Name;
                $this->editmcodePost = $municipality->municipality_Code;
                $this->editprovSelect = $municipality->province->province_Name;
                $this->editprovHidden = $municipality->province->province_id;

                $this->dispatch('open-modal', 'mun-edit-modal');
            } else {
                toastr()->error('There was an error fetching the data.');
            }

        } else if ($type == 'province') {
            $province = Province::find($id);

            if ($province) {
                $this->editprovID = $province->province_id;
                $this->editprovPost = $province->province_Name;
                $this->editpcodePost = $province->province_Code;

                $this->dispatch('open-modal', 'prov-edit-modal');
            } else {
                toastr()->error('There was an error fetching the data.');
            }
        }
    }

    public function updateLocation($type)
    {
        if ($type == 'barangay') {

            if ($this->editbarID) {
                $rules = [
                    'editbarPost' => ['required', 'string', Rule::unique('barangay', 'barangay_Name')->where(function ($query) {
                        return $query->where('municipality_id', $this->editmunHidden);
                    })->ignore($this->editbarID, 'barangay_id')],
                    'editbcodePost' => ['required', 'string', 'max:10', Rule::unique('barangay', 'barangay_Code')->where(function ($query) {
                        return $query->where('municipality_id', $this->editmunHidden);
                    })->ignore($this->editbarID, 'barangay_id')],
                    'editmunSelect' => 'required|string',
                    'editmunHidden' => 'required',
                ];

                $messages = [
                    'editbarPost.required' => 'The barangay is required.',
                    'editbarPost.string' => 'The barangay must be a string.',
                    'editbarPost.unique' => 'The barangay has already been taken.',
                    'editbcodePost.required' => 'The barangay code is required.',
                    'editbcodePost.string' => 'The barangay code must be a string.',
                    'editbcodePost.unique' => 'The barangay code has already been taken.',
                    'editbcodePost.max' => 'The barangay must not exceed 10 characters.',
                    'editmunSelect.required' => 'The municipality select is required.',
                    'editmunSelect.string' => 'The municipality select must be a string.',
                    'editmunHidden.required' => 'The municipality field is required.',
                ];

                $this->validate($rules, $messages);

                DB::beginTransaction();
                try {
                    $barangay = Barangay::findOrFail($this->editbarID);

                    // Updating fields
                    $barangay->barangay_Name = $this->editbarPost;
                    $barangay->barangay_Code = $this->editbcodePost;
                    $barangay->municipality_id = $this->editmunHidden;

                    if ($barangay->isDirty()) {
                        $barangay->save();
                        toastr()->success('Barangay has been updated!');
                    } else {
                        toastr()->info('No changes detected.');
                    }

                    DB::commit();
                    $this->close('bar-edit');
                    $this->resetExcept('defaultFilter');

                } catch (\Exception $e) {
                    DB::rollBack();
                    $this->close('bar-edit');
                    toastr()->error('There was an error updating the barangay.');
                }
            }
        } else if ($type == 'municipality') {
            $rules = [
                'editmunPost' => ['required', 'string', Rule::unique('municipality', 'municipality_Name')->where(function ($query) {
                    return $query->where('province_id', $this->editprovHidden);
                })->ignore($this->editmunID, 'municipality_id')],
                'editmcodePost' => ['required', 'string', 'max:10', Rule::unique('municipality', 'municipality_Code')->where(function ($query) {
                    return $query->where('province_id', $this->editprovHidden);
                })->ignore($this->editmunID, 'municipality_id')],
                'editprovSelect' => 'required|string',
                'editprovHidden' => 'required',
            ];

            $messages = [
                'editmunPost.required' => 'The municipality is required.',
                'editmunPost.string' => 'The municipality must be a string.',
                'editmunPost.unique' => 'The municipality has already been taken.',
                'editmcodePost.required' => 'The municipality code is required.',
                'editmcodePost.string' => 'The municipality code must be a string.',
                'editmcodePost.unique' => 'The municipality code has already been taken.',
                'editmcodePost.max' => 'The municipality must not exceed 10 characters.',
                'editprovSelect.required' => 'The municipality select is required.',
                'editprovSelect.string' => 'The municipality select must be a string.',
                'editprovHidden.required' => 'The municipality field is required.',
            ];
            $this->validate($rules, $messages);

            DB::beginTransaction();
            try {
                $municipality = Municipality::findOrFail($this->editmunID);

                // Updating fields
                $municipality->municipality_Name = $this->editmunPost;
                $municipality->municipality_Code = $this->editmcodePost;
                $municipality->province_id = $this->editprovHidden;

                if ($municipality->isDirty()) {
                    $municipality->save();
                    toastr()->success('Municipality has been updated!');
                } else {
                    toastr()->info('No changes detected.');
                }

                DB::commit();
                $this->close('mun-edit');
                $this->resetExcept('defaultFilter');
            } catch (\Exception $e) {
                DB::rollBack();
                $this->close('mun-edit');
                toastr()->error('There was an error updating the barangay.');
            }

        } else if ($type == 'province') {
            $rules = [
                'editprovPost' => ['required', 'string', Rule::unique('province', 'province_Name')->ignore($this->editprovID, 'province_id')],
                'editpcodePost' => ['required', 'string', 'max:10', Rule::unique('province', 'province_Code')->ignore($this->editprovID, 'province_id')],
            ];

            $messages = [
                'editprovPost.required' => 'The municipality is required.',
                'editprovPost.string' => 'The municipality must be a string.',
                'editprovPost.unique' => 'The municipality has already been taken.',
                'editpcodePost.required' => 'The municipality code is required.',
                'editpcodePost.string' => 'The municipality code must be a string.',
                'editpcodePost.max' => 'The municipality must not exceed 10 characters.',
                'editpcodePost.unique' => 'The municipality code has already been taken.',
            ];
            $this->validate($rules, $messages);

            DB::beginTransaction();
            try {
                $province = Province::findOrFail($this->editprovID);

                // Updating fields
                $province->province_Name = $this->editprovPost;
                $province->province_Code = $this->editpcodePost;

                if ($province->isDirty()) {
                    $province->save();
                    toastr()->success('Municipality has been updated!');
                } else {
                    toastr()->info('No changes detected.');
                }

                DB::commit();
                $this->close('prov-edit');
                $this->resetExcept('defaultFilter');

            } catch (\Exception $e) {
                DB::rollBack();
                $this->close('prov-edit');
                toastr()->error('There was an error updating the barangay.');
            }

        }
    }

    public function setLocation($type, $id)
    {
        if ($type == 'municipality') {
            $municipality = Municipality::with('province')->findOrFail($id);

            if ($municipality) {
                $this->editmunSelect = $municipality->municipality_Name . ', ' . $municipality->province->province_Name;
                $this->editmunHidden = $municipality->municipality_id;

            }
        } else if ($type == 'province') {
            $province = Province::findOrFail($id);

            if ($province) {
                $this->editprovSelect = $province->province_Name;
                $this->editprovHidden = $province->province_id;

                $this->dispatch('open-modal', 'mun-edit-modal');
            }
        }
    }

    public function close($modal)
    {
        $this->resetValidation();
        $this->resetExcept('search', 'defaultFilter');
        $this->dispatch('close-modal', $modal . '-modal');
    }

    public function render()
    {

        // TABLE FETCH
        if ($this->defaultFilter === 'Barangay') {
            $locationData = Barangay::with('municipality.province')
                ->where('barangay_Name', 'like', '%' . $this->search . '%')
                ->orWhereHas('municipality', function ($query) {
                    $query->where('municipality_Name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('municipality.province', function ($query) {
                    $query->where('province_Name', 'like', '%' . $this->search . '%');
                })
                ->orderBy('barangay_Name', 'asc')
                ->paginate(10);
        } else if ($this->defaultFilter === 'Municipalities') {
            $locationData = Municipality::with('province')
                ->where('municipality_Name', 'like', '%' . $this->search . '%')
                ->orWhereHas('province', function ($query) {
                    $query->where('province_Name', 'like', '%' . $this->search . '%');
                })
                ->orderBy('municipality_Name', 'asc')->paginate(10);
        } else if ($this->defaultFilter === 'Provinces') {
            $locationData = Province::where('province_Name', 'like', '%' . $this->search . '%')
            ->orderBy('province_Name', 'asc') ->paginate(10);
        }

        // MODALS FETCH
        $municipalities = Municipality::with('province')
            ->where(function ($query) {
                $query->where('municipality_Name', 'like', '%' . $this->searchMun . '%')
                    ->orWhereHas('province', function ($subQuery) {
                        $subQuery->where('province_Name', 'like', '%' . $this->searchMun . '%');
                    });
            })
            ->paginate(10);

        $provinces = Province::where('province_Name', 'like', '%' . $this->searchProv . '%')
        ->orderBy('province_Name', 'asc')->paginate(10);

        return view('livewire.admin.location-management.location', compact('locationData', 'municipalities', 'provinces'));
    }
}
