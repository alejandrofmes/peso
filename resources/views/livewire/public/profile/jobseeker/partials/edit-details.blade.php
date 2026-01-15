<div>
    <div class="grid items-center grid-cols-4 gap-5 p-0 mx-8 mt-4 lg:grid-cols-12 lg:p-6">
        <div class="col-span-4 lg:col-span-3">

        </div>

        <div class="col-span-4 lg:col-span-9">

            <div class="flex flex-row items-center gap-4">
                <a href="{{ route('jobseeker.profile', ['id' => auth()->user()->employee->employee_id]) }}">
                    <div class="flex items-center p-1 transition-transform rounded-full hover:bg-gray-300">
                        <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                    </div>
                </a>
                <h2 class="text-2xl font-bold">Edit Profile</h2>

            </div>


        </div>

        <div class="col-span-4 lg:col-span-3">

        </div>


        <div class="col-span-4 lg:col-span-6" x-data="{
            openTab: 1,
            activeTab: 'text-blue-600 bg-gray-100  rounded-t-lg active',
            inactiveTab: ' rounded-t-lg hover:text-gray-600 hover:bg-gray-50',
        }">
            <div class="p-6 bg-white rounded-lg shadow-lg">


                <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200">
                    <li class="me-2">
                        <button @click="openTab = 1" :class="openTab === 1 ? activeTab : inactiveTab"
                            aria-current="page" class="inline-block p-4">Basic Information</button>
                    </li>
                    <li class="me-2">
                        <button @click="openTab = 2" :class="openTab === 2 ? activeTab : inactiveTab"
                            aria-current="page" class="inline-block p-4">Language</button>
                    </li>
                    <li class="me-2">
                        <button @click="openTab = 3" :class="openTab === 3 ? activeTab : inactiveTab"
                            class="inline-block p-4">Eligibility</button>
                    </li>
                    <li class="me-2">
                        <button @click="openTab = 4" :class="openTab === 4 ? activeTab : inactiveTab"
                            class="inline-block p-4">License</button>
                    </li>
                    <li class="me-2">
                        <button @click="openTab = 5" :class="openTab === 5 ? activeTab : inactiveTab"
                            class="inline-block p-4">Job Preference</button>
                    </li>
                    <li class="me-2">
                        <button @click="openTab = 6" :class="openTab === 6 ? activeTab : inactiveTab"
                            class="inline-block p-4">Resume</button>
                    </li>
                    <li class="me-2">
                        <button @click="openTab = 7" :class="openTab === 7 ? activeTab : inactiveTab"
                            class="inline-block p-4">Privacy</button>
                    </li>
                </ul>

                {{-- BASIC INFORMATION --}}
                <div class="flex flex-col" x-show="openTab === 1" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-cloak>

                    <div class="flex flex-col items-center mt-4">
                        <div class="flex flex-col items-center">
                            <div
                                class="w-[160] h-[160] bg-gray-200 border border-gray-300 rounded-lg overflow-hidden flex items-center justify-center shrink-0">
                                <!-- Display uploaded image here -->
                                @if ($pimg && !$errors->has('pimg'))
                                    <img id="uploadedImage"
                                        class="flex uploaded-image object-contain w-[200px] h-[200px] shrink-0 grow-0"
                                        src="{{ $pimg->temporaryUrl() }}" alt="Uploaded Image" />
                                @else
                                    <img id="uploadedImage"
                                        class="flex uploaded-image object-contain w-[200px] h-[200px] shrink-0 grow-0"
                                        src="{{ asset('storage/' . $employeeDetails->pimg) }}" alt="Uploaded Image" />
                                @endif
                            </div>
                        </div>


                        <x-input-error :messages="$errors->get('pimg')" class="mt-2" />
                        <div class="flex justify-center mt-4 w-160">
                            <label for="imageUpload" wire:loading.attr="disabled" wire:target="pimg"
                                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md cursor-pointer hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Upload Image
                                <div wire:loading.delay.long wire:target="pimg" role="status">
                                    <svg aria-hidden="true"
                                        class="w-4 h-4 ml-4 text-gray-200 animate-spin fill-blue-600"
                                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                            fill="currentColor" />
                                        <path
                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                            fill="currentFill" />
                                    </svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </label>
                            <input wire:model="pimg" type="file" id="imageUpload" class="hidden" accept="image/*">
                        </div>
                    </div>

                    <div class="flex flex-col w-full gap-2 mt-4 lg:flex-row lg:gap-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="fname" :value="__('First Name')" />
                            <x-text-input wire:model="fname" class="block w-full mt-1" type="text" disabled />
                            <x-input-error :messages="$errors->get('fname')" class="mt-2" />

                        </div>
                        <div class="flex flex-col w-full">
                            <x-input-label for="lname" :value="__('Last Name')" />
                            <x-text-input wire:model="lname" class="block w-full mt-1" type="text" disabled />
                            <x-input-error :messages="$errors->get('lname')" class="mt-2" />

                        </div>
                    </div>
                    <div class="flex flex-col gap-2 mt-4 lg:flex-row lg:gap-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="mname" :value="__('Middle Name')" />
                            <x-text-input wire:model="mname" class="block w-full mt-1" type="text" disabled />
                            <x-input-error :messages="$errors->get('mname')" class="mt-2" />

                        </div>

                        <div class="flex flex-col w-full">
                            <x-input-label for="suffix" :value="__('Suffix')" />
                            <select wire:model="suffix" name="suffixPost" class="block w-full mt-1 rounded-md"
                                disabled>
                                <option value="" disabled selected>Select Suffix</option>
                                <option value="">None</option>
                                <option value="Jr">Jr. (Junior)</option>
                                <option value="Sr">Sr. (Senior)</option>
                                <option value="I">I</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                                <option value="V">V</option>
                                <option value="VI">VI</option>
                                <option value="VII">VII</option>
                                <option value="VIII">VIII</option>
                                <option value="IX">IX</option>
                                <option value="X">X</option>
                            </select>
                            <x-input-error :messages="$errors->get('mnsuffixame')" class="mt-2" />

                        </div>
                    </div>

                    <div class="flex flex-col gap-2 mt-4 lg:flex-row lg:gap-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="birthdate" :value="__('Birthdate')" />
                            <x-text-input wire:model="birthdate" class="block w-full mt-1" type="date" disabled />
                            <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />

                        </div>

                        <div class="flex flex-col w-full">
                            <x-input-label for="gender" :value="__('Gender')" />
                            <select wire:model="gender" name="genderPost" class="block w-full mt-1 rounded-md"
                                disabled>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />

                        </div>
                    </div>

                    <div class="flex flex-col w-full gap-2 mt-4 lg:flex-row lg:gap-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="presentAddress" :value="__('Present Address')" />
                            <x-text-input wire:model="address" class="block w-full mt-1" type="text"
                                name="hnumPost" />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />

                        </div>
                        <div class="flex flex-col w-full">
                            <livewire:modals.barangay-signup-modal />
                            <x-input-label for="city" :value="__('Barangay')" />
                            <x-text-input wire:model='bar' class="block w-full mt-1" type="text" readonly
                                x-data="" x-on:click.prevent="dispatch('open-modal', 'barangay-modal')"
                                x-on:focus="$dispatch('open-modal', 'barangay-modal')" />
                            <x-input-error :messages="$errors->get('city')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 lg:flex-row lg:gap-4mt-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="city" :value="__('Municipality')" />
                            <x-text-input wire:model='mun' class="block w-full mt-1" type="text" readonly />
                            <x-input-error :messages="$errors->get('city')" class="mt-2" />
                        </div>
                        <div class="flex flex-col w-full">
                            <x-input-label for="province" :value="__('Province')" />
                            <x-text-input wire:model='prov' class="block w-full mt-1" type="text" readonly />
                            <x-input-error :messages="$errors->get('province')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 mt-4 lg:flex-row lg:gap-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="civilstatus" :value="__('Civil Status')" />
                            <select wire:model="civilstatus" name="civilstatusPost"
                                class="block w-full mt-1 rounded-md">
                                <option value="" disabled selected>Select Civil Status</option>
                                <option value="1">Single</option>
                                <option value="2">Married</option>
                                <option value="3">Widowed</option>

                            </select>
                            <x-input-error :messages="$errors->get('civilstatus')" class="mt-2" />
                        </div>

                        <div class="flex flex-col w-full">
                            <x-input-label for="religion" :value="__('Religion')" />
                            <select wire:model="religion" name="religionPost" class="block w-full mt-1 rounded-md">
                                <option value="" disabled selected>Select Religion</option>
                                <option value="2">ASSEMBLY OF GOD</option>
                                <option value="3">AGLIPAYAN</option>
                                <option value="4">BORN AGAIN CHRISTIAN</option>
                                <option value="5">BAPTIST</option>
                                <option value="6">BUDDIST</option>
                                <option value="7">CHURCH OF GOD THRU CHRIST JESUS</option>
                                <option value="8">CHRISTIAN</option>
                                <option value="9">CHURCH OF CHRIST</option>
                                <option value="10">CHURCH OF GOD</option>
                                <option value="25">CHURCH OF LATTER DAY SAINT</option>
                                <option value="11">EPISCOPALIAN ANGELICAN</option>
                                <option value="12">ESPIRITISM</option>
                                <option value="13">EVANGELICAL</option>
                                <option value="15">FAITH TABERNACLE</option>
                                <option value="14">FOUR SQUARE GOSPEL CHURCH</option>
                                <option value="31">FOURTH WATCH</option>
                                <option value="16">HINDU</option>
                                <option value="19">IGLESIA NG DIYOS KAY CRISTO JESUS</option>
                                <option value="18">IGLESIA NI CRISTO</option>
                                <option value="17">IGLESIA SA DIYOS ESPIRITU SANTO</option>
                                <option value="20">ISLAM</option>
                                <option value="22">JEHOVAH'S WITNESSES</option>
                                <option value="21">JESUS MIRACLE CRUSADE</option>
                                <option value="23">LUTHERAN</option>
                                <option value="24">METHODIST</option>
                                <option value="26">NON-SECTORAL CHARISMATIC</option>
                                <option value="27">ORTHODOX</option>
                                <option value="28">OTHERS</option>
                                <option value="29">PENTECOSTAL</option>
                                <option value="30">PHILIPPINE INDEPENDENT CHRISTIAN CHURCH(PICC/IFI)</option>
                                <option value="32">PRESBYTERIAN</option>
                                <option value="33">PROTESTANT</option>
                                <option value="35">RIZALIST</option>
                                <option value="34">ROMAN CATHOLIC</option>
                                <option value="36">SEVENTH DAY ADVENTIST</option>
                                <option value="1">TWELVE TRIBES OF ISRAEL</option>
                                <option value="38">UNION ESPIRITISTA CRISTIANA</option>
                                <option value="37">UNITED CHURCH CHRISTIAN OF THE PHILIPPINES (UCCP)</option>
                                <option value="39">WESLEYAN CHURCH</option>
                                <option value="40">WORD OF HOPE</option>
                                <option value="41">OTHER</option>
                            </select>
                            <x-input-error :messages="$errors->get('religion')" class="mt-2" />
                        </div>
                    </div>


                    <div class="flex flex-col gap-2 mt-4 lg:flex-row lg:gap-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="pnum" :value="__('Cellphone No.')" />
                            <x-text-input wire:model="pnumber" class="block w-full mt-1" type="tel"
                                name="pnumPost" />
                            <x-input-error :messages="$errors->get('pnumber')" class="mt-2" />
                        </div>
                        <div class="flex flex-col w-full">
                            <x-input-label for="tin" :value="__('TIN')" />
                            <x-text-input wire:model="tinnum" class="block w-full mt-1" type="text"
                                name="tinPost" />
                            <x-input-error :messages="$errors->get('tinnum')" class="mt-2" />
                        </div>
                        <div class="flex flex-col w-full">
                            <x-input-label for="height" :value="__('Height (cm)')" />
                            <x-text-input wire:model="height" class="block w-full mt-1" type="text"
                                name="heightPost" />
                            <x-input-error :messages="$errors->get('height')" class="mt-2" />
                        </div>
                    </div>



                    <div class="flex flex-col gap-4 mt-4 lg:flex-row">
                        <!-- Employment Status Dropdown -->
                        <div class="flex flex-col w-full">
                            <x-input-label for="empStatus" :value="__('Employment Status')" />
                            <select wire:model.live="empStatus" class="block w-full mt-1 rounded">
                                <option value="" disabled>Select Employment Status</option>
                                <option value="1">Employed</option>
                                <option value="2">Unemployed</option>
                            </select>
                            <x-input-error :messages="$errors->get('empStatus')" class="mt-2" />
                        </div>

                        <!-- Employment Description Dropdown -->
                        <div class="flex flex-col w-full">
                            <x-input-label for="empDesc" :value="__('Description')" />
                            <select wire:model="empDesc" class="block w-full mt-1 rounded">
                                <option value="" disabled>Select Description</option>

                                <!-- Dynamically populate the options based on empStatus -->
                                @foreach ($empDescriptions as $desc)
                                    <option value="{{ $desc['value'] }}">{{ $desc['text'] }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('empDesc')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 mt-4 lg:flex-row">
                        <div class="flex flex-col w-1/3">
                            <x-input-label for="OFW" :value="__('Are you an OFW?*')" />
                            <div class="flex flex-row gap-4 mt-2">
                                <div class="flex items-center">
                                    <input wire:model='ofw' id="ofw-yes" type="radio" value="1"
                                        name="ofwStatus" checked
                                        class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                    <label for="ofw-yes" class="text-sm font-medium text-gray-900 ms-2">Yes</label>
                                </div>
                                <div class="flex items-center">
                                    <input wire:model='ofw' id="ofw-no" type="radio" value="2"
                                        name="ofwStatus" checked
                                        class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                    <label for="ofw-no" class="text-sm font-medium text-gray-900 ms-2">No</label>
                                </div>

                            </div>
                            <x-input-error :messages="$errors->get('ofw')" class="mt-2" />

                        </div>
                        <div class="flex flex-wrap w-1/3 gap-6" x-data="{ household: @entangle('fourp') }">

                            <div class="flex flex-col">
                                <x-input-label for="4ps" :value="__('Are you a 4Ps beneficiary*')" />
                                <div class="flex flex-row w-full gap-4 mt-2">
                                    <div class="flex items-center">
                                        <input wire:model='fourp' x-model="household" id="4ps-yes" type="radio"
                                            value="1" name="4ps"
                                            class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                        <label for="4ps-yes"
                                            class="text-sm font-medium text-gray-900 ms-2">Yes</label>
                                    </div>
                                    <div wire:model='fourp' class="flex items-center">
                                        <input x-model="household" id="4ps-no" type="radio" value="2"
                                            name="4ps"
                                            class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                        <label for="4ps-no"
                                            class="text-sm font-medium text-gray-900 ms-2">No</label>
                                    </div>

                                </div>
                                <x-input-error :messages="$errors->get('fourp')" class="mt-2" />

                            </div>
                            <div class="flex flex-col w-full lg:w-1/2" x-show="household == 1">
                                <x-input-label for="fourpID" :value="__('If yes, Household ID No.*')" />
                                <x-text-input wire:model='fourpID' class="block w-full mt-1" type="text" />
                                <x-input-error :messages="$errors->get('fourpID')" class="mt-2" />

                            </div>


                        </div>

                    </div>





                    {{-- DISABILITY --}}
                    <div class="flex flex-row w-full gap-4 my-4">
                        <div class="flex flex-col w-full">

                            <div class="flex flex-row items-center w-full">

                                <x-input-label for="fname"> </i>Disability
                                </x-input-label>

                                <x-primary-button wire:click.prevent="openModal('disability')" class="ml-auto mr-3"
                                    type="button" x-data="">
                                    {{-- x-on:click.prevent="$dispatch('open-modal', 'disability-modal')" --}}
                                    Add Disability
                                </x-primary-button>

                            </div>

                            <div
                                class="flex-inline border border-gray-300 rounded-lg p-1 mt-2 @if (empty($displayDisabilities)) h-[40px] @endif ">


                                @foreach ($displayDisabilities as $dis)
                                    <span wire:key="{{ $dis['disability_id'] ?? md5($dis['disability_Type']) }}"
                                        class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-1.5 ps-3 pe-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $dis['disability_Type'] }}
                                        <button
                                            wire:click.prevent="removeDisability('{{ $dis['disability_id'] ?? $dis['disability_Type'] }}')"
                                            type="button"
                                            class="inline-flex items-center justify-center flex-shrink-0 rounded-full size-4 hover:bg-blue-200 focus:outline-none focus:bg-blue-200 focus:text-blue-500">
                                            <span class="sr-only">Remove badge</span>
                                            <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M18 6 6 18" />
                                                <path d="m6 6 12 12" />
                                            </svg>
                                        </button>
                                    </span>
                                @endforeach





                            </div>
                            <x-input-error :messages="$errors->get('disability')" class="mt-2" />

                        </div>
                    </div>
                    {{-- SKILLS --}}

                    <div class="flex flex-row w-full gap-4 my-4">
                        <div class="flex flex-col w-full">

                            <div class="flex flex-row items-center w-full">

                                <x-input-label for="fname"> </i>Skills
                                </x-input-label>

                                <x-primary-button wire:click.prevent="openModal('skills')" class="ml-auto mr-3"
                                    type="button" x-data="">
                                    {{-- x-on:click.prevent="$dispatch('open-modal', 'disability-modal')" --}}
                                    Add Skills
                                </x-primary-button>

                            </div>

                            <div
                                class="flex-inline border border-gray-300 rounded-lg p-1 mt-2 @if (empty($originalSkills)) h-[40px] @endif ">


                                @foreach ($displaySkills as $skill)
                                    <span wire:key="{{ $skill['skills_id'] ?? md5($skill['skill_Type']) }}"
                                        class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-1.5 ps-3 pe-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $skill['skill_Type'] }}
                                        <button
                                            wire:click.prevent="removeSkills('{{ $skill['skills_id'] ?? $skill['skill_Type'] }}')"
                                            type="button"
                                            class="inline-flex items-center justify-center flex-shrink-0 rounded-full size-4 hover:bg-blue-200 focus:outline-none focus:bg-blue-200 focus:text-blue-500">
                                            <span class="sr-only">Remove badge</span>
                                            <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M18 6 6 18" />
                                                <path d="m6 6 12 12" />
                                            </svg>
                                        </button>
                                    </span>
                                @endforeach






                            </div>
                            <x-input-error :messages="$errors->get('disability')" class="mt-2" />

                        </div>
                    </div>


                    <div class="flex flex-row">


                        <x-blue-button wire:target="pimg, saveProfile" wire:loading.attr="disabled"
                            wire:click.prevent="saveProfile" class="ml-auto mr-3" type="button"
                            x-data="" {{-- x-on:click.prevent="$dispatch('open-modal', 'jobTag-modal')"> x-on:click.prevent="saveDetails(general)" --}}>
                            Save
                            <div wire:loading.delay.long wire:target="pimg, saveProfile" role="status">
                                <svg aria-hidden="true" class="w-4 h-4 ml-4 text-gray-200 animate-spin fill-blue-600"
                                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                        fill="currentColor" />
                                    <path
                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                        fill="currentFill" />
                                </svg>
                                <span class="sr-only">Loading...</span>
                            </div>
                        </x-blue-button>
                    </div>
                </div>
                {{-- BASIC INFORMATION --}}

                {{-- LANGUAGE --}}
                <div class="flex flex-col" x-show="openTab === 2"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-cloak>


                    <div class="relative mt-4">

                        <div
                            class="flex flex-col gap-2 p-1 pb-4 space-y-4 lg:flex-row lg:justify-between lg:space-y-0">

                            <label for="table-search" class="sr-only">Search</label>


                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                {{-- SEARCH --}}
                                <input wire:model.live='searchLang' type="search"
                                    class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Search for language">
                            </div>

                            {{-- ADD BUTTON --}}
                            <div class="flex flex-wrap gap-2 mr-3">
                                <x-primary-button wire:click.prevent="openModal('language')" type="button"
                                    class="bg-blue-400 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900">
                                    Add Language</x-primary-button>
                            </div>

                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left rtl:text-right">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 border">
                                            Language
                                        </th>
                                        <th scope="col" class="hidden px-6 py-3 text-center border lg:table-cell">
                                            Read
                                        </th>
                                        <th scope="col" class="hidden px-6 py-3 text-center border lg:table-cell">
                                            Write
                                        </th>
                                        <th scope="col" class="hidden px-6 py-3 text-center border lg:table-cell">
                                            Speak
                                        </th>
                                        <th scope="col" class="hidden px-6 py-3 text-center border lg:table-cell">
                                            Understand
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center border">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($employeeLang->isEmpty())
                                        <tr>
                                            <td colspan="6">
                                                <div class="flex flex-col items-center justify-center mt-24 mb-24">
                                                    <div class="p-6 bg-gray-100 rounded-full">
                                                        <svg class="w-24 h-24 text-black" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-width="2"
                                                                d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                                        </svg>
                                                    </div>
                                                    <p class="mt-2 text-xl font-bold text-center text-black">No Records
                                                        Found!</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($employeeLang as $data)
                                            <tr wire:key='language-{{ $data->language_id }}'
                                                class="bg-white border-b hover:bg-gray-50">
                                                <th
                                                    class="px-6 py-4 font-medium text-gray-900 border whitespace-nowrap">
                                                    {{ $data->language_Type }}
                                                    <div class="text-gray-500 lg:hidden">
                                                        <!-- Additional mobile information -->
                                                        <p>Read: {{ $data->language_Read == '1' ? 'Yes' : 'No' }}</p>
                                                        <p>Write: {{ $data->language_Write == '1' ? 'Yes' : 'No' }}</p>
                                                        <p>Speak: {{ $data->language_Speak == '1' ? 'Yes' : 'No' }}</p>
                                                        <p>Understand:
                                                            {{ $data->language_Understand == '1' ? 'Yes' : 'No' }}</p>
                                                    </div>

                                                </th>
                                                <td scope="row" class="hidden px-6 py-1 border lg:table-cell">
                                                    <div class="flex items-center justify-center">
                                                        <input type="checkbox"
                                                            @if ($data->language_Read == '1') checked @endif
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                                                            disabled>
                                                        <label for="checkbox-read" class="sr-only">checkbox</label>
                                                    </div>
                                                </td>
                                                <td class="hidden px-6 py-1 border lg:table-cell">
                                                    <div class="flex items-center justify-center">
                                                        <input type="checkbox"
                                                            @if ($data->language_Write == '1') checked @endif
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                                                            disabled>
                                                        <label for="checkbox-write" class="sr-only">checkbox</label>
                                                    </div>
                                                </td>
                                                <td class="hidden px-6 py-1 border lg:table-cell">
                                                    <div class="flex items-center justify-center">
                                                        <input type="checkbox"
                                                            @if ($data->language_Speak == '1') checked @endif
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                                                            disabled>
                                                        <label for="checkbox-speak" class="sr-only">checkbox</label>
                                                    </div>
                                                </td>
                                                <td class="hidden px-6 py-1 border lg:table-cell">
                                                    <div class="flex items-center justify-center">
                                                        <input id="checkbox-understand" type="checkbox"
                                                            @if ($data->language_Understand == '1') checked @endif
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                                                            disabled>
                                                        <label for="checkbox-understand"
                                                            class="sr-only">checkbox</label>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-1 text-center border">
                                                    <div class="flex flex-row items-center justify-center gap-6">
                                                        <div x-data="{ tooltip: 'Edit Language' }">
                                                            <button
                                                                wire:click.prevent="editRecord({{ $data->language_id }}, 'language')"
                                                                x-tooltip="tooltip" type="button"
                                                                class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                                <svg class="w-5 h-5"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div x-data="{ tooltip: 'Remove Language' }">
                                                            <button x-tooltip="tooltip" type="button"
                                                                wire:click.prevent="deleteData(3, {{ $data->language_id }})"
                                                                class="inline-flex items-center p-1 text-sm font-medium text-center text-red-700 border border-red-700 rounded-lg hover:bg-red-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-red-300">
                                                                <svg class="w-5 h-5"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                            <div class="mt-4">
                                {{$employeeLang->links('vendor.livewire.tailwind', data: ['scrollTo' => false])}}
                            </div>

                        </div>
                    </div>


                </div>
                {{-- LANGUAGE --}}

                {{-- ELIGIBILITY --}}
                <div class="flex flex-col" x-show="openTab === 3"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-cloak>


                    <div class="relative mt-4">

                        <div
                            class="flex flex-col gap-2 p-1 pb-4 space-y-4 lg:flex-row lg:justify-between lg:space-y-0">
                            <label for="table-search" class="sr-only">Search</label>


                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                {{-- SEARCH --}}
                                <input wire:model.live='searchEli' type="text"
                                    class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Search for eligibility">
                            </div>

                            {{-- ADD BUTTON --}}
                            <div class="flex flex-wrap gap-2 mr-3">
                                <x-primary-button wire:click.prevent="openModal('eligibility')" type="button"
                                    class="bg-blue-400 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900"
                                    x-data="">
                                    {{-- x-on:click.prevent="$dispatch('open-modal', 'eligibility-modal')"> --}}
                                    Add Eligibility</x-primary-button>
                            </div>

                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 rtl:text-right">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            License
                                        </th>
                                        <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                            Validity
                                        </th>
                                        <th scope="col" class="w-1/3 px-6 py-3">

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($employeeEli->isEmpty())
                                        <tr>
                                            <td colspan="2">
                                                <div class="flex flex-col items-center justify-center mt-24 mb-24">
                                                    <div class="p-6 bg-gray-100 rounded-full">
                                                        <svg class="w-24 h-24 text-black" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-width="2"
                                                                d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                                        </svg>
                                                    </div>
                                                    <p class="mt-2 text-xl font-bold text-center text-black">
                                                        No Records Found!
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($employeeEli as $eli)
                                            <tr wire:key="{{ $eli->eligibility_id }}"
                                                class="bg-white border-b hover:bg-gray-50">
                                                <th scope="row"
                                                    class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    <div class="ps-3 text-wrap">
                                                        <div class="text-base font-semibold">
                                                            {{ $eli->eligibility_type->eligibility_Name }}
                                                        </div>
                                                        <div class="text-sm text-gray-600 lg:hidden">
                                                            Valid until: {{ $eli->eligibility_Date->format('F j, Y') }}
                                                        </div>
                                                    </div>
                                                </th>
                                                <td class="hidden px-6 py-4 lg:table-cell">
                                                    <div class="text-base font-semibold">
                                                        {{ $eli->eligibility_Date->format('F j, Y') }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex flex-row items-center justify-center gap-6">

                                                        <div x-data="{ tooltip: 'Edit Eligibility' }">
                                                            <button
                                                                wire:click.prevent="editRecord({{ $eli->eligibility_id }}, 'eligibility')"
                                                                x-tooltip="tooltip" type="button"
                                                                class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                                <svg class="w-5 h-5"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div x-data="{ tooltip: 'Delete Eligibility' }">
                                                            <button x-tooltip="tooltip" type="button"
                                                                wire:click.prevent="deleteData(1, {{ $eli->eligibility_id }})"
                                                                class="inline-flex items-center p-1 text-sm font-medium text-center text-red-700 border border-red-700 rounded-lg hover:bg-red-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-red-300">
                                                                <svg class="w-5 h-5"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                                </svg>

                                                            </button>
                                                        </div>


                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{$employeeEli->links('vendor.livewire.tailwind', data: ['scrollTo' => false])}}
                            </div>
                        </div>
                    </div>


                </div>
                {{-- ELIGIBILITY --}}


                {{-- LICENSE --}}
                <div class="flex flex-col" x-show="openTab === 4"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-cloak>


                    <div class="relative mt-4">

                        <div
                            class="flex flex-col gap-2 p-1 pb-4 space-y-4 lg:flex-row lg:justify-between lg:space-y-0">

                            <label for="table-search" class="sr-only">Search</label>


                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                {{-- SEARCH --}}
                                <input type="text" wire:model.live='searchLic'
                                    class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Search for license">
                            </div>

                            {{-- ADD BUTTON --}}
                            <div class="flex flex-wrap gap-2 mr-3">
                                <x-primary-button wire:click.prevent="openModal('license')" type="button"
                                    class="bg-blue-400 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900"
                                    x-data="">
                                    {{-- x-on:click.prevent="$dispatch('open-modal', 'jobposition-modal')"> --}}
                                    Add License</x-primary-button>
                            </div>

                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 rtl:text-right">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            License
                                        </th>
                                        <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                            Validity
                                        </th>
                                        <th scope="col" class="w-1/3 px-6 py-3">

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($employeeLic->isEmpty())
                                        <tr>
                                            <td colspan="2">
                                                <div class="flex flex-col items-center justify-center mt-24 mb-24">
                                                    <div class="p-6 bg-gray-100 rounded-full">
                                                        <svg class="w-24 h-24 text-black" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-width="2"
                                                                d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                                        </svg>
                                                    </div>
                                                    <p class="mt-2 text-xl font-bold text-center text-black">
                                                        No Records Found!
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($employeeLic as $empLicense)
                                            <tr wire:key="{{ $empLicense->license_id }}"
                                                class="bg-white border-b hover:bg-gray-50">
                                                <th scope="row"
                                                    class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    <div class="ps-3 text-wrap">
                                                        <div class="text-base font-semibold">
                                                            {{ $empLicense->license_type->license_Name }}
                                                        </div>
                                                        <div class="text-sm text-gray-600 lg:hidden">
                                                            Valid until:
                                                            {{ $empLicense->license_Validity->format('F j, Y') }}
                                                        </div>
                                                    </div>
                                                </th>
                                                <td class="hidden px-6 py-4 lg:table-cell">
                                                    <div class="text-base font-semibold">
                                                        {{ $empLicense->license_Validity->format('F j, Y') }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex flex-row items-center justify-center gap-6">

                                                        <div x-data="{ tooltip: 'Edit License' }">
                                                            <button
                                                                wire:click.prevent="editRecord({{ $empLicense->license_id }}, 'license')"
                                                                x-tooltip="tooltip" type="button"
                                                                class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                                <svg class="w-5 h-5"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div x-data="{ tooltip: 'Delete License' }">
                                                            <button x-tooltip="tooltip" type="button"
                                                                wire:click.prevent="deleteData(2, {{ $empLicense->license_id }})"
                                                                class="inline-flex items-center p-1 text-sm font-medium text-center text-red-700 border border-red-700 rounded-lg hover:bg-red-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-red-300">
                                                                <svg class="w-5 h-5"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                                </svg>

                                                            </button>
                                                        </div>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                            <div class="mt-4">
                                {{$employeeLic->links('vendor.livewire.tailwind', data: ['scrollTo' => false])}}
                            </div>
                        </div>
                    </div>


                </div>
                {{-- LICENSE --}}

                {{-- JOB AND INDUSTRY PREFERENCE --}}
                <div class="flex flex-col" x-show="openTab === 5"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-cloak>
                    <div class="flex flex-row w-full gap-4 my-4 mt-4">
                        <div class="flex flex-col w-full">

                            <div class="flex flex-col w-full gap-2 lg:flex-row lg:justify-between">

                                <span class="text-xl font-bold">Job Preference</span>

                                <div class="flex flex-wrap gap-2 mr-3">


                                    <x-primary-button type="button" x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'job-position-modal')">
                                        Add Job Preference
                                    </x-primary-button>
                                </div>

                            </div>

                            <div
                                class="flex-inline border border-gray-300 rounded-lg p-1 mt-2 @if (empty($employeeDetails->job_preference)) h-[40px] @endif ">

                                @foreach ($employeeDetails->job_preference as $jobPref)
                                    <span
                                        class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-1.5 ps-3 pe-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ">
                                        {{ $jobPref->job_positions->position_Title }}
                                        <button wire:click.prevent="removePosition({{ $jobPref->job_preference_id }})"
                                            type="button"
                                            class="inline-flex items-center justify-center flex-shrink-0 rounded-full size-4 hover:bg-blue-200 focus:outline-none focus:bg-blue-200 focus:text-blue-500 ">
                                            <span class="sr-only">Remove badge</span>
                                            <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M18 6 6 18" />
                                                <path d="m6 6 12 12" />
                                            </svg>
                                        </button>
                                    </span>
                                @endforeach

                            </div>
                            <x-input-error :messages="$errors->get('jobpreference')" class="mt-2" />

                        </div>
                    </div>
                    <div class="flex flex-row w-full gap-4 my-4 mt-4">
                        <div class="flex flex-col w-full">

                            <div class="flex flex-col w-full lg:flex-row lg:justify-between">


                                <span class="text-xl font-bold">Industry Preference</span>

                                <div class="flex flex-wrap gap-2 mr-3">
                                    <x-primary-button type="button" x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'industry-modal')">
                                        Add Industry Preference
                                    </x-primary-button>
                                </div>

                            </div>
                            <div
                                class="flex-inline border border-gray-300 rounded-lg p-1 mt-2 @if (empty($employeeDetails->industry_preference)) h-[40px] @endif ">




                                @foreach ($employeeDetails->industry_preference as $industryPref)
                                    <span
                                        class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-1.5 ps-3 pe-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ">
                                        {{ $industryPref->job_industry->industry_Title }}
                                        <button
                                            wire:click.prevent="removeIndustry({{ $industryPref->industry_pref_id }})"
                                            type="button"
                                            class="inline-flex items-center justify-center flex-shrink-0 rounded-full size-4 hover:bg-blue-200 focus:outline-none focus:bg-blue-200 focus:text-blue-500 ">
                                            <span class="sr-only">Remove badge</span>
                                            <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M18 6 6 18" />
                                                <path d="m6 6 12 12" />
                                            </svg>
                                        </button>
                                    </span>
                                @endforeach

                            </div>
                            <x-input-error :messages="$errors->get('industrypreference')" class="mt-2" />

                        </div>
                    </div>

                </div>
                {{-- JOB AND INDUSTRY PREFERENCE --}}

                <div class="flex flex-col" x-show="openTab === 6"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-cloak>
                    <div class="flex flex-col w-full gap-4 my-4 mt-4">
                        <div class="flex flex-col w-full gap-2 md:flex-row md:gap-4">

                            @if ($employeeDetails->resume)
                                <div class="flex flex-col w-full mt-4">
                                    <button wire:click.prevent="viewFile({{ $employeeDetails->employee_id }}, 1 )"
                                        type="button"
                                        class="text-blue-900 bg-blue-400 hover:bg-blue-100 border border-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 mb-2">
                                        <i class="fa-solid fa-file-contract me-2"></i>
                                        View Resume
                                        <svg class="w-6 h-6 ml-auto mr-0" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-1-5-4 5-4-5m9 8h.01" />
                                        </svg>
                                    </button>
                                </div>
                            @else
                                <div class="flex flex-col w-full mt-4">
                                    <div
                                        class="text-red-900 bg-red-400 border border-red-500 focus:ring-4 focus:outline-none focus:ring-red-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 mb-2">
                                        <i class="fa-solid fa-file-contract me-2"></i>
                                        You have no uploaded resume.
                                        <svg class="w-6 h-6 ml-auto mr-0" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </div>
                                </div>
                            @endif


                            <div class="flex flex-row items-center justify-center w-full gap-2">
                                <div class="flex flex-col w-full mt-4">
                                    <input wire:model='newResume'
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                        aria-describedby="file_input_help" id="file_input" type="file">
                                    <p class="mt-1 text-sm text-gray-500 " id="file_input_help">PDF ONLY (MAX 5MB).
                                    </p>
                                    <x-input-error :messages="$errors->get('newResume')" class="mt-2" />
                                </div>
                                <div class="flex">
                                    <div wire:loading.delay.long wire:target="newResume" role="status">
                                        <svg aria-hidden="true"
                                            class="w-6 h-6 ml-4 text-gray-200 animate-spin fill-blue-600"
                                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                fill="currentColor" />
                                            <path
                                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                fill="currentFill" />
                                        </svg>
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>

                        </div>



                        <x-blue-button wire:target="newResume, saveResume" wire:loading.attr="disabled"
                            wire:click.prevent="saveResume" class="ml-auto mr-3" type="button"
                            x-data="" {{-- x-on:click.prevent="$dispatch('open-modal', 'jobTag-modal')"> x-on:click.prevent="saveDetails(general)" --}}>
                            Save
                            <div wire:loading.delay.long wire:target="pimg, saveProfile" role="status">
                                <svg aria-hidden="true" class="w-4 h-4 ml-4 text-gray-200 animate-spin fill-blue-600"
                                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                        fill="currentColor" />
                                    <path
                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                        fill="currentFill" />
                                </svg>
                                <span class="sr-only">Loading...</span>
                            </div>
                        </x-blue-button>
                    </div>

                </div>


                <div class="flex flex-col" x-show="openTab === 7"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-cloak>
                    <div class="flex flex-col w-full gap-4 my-4 mt-4">
                        <div class="p-4 bg-gray-100 border border-gray-300 rounded-md shadow-sm">
                            <h2 class="text-lg font-semibold text-gray-800">Profile Privacy Settings</h2>
                            <p class="mt-2 text-sm text-gray-600">
                                Here, you can manage who can view your profile. You have the option to keep it private,
                                allow only employers to see it, or make it public for anyone to view. Regardless of your
                                choice, PESO administrators will still have access to your profile for administrative
                                purposes.
                            </p>
                        </div>

                        <!-- Privacy Options -->
                        <div class="flex flex-col justify-center w-full gap-4">
                            <div class="flex flex-col">
                                <div class="flex flex-row justify-center w-full gap-4 mt-2">

                                    <!-- Private Option -->
                                    <label for="bordered-radio-1"
                                        class="flex flex-row items-center h-10 px-4 transition-all duration-200 bg-white border border-gray-400 rounded-md shadow-sm cursor-pointer hover:border-blue-500 focus:border-blue-500">
                                        <input wire:model='privacy' id="bordered-radio-1" type="radio"
                                            value="1" name="bordered-radio"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                        <span class="ml-2 text-sm font-medium text-gray-800">Private</span>
                                    </label>

                                    <!-- Employers Option -->
                                    <label for="bordered-radio-2"
                                        class="flex flex-row items-center h-10 px-4 transition-all duration-200 bg-white border border-gray-400 rounded-md shadow-sm cursor-pointer hover:border-blue-500 focus:border-blue-500">
                                        <input wire:model='privacy' id="bordered-radio-2" type="radio"
                                            value="2" name="bordered-radio"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                        <span class="ml-2 text-sm font-medium text-gray-800">Employers</span>
                                    </label>

                                    <!-- Public Option -->
                                    <label for="bordered-radio-3"
                                        class="flex flex-row items-center h-10 px-4 transition-all duration-200 bg-white border border-gray-400 rounded-md shadow-sm cursor-pointer hover:border-blue-500 focus:border-blue-500">
                                        <input wire:model='privacy' id="bordered-radio-3" type="radio"
                                            value="3" name="bordered-radio"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                        <span class="ml-2 text-sm font-medium text-gray-800">Public</span>
                                    </label>
                                </div>

                                <!-- Error Message -->
                                <x-input-error :messages="$errors->get('privacy')" class="mt-2" />
                            </div>
                        </div>



                        <x-blue-button wire:target="savePrivacy" wire:loading.attr="disabled"
                            wire:click.prevent="savePrivacy" class="ml-auto mr-3" type="button"
                            x-data="" {{-- x-on:click.prevent="$dispatch('open-modal', 'jobTag-modal')"> x-on:click.prevent="saveDetails(general)" --}}>
                            Save
                            <div wire:loading.delay.long wire:target="savePrivacy" role="status">
                                <svg aria-hidden="true" class="w-4 h-4 ml-4 text-gray-200 animate-spin fill-blue-600"
                                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                        fill="currentColor" />
                                    <path
                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                        fill="currentFill" />
                                </svg>
                                <span class="sr-only">Loading...</span>
                            </div>
                        </x-blue-button>
                    </div>

                </div>
            </div>








        </div>
    </div>


    <x-modal name="license-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('License Record') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">
                <div class="flex flex-col w-full mt-2">
                    <x-input-label for="licenseType" :value="__('License')" />

                    <x-dropdown align="left" width="full">
                        <x-slot name="trigger">
                            <button
                                class="mt-1 inline-flex h-full items-center text-gray-800 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-md px-1.5 py-2 w-full">
                                <div class="w-full ml-2 text-left">
                                    {{ $licName }}
                                </div>
                                <div class="ms-1">
                                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <!-- Search input -->
                            <div class="p-2">
                                <input wire:model.live='searchLi' type="text" placeholder="Search..."
                                    class="block w-full px-3 py-1.5 mb-2 border border-gray-300 rounded-md focus:outline-none"
                                    @click.stop>
                            </div>

                            <!-- Dropdown content with scrollbar -->
                            <div class="max-h-[120px] bg-white overflow-y-auto">
                                <!-- Dropdown links -->
                                {{-- LOOP HERE --}}
                                @foreach ($liTypes as $licenseTypes)
                                    <x-dropdown-link
                                        wire:click.prevent="setVar({{ $licenseTypes->license_type_id }}, 'license')"
                                        class="block px-4 py-2 uppercase cursor-pointer hover:bg-gray-100">
                                        {{ $licenseTypes->license_Name }} </x-dropdown-link>
                                @endforeach
                                {{-- LOOP END --}}
                            </div>
                        </x-slot>

                    </x-dropdown>

                    <x-input-error :messages="$errors->get('licTypeID')" class="mt-2" />

                </div>
                <div class="flex flex-col w-full mt-2">
                    <x-input-label for="licenseDate" :value="__('Date Validity')" />
                    <x-text-input wire:model='licValidity' class="block w-full mt-1" type="date" />
                    <x-input-error :messages="$errors->get('licValidity')" class="mt-2" />

                </div>

            </div>
            <div class="flex justify-end mt-6">
                <x-secondary-button wire:click.prevent="closeModal('license')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button wire:click.prevent="saveLicense" class="ms-3" type="button">
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </div>
    </x-modal>


    <x-modal name="eligibility-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Eligibility Record') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">
                <div class="flex flex-col w-full mt-2">
                    <x-input-label for="eligibilityType" :value="__('Eligibility')" />

                    <x-dropdown align="left" width="full">
                        <x-slot name="trigger">
                            <button
                                class="mt-1 inline-flex h-full items-center text-gray-800 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-md px-1.5 py-2 w-full">
                                <div class="w-full ml-2 text-left">
                                    {{ $eli_Name }}
                                </div>
                                <div class="ms-1">
                                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <!-- Search input -->
                            <div class="p-2">
                                <input wire:model.live='searchEl' type="text" placeholder="Search..."
                                    class="block w-full px-3 py-1.5 mb-2 border border-gray-300 rounded-md focus:outline-none"
                                    @click.stop>
                            </div>

                            <!-- Dropdown content with scrollbar -->
                            <div class="max-h-[120px] bg-white overflow-y-auto">
                                <!-- Dropdown links -->
                                {{-- LOOP HERE --}}
                                @foreach ($elTypes as $eliTypes)
                                    <x-dropdown-link
                                        wire:click.prevent="setVar({{ $eliTypes->eligibility_type_id }}, 'eligibility')"
                                        class="block px-4 py-2 uppercase cursor-pointer hover:bg-gray-100">
                                        {{ $eliTypes->eligibility_Name }}</x-dropdown-link>
                                    {{-- LOOP END --}}
                                @endforeach

                            </div>

                        </x-slot>

                    </x-dropdown>
                    <x-input-error :messages="$errors->get('eliTypeID')" class="mt-2" />


                </div>
                <div class="flex flex-col w-full mt-2">
                    <x-input-label for="licenseDate" :value="__('Date Validity')" />
                    <x-text-input wire:model='eli_Date' class="block w-full mt-1" type="date" />
                    <x-input-error :messages="$errors->get('eli_Date')" class="mt-2" />
                </div>

            </div>
            <div class="flex justify-end mt-6">
                <x-secondary-button wire:click.prevent="closeModal('eligibility')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button wire:click.prevent="saveEligibility" class="ms-3" type="button">
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </div>
    </x-modal>





    <x-modal name="disability-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Add Disaibility Record') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2" x-data="{ otherDisability: false }">

                <div class="flex flex-col w-full mt-2">
                    <x-input-label for="langSelect" :value="__('Add Disability')" />
                    <select wire:model='selectDisability' class="block w-full mt-1 rounded"
                        x-on:change="otherDisability = $event.target.value === 'other'">
                        <option value="" disabled selected>Select Disability</option>
                        <option value="VISUAL">Visual</option>
                        <option value="HEARING">Hearing</option>
                        <option value="SPEECH">Speech</option>
                        <option value="PHYSICAL">Physical</option>
                        <option value="MENTAL">Mental</option>
                        <option value="other">Other</option>
                    </select>
                    <x-input-error :messages="$errors->get('selectDisability')" class="mt-2" />
                </div>
                <div x-show="otherDisability" x-cloak class="mt-2">
                    <x-input-label for="addDisability" :value="__('Others')" />
                    <x-text-input wire:model.prevent='otherDisability' class="block w-full mt-1" type="text" />
                    <x-input-error :messages="$errors->get('otherDisability')" class="mt-2" />
                </div>
            </div>
            <div class="flex justify-end mt-8">
                <x-secondary-button wire:click.prevent="closeModal('disability')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button wire:click.prevent="saveDisability" class="ms-3" type="button">
                    {{ __('Add Disability Record') }}
                </x-primary-button>
            </div>
        </div>
    </x-modal>


    <x-modal name="skills-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Add Skill Record') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">
                <div class="mt-2">
                    <x-input-label for="addSkills" :value="__('Others')" />
                    <x-text-input wire:model='skills' class="block w-full mt-1" type="text" />
                    <x-input-error :messages="$errors->get('skills')" class="mt-2" />
                </div>
            </div>
            <div class="flex justify-end mt-8">
                <x-secondary-button wire:click.prevent="closeModal('skills')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button wire:click.prevent="saveSkills" class="ms-3" type="button">
                    {{ __('Add Skill Record') }}
                </x-primary-button>
            </div>
        </div>
    </x-modal>


    <x-modal name="language-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Language/Dialect Record') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2" x-data="{ selectedLanguage: @entangle('selectedLanguage') }">

                <div class="flex flex-col w-full mt-2">
                    <x-input-label for="langSelect" :value="__('Add Language')" />
                    <select wire:model='selectedLanguage' name="langSelect" class="block w-full mt-1 rounded">
                        <option value="" disabled selected>Select Language</option>
                        <option value="English">English</option>
                        <option value="Filipino">Filipino</option>
                        <option value="Mandarin">Mandarin</option>
                        <option value="other">Other</option>
                    </select>
                    <x-input-error :messages="$errors->get('selectedLanguage')" class="mt-2" />
                </div>
                <div x-show="selectedLanguage === 'other'" x-cloak class="mt-2">
                    <x-input-label for="langOther" :value="__('Other Language')" />
                    <x-text-input wire:model='otherLanguage' class="block w-full mt-1" type="text"
                        name="langOther" />
                    <x-input-error :messages="$errors->get('otherLanguage')" class="mt-2" />
                </div>

                <div class="flex flex-col w-full mt-4">
                    <div class="flex flex-col justify-center w-full gap-2 lg:flex-row lg:gap-5">
                        <div>
                            <input wire:model='read' type="checkbox" id="read-option" class="hidden peer"
                                required="">
                            <label for="read-option"
                                class="inline-flex items-center justify-between w-full p-3 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-50">
                                <div class="flex flex-row items-center justify-center">
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                    </svg>

                                    <div class="w-full ml-2 text-lg font-semibold">Read</div>
                                </div>
                        </div>
                        <div>
                            <input wire:model='write' type="checkbox" id="write-option" class="hidden peer"
                                required="">
                            <label for="write-option"
                                class="inline-flex items-center justify-between w-full p-3 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-50">
                                <div class="flex flex-row items-center justify-center">
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                    </svg>

                                    <div class="w-full ml-2 text-lg font-semibold">Write</div>
                                </div>
                        </div>
                        <div>
                            <input wire:model='speak' type="checkbox" id="speak-option" class="hidden peer"
                                required="">
                            <label for="speak-option"
                                class="inline-flex items-center justify-between w-full p-3 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-50">
                                <div class="flex flex-row items-center justify-center">
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.114 5.636a9 9 0 0 1 0 12.728M16.463 8.288a5.25 5.25 0 0 1 0 7.424M6.75 8.25l4.72-4.72a.75.75 0 0 1 1.28.53v15.88a.75.75 0 0 1-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.009 9.009 0 0 1 2.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75Z" />
                                    </svg>
                                    <div class="w-full ml-2 text-lg font-semibold">Speak</div>
                                </div>
                        </div>
                        <div>
                            <input wire:model='understand' type="checkbox" id="understand-option"
                                class="hidden peer" required="">
                            <label for="understand-option"
                                class="inline-flex items-center justify-between w-full p-3 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-50">
                                <div class="flex flex-row items-center justify-center">
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m10.5 21 5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 0 1 6-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 0 1-3.827-5.802" />
                                    </svg>

                                    <div class="w-full ml-2 text-lg font-semibold">Understand</div>
                                </div>
                        </div>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('language_option')" class="mt-2" />
                </div>

            </div>

            <div class="flex justify-end mt-8">
                <x-secondary-button wire:click.prevent="closeModal('language')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button wire:click.prevent='saveLanguage' class="ms-3" type="button">
                    {{ __('Save Language Record') }}
                </x-primary-button>
            </div>
        </div>
    </x-modal>


    <livewire:modals.job-position-modal />
    <livewire:modals.industry-modal />

    <x-modal name="delete-eligibility-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Action Confirmation') }}
            </h2>
            <hr>
            <div class="flex flex-col items-center justify-center my-12">

                <h1 class="text-2xl font-bold">Are you sure you want to delete this eligibility record?</h1>


            </div>
            <div class="flex justify-end mt-6">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'delete-eligibility-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button wire:loading.attr="disabled" wire:click.prevent="deleteRecord(1)" class="ms-3"
                    type="button">
                    {{ __('Confirm') }}
                    <div wire:loading.delay.long wire:target="deleteRecord(1)" role="status">
                        <svg aria-hidden="true" class="w-4 h-4 ml-4 text-gray-200 animate-spin fill-blue-600"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill" />
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                </x-danger-button>
            </div>
        </div>
    </x-modal>
    <x-modal name="delete-license-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Action Confirmation') }}
            </h2>
            <hr>
            <div class="flex flex-col items-center justify-center my-12">

                <h1 class="text-2xl font-bold">Are you sure you want to delete this license record?</h1>


            </div>
            <div class="flex justify-end mt-6">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'delete-license-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button wire:loading.attr="disabled" wire:click.prevent="deleteRecord(2)" class="ms-3"
                    type="button">
                    {{ __('Confirm') }}
                    <div wire:loading.delay.long wire:target="deleteRecord(2)" role="status">
                        <svg aria-hidden="true" class="w-4 h-4 ml-4 text-gray-200 animate-spin fill-blue-600"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill" />
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                </x-danger-button>
            </div>
        </div>
    </x-modal>

    <x-modal name="delete-language-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Action Confirmation') }}
            </h2>
            <hr>
            <div class="flex flex-col items-center justify-center my-12">

                <h1 class="text-2xl font-bold">Are you sure you want to delete this language record?</h1>


            </div>
            <div class="flex justify-end mt-6">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'delete-language-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button wire:loading.attr="disabled" wire:click.prevent="deleteRecord(3)" class="ms-3"
                    type="button">
                    {{ __('Confirm') }}
                    <div wire:loading.delay.long wire:target="deleteRecord(3)" role="status">
                        <svg aria-hidden="true" class="w-4 h-4 ml-4 text-gray-200 animate-spin fill-blue-600"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill" />
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                </x-danger-button>
            </div>
        </div>
    </x-modal>

</div>
@push('scripts')

    @script
        <script>
            Livewire.on('viewFile', event => {
                // Check if the event is an array and has at least one element
                if (Array.isArray(event) && event.length > 0) {
                    // Access the first element and then its properties
                    const data = event[0]; // Assuming the data object is the first element

                    // Extract URL and handle dynamic keys
                    const url = data.url;

                    // Ensure URL is present
                    if (url) {
                        // Create and configure the form element
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = url;
                        form.target = '_blank';

                        // Add CSRF token as a hidden input
                        const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = csrfToken;
                        form.appendChild(csrfInput);

                        // Add all data inputs dynamically
                        Object.entries(data).forEach(([key, value]) => {
                            if (key !== 'url') {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = key;
                                input.value = value;
                                form.appendChild(input);
                            }
                        });

                        // Append form to the body and submit
                        document.body.appendChild(form);
                        form.submit();

                        // Clean up by removing the form element
                        document.body.removeChild(form);
                    } else {
                        console.error('URL not found in event data');
                    }
                } else {
                    console.error('Event is not in the expected format');
                }
            });
        </script>
    @endscript
@endpush
