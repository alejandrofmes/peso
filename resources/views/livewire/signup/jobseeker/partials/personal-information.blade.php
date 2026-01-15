<div class="flex flex-col w-full h-full">
    <h1 class="text-2xl font-bold">Personal Information</h1>
    <span class="text-sm text-gray-600">Fields with * are required.</span>
    <div class="flex flex-col lg:flex-row gap-4 w-full mt-5">
        <div class="flex flex-col w-full">
            <x-input-label for="presentAddress" :value="__('Present Address*')" />
            <x-text-input wire:model='address' class="block mt-1 w-full" type="text" />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>
        <div class="flex flex-col w-full">
            <x-input-label for="city" :value="__('Barangay*')" />
            <x-text-input wire:model='bar' class="block mt-1 w-full" type="text" readonly x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'barangay-modal')"
                x-on:focus="$dispatch('open-modal', 'barangay-modal')" />
            <x-input-error :messages="$errors->get('barangayID')" class="mt-2" />
        </div>
    </div>
    <div class="flex flex-col lg:flex-row gap-4 mt-4">
        <div class="flex flex-col w-full">
            <x-input-label for="city" :value="__('Municipality*')" />
            <x-text-input wire:model='mun' class="block mt-1 w-full" type="text" readonly />
        </div>
        <div class="flex flex-col w-full">
            <x-input-label for="province" :value="__('Province*')" />
            <x-text-input wire:model='prov' class="block mt-1 w-full" type="text" readonly />
        </div>
    </div>
    <div class="flex flex-col lg:flex-row gap-4 mt-4">
        <div class="flex flex-col w-full">
            <x-input-label for="civilstatus" :value="__('Civil Status*')" />
            <select wire:model='civilstatus' class="block mt-1 w-full rounded">
                <option value="" disabled selected>Select Civil Status</option>
                <option value="1">Single</option>
                <option value="2">Married</option>
                <option value="3">Widowed</option>

            </select>
            <x-input-error :messages="$errors->get('civilstatus')" class="mt-2" />
        </div>
        <div class="flex flex-col w-full">
            <x-input-label for="religion" :value="__('Religion')" />
            <select wire:model='religion' class="block mt-1 w-full rounded">
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

    <div class="flex flex-col lg:flex-row gap-4 mt-4">
        <div class="flex flex-col w-full">
            <x-input-label for="phone" :value="__('Cellphone No.*')" />
            <x-text-input wire:model='phone' class="block mt-1 w-full" type="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>
        <div class="flex flex-col w-full">
            <x-input-label for="tin" :value="__('TIN')" />
            <x-text-input wire:model='tin' class="block mt-1 w-full" type="text" />
            <x-input-error :messages="$errors->get('tin')" class="mt-2" />
        </div>
        <div class="flex flex-col w-full">
            <x-input-label for="height" :value="__('Height')" />
            <x-text-input wire:model='height' class="block mt-1 w-full" type="text" />
            <x-input-label for="height" :value="__('*Must be in Centimeters')" />
            <x-input-error :messages="$errors->get('height')" class="mt-2" />
        </div>
    </div>


    <div class="flex flex-col lg:flex-row mt-4 gap-4" x-data="{ otherDisability: false }">
        <div class="flex flex-col w-full">
            <x-input-label for="disability" :value="__('Disability')" />
            <div class="flex flex-col mt-2 lg:flex-row gap-1 lg:gap-4">
                <div
                    class="mb-[0.125rem] block min-h-[1.5rem] lg:min-h-auto lg:mb-[0.5rem] md:min-h-auto md:mb-[0.125rem] pl-[1.5rem]">
                    <input wire:model='disabilityBox'
                        class="relative float-left -ml-[1.5rem] mr-[6px] mt-[0.15rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-primary checked:bg-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:-mt-px checked:after:ml-[0.25rem] checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-l-0 checked:after:border-t-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:-mt-px checked:focus:after:ml-[0.25rem] checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-l-0 checked:focus:after:border-t-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                        type="checkbox" value="Visual" id="checkboxDefault1" name="disabilityBox[0]" />
                    <label class="inline-block pl-[0.15rem] hover:cursor-pointer" for="checkboxDefault1">
                        Visual
                    </label>
                </div>

                <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                    <input wire:model='disabilityBox'
                        class="relative float-left -ml-[1.5rem] mr-[6px] mt-[0.15rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-primary checked:bg-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:-mt-px checked:after:ml-[0.25rem] checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-l-0 checked:after:border-t-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:-mt-px checked:focus:after:ml-[0.25rem] checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-l-0 checked:focus:after:border-t-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                        type="checkbox" value="Hearing" id="checkboxDefault2" name="disabilityBox[1]" />
                    <label class="inline-block pl-[0.15rem] hover:cursor-pointer" for="checkboxDefault2">
                        Hearing
                    </label>
                </div>

                <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                    <input wire:model='disabilityBox'
                        class="relative float-left -ml-[1.5rem] mr-[6px] mt-[0.15rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-primary checked:bg-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:-mt-px checked:after:ml-[0.25rem] checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-l-0 checked:after:border-t-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:-mt-px checked:focus:after:ml-[0.25rem] checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-l-0 checked:focus:after:border-t-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                        type="checkbox" value="Speech" id="checkboxDefault3" name="disabilityBox[2]" />
                    <label class="inline-block pl-[0.15rem] hover:cursor-pointer" for="checkboxDefault3">
                        Speech
                    </label>
                </div>

                <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                    <input wire:model='disabilityBox'
                        class="relative float-left -ml-[1.5rem] mr-[6px] mt-[0.15rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-primary checked:bg-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:-mt-px checked:after:ml-[0.25rem] checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-l-0 checked:after:border-t-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:-mt-px checked:focus:after:ml-[0.25rem] checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-l-0 checked:focus:after:border-t-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                        type="checkbox" value="Physical" id="checkboxDefault4" name="disabilityBox[3]" />
                    <label class="inline-block pl-[0.15rem] hover:cursor-pointer" for="checkboxDefault4">
                        Physical
                    </label>
                </div>

                <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                    <input wire:model='disabilityBox'
                        class="relative float-left -ml-[1.5rem] mr-[6px] mt-[0.15rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-primary checked:bg-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:-mt-px checked:after:ml-[0.25rem] checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-l-0 checked:after:border-t-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:-mt-px checked:focus:after:ml-[0.25rem] checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-l-0 checked:focus:after:border-t-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                        type="checkbox" value="Mental" id="checkboxDefault5" name="disabilityBox[4]" />
                    <label class="inline-block pl-[0.15rem] hover:cursor-pointer" for="checkboxDefault5">
                        Mental
                    </label>
                </div>

                <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                    <input x-model="otherDisability"
                        class="relative float-left -ml-[1.5rem] mr-[6px] mt-[0.15rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-primary checked:bg-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:-mt-px checked:after:ml-[0.25rem] checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-l-0 checked:after:border-t-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:-mt-px checked:focus:after:ml-[0.25rem] checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-l-0 checked:focus:after:border-t-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                        type="checkbox" value="Others" id="checkboxDefault6" name="disabilityBox[]" />
                    <label class="inline-block pl-[0.15rem] hover:cursor-pointer" for="checkboxDefault6">
                        Others
                    </label>
                </div>

            </div>

        </div>
        <div x-show="otherDisability" x-cloak class="flex flex-col w-full">
            <x-input-label for="otherDisability" :value="__('Others')" />
            <x-text-input wire:model='otherDisability' class="block mt-1 w-full" type="text" />
            <x-input-error :messages="$errors->get('')" class="mt-2" />
        </div>
    </div>


    <div class="flex flex-col lg:flex-row gap-4 mt-4">
        <div class="flex flex-col w-1/3">
            <x-input-label for="OFW" :value="__('Are you an OFW?*')" />
            <div class="flex flex-row gap-4 mt-2">
                <div class="flex items-center">
                    <input wire:model='ofw' id="ofw-yes" type="radio" value="1" name="ofwStatus" checked
                        class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                    <label for="ofw-yes" class="ms-2 text-sm font-medium text-gray-900">Yes</label>
                </div>
                <div class="flex items-center">
                    <input wire:model='ofw' id="ofw-no" type="radio" value="2" name="ofwStatus" checked
                        class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                    <label for="ofw-no" class="ms-2 text-sm font-medium text-gray-900">No</label>
                </div>

            </div>
            <x-input-error :messages="$errors->get('ofw')" class="mt-2" />

        </div>
        <div class="flex flex-wrap gap-6 w-1/3" x-data="{ household: null }">

            <div class="flex flex-col">
                <x-input-label for="4ps" :value="__('Are you a 4Ps beneficiary*')" />
                <div class="flex flex-row w-full gap-4 mt-2">
                    <div class="flex items-center">
                        <input wire:model='fourP' x-model="household" id="4ps-yes" type="radio" value="1"
                            name="4ps"
                            class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                        <label for="4ps-yes" class="ms-2 text-sm font-medium text-gray-900">Yes</label>
                    </div>
                    <div wire:model='fourP' class="flex items-center">
                        <input x-model="household" id="4ps-no" type="radio" value="2" name="4ps"
                            class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                        <label for="4ps-no" class="ms-2 text-sm font-medium text-gray-900">No</label>
                    </div>

                </div>
                <x-input-error :messages="$errors->get('fourP')" class="mt-2" />

            </div>
            <div class="flex flex-col w-full lg:w-1/2" x-show="household == 1">
                <x-input-label for="fourPID" :value="__('If yes, Household ID No.*')" />
                <x-text-input wire:model='fourPID' class="block mt-1 w-full" type="text" />
                <x-input-error :messages="$errors->get('fourPID')" class="mt-2" />

            </div>


        </div>

    </div>

    <div class="flex flex-row justify-between space-x-4 mt-4">
        <x-secondary-button wire:loading.attr='disabled' wire:click.prevent='prev' type="button">
            Previous
            <div wire:loading.delay.long wire:target="prev" role="status">
                <svg aria-hidden="true" class="w-6 h-6 text-gray-200 animate-spin fill-blue-600 ml-4"
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
        </x-secondary-button>



        <x-blue-button wire:loading.attr='disabled' wire:click.prevent='next' type="button">
            Next
            <div wire:loading.delay.long wire:target="next" role="status">
                <svg aria-hidden="true" class="w-6 h-6 text-gray-200 animate-spin fill-blue-600 ml-4"
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


    <livewire:modals.barangay-signup-modal />



</div>
