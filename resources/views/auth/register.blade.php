<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div> --}}

        <div class="mt-4">
            <x-input-label for="role" :value="__('Select Role')" />
            <div class="flex items-center">
                <label for="jobseeker" class="mr-2">
                    <input id="jobseeker" type="radio" name="role" value="2" required autocomplete="off"
                        {{ old('role') == '2' ? 'checked' : '' }}>
                    <span class="ml-1">{{ __('Job Seeker') }}</span>
                </label>
                <label for="employer" class="ml-4 mr-2">
                    <input id="employer" type="radio" name="role" value="3" required autocomplete="off"
                        {{ old('role') == '3' ? 'checked' : '' }}>
                    <span class="ml-1">{{ __('Employer') }}</span>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="off" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4 flex flex-col items-center">
            <div class="flex" id="recaptcha-container">
                {!! htmlFormSnippet() !!}
            </div>

            <div class="flex">
                @if ($errors->has('g-recaptcha-response'))
                    <x-input-error :messages="$errors->first('g-recaptcha-response')" class="mt-2" />
                @endif

            </div>
        </div>

        <div class="flex justify-center">
            <div class="text-align">

                <div class="block  mt-4">
                    <label for="terms" class="inline-flex items-center">
                        <input id="terms" type="checkbox" value='1'
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            name="terms">
                        <span class="ms-2 text-sm text-gray-600">I agree with the <span
                                class="cursor-pointer font-bold text-blue-700" x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'terms-modal')">Terms and
                                Conditions</span>.</span>
                    </label>
                    <x-input-error :messages="$errors->get('terms')" class="mt-2" />

                </div>
                <div class="block mt-2">
                    <label for="privacy" class="inline-flex items-center">
                        <input id="privacy" type="checkbox" value='1'
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            name="privacy">
                        <span class="ms-2 text-sm text-gray-600">I agree with the <span
                                class="cursor-pointer font-bold text-blue-700" x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'privacy-modal')">Privacy
                                Policy</span>.</span>
                    </label>
                    <x-input-error :messages="$errors->get('privacy')" class="mt-2" />

                </div>

            </div>
        </div>


        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <x-modal name="privacy-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center">
            <div class="flex flex-row justify-between">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Privacy Policy') }}
                </h2>
                <svg class="size-6 cursor-pointer hover:text-gray-500"
                    x-on:click="$dispatch('close-modal', 'privacy-modal')" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                        clip-rule="evenodd" />
                </svg>

            </div>
            <hr>
            <div class="flex flex-col my-4">
                <div class="flex flex-col max-h-[600px] overflow-y-auto">
                    <div class="p-4 bg-white text-gray-800 space-y-6">
                        <h2 class="text-2xl font-bold">Privacy Policy</h2>

                        <section>
                            <h3 class="text-lg font-semibold">Contact Information</h3>
                            <p>
                                For inquiries about this web portal, please contact our support team via email at
                                <a href="mailto:support@pesocareers.com"
                                    class="text-blue-500 underline">support@pesocareers.com</a>.
                            </p>
                        </section>

                        <section>
                            <h3 class="text-lg font-semibold">Privacy Commitment</h3>
                            <p>
                                We are committed to protecting your privacy. This Privacy Policy outlines our practices
                                regarding the collection,
                                use, and protection of personal data from our users. By using our web portal, you
                                consent to the terms of this Privacy
                                Policy. If there are changes to this policy, we will notify you before publishing the
                                updated Privacy Policy. If you
                                do not agree to the changes, please stop using the web portal.
                            </p>
                        </section>

                        <section>
                            <h3 class="text-lg font-semibold">Information Collection</h3>
                            <p>
                                We collect personal data when you use the web portal, which includes but is not limited
                                to:
                            </p>
                            <ul class="list-disc list-inside ml-6">
                                <li>Name, email address, location, gender, date of birth, nationality, language,
                                    disability, contact number, and work experiences.</li>
                                <li>Usage information, such as the time, date, and duration of interactions with the
                                    portal.</li>
                            </ul>
                            <p>
                                We collect this information to enhance user experience and troubleshoot issues. Any
                                additional information requested
                                will be used solely to improve the performance of the platform.
                            </p>
                        </section>

                        <section>
                            <h3 class="text-lg font-semibold">Use of Information</h3>
                            <p>
                                Your personal information is collected when you register or use the web portal. By
                                providing this information, you
                                consent to its collection and use for evaluation, monitoring, and improvement purposes.
                                We also use aggregated,
                                anonymized data for research purposes.
                            </p>
                            <p>
                                Data collected will also be used to communicate with you about relevant programs and
                                activities. We may retain your
                                information for up to 5 years, even if you delete your account, for analytics, research,
                                and historical purposes
                                related to program improvement and implementation.
                            </p>
                        </section>

                        <section>
                            <h3 class="text-lg font-semibold">Data Sharing and Security</h3>
                            <p>
                                We do not sell or rent your personal information. However, we may share aggregated or
                                anonymized data with our research
                                partners. Your data is processed securely, and we use cloud services to store it.
                                Although we employ security measures
                                to protect your information, we cannot guarantee the complete security of data
                                transmitted over the internet.
                            </p>
                            <p>
                                In compliance with legal requests, we may be required to disclose user information to
                                regulatory or governmental authorities.
                            </p>
                        </section>

                        <section>
                            <h3 class="text-lg font-semibold">Access to Personal Information</h3>
                            <p>
                                You have the right to access, correct, or delete your personal data, and in certain
                                circumstances, to object to how
                                your data is processed. However, please note that deleting your data may affect the web
                                portal’s functionality. If
                                you wish to exercise these rights or have any questions, please contact our Data
                                Controller.
                            </p>
                        </section>

                        <section>
                            <h3 class="text-lg font-semibold">Data Retention</h3>
                            <p>
                                We retain your data for as long as needed to provide services. Where your information is
                                no longer required, we may
                                store anonymized data for analytics purposes. After termination of services, your
                                personal data will be anonymized
                                but retained for research purposes.
                            </p>
                        </section>

                        <section>
                            <h3 class="text-lg font-semibold">Notification of Data Breaches</h3>
                            <p>
                                In case of a personal data breach, we will notify you promptly with relevant details
                                about the breach and its impact.
                            </p>
                        </section>

                        <section>
                            <h3 class="text-lg font-semibold">Complaints and Queries</h3>
                            <p>
                                For complaints or further information, please contact us at
                                <a href="mailto:support@pesocareers.com"
                                    class="text-blue-500 underline">support@pesocareers.com</a>. You may also contact
                                our Data Controller to request your personal data history or its removal from our
                                servers.
                            </p>
                        </section>
                    </div>



                </div>
            </div>
            {{-- <div class="mt-6 flex justify-between">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'privacy-modal')">
                    {{ __('Close') }}
                </x-secondary-button>


            </div> --}}
        </div>
    </x-modal>
    <x-modal name="terms-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center">
            <div class="flex flex-row justify-between">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Terms and Conditions') }}
                </h2>
                <svg class="size-6 cursor-pointer hover:text-gray-500"
                    x-on:click="$dispatch('close-modal', 'terms-modal')" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                        clip-rule="evenodd" />
                </svg>

            </div>
            <hr>
            <div class="flex flex-col my-4">
                <div class="flex flex-col max-h-[600px] overflow-y-auto">
                    <div class="p-4 bg-white text-gray-800 space-y-6">
                        <h2 class="text-2xl font-bold">Terms and Conditions</h2>

                        <section>
                            <h3 class="text-lg font-semibold">Introduction</h3>
                            <p>
                                Welcome to our web portal. By accessing or using our service, you agree to comply with
                                and be bound by the following Terms and Conditions. Please read these terms carefully
                                before using our services. If you do not agree with any part of these terms, you should
                                discontinue use of the portal.
                            </p>
                        </section>

                        <section>
                            <h3 class="text-lg font-semibold">Use of the Portal</h3>
                            <p>
                                You must be at least 18 years old to use this portal. By using the portal, you represent
                                and warrant that you are at least 18 years old. If you are under 18, you must obtain the
                                consent of a parent or guardian to use this portal.
                            </p>
                            <p>
                                You agree to use the portal only for lawful purposes and in accordance with these Terms
                                and Conditions. You agree not to use the portal in any way that may violate any
                                applicable laws or regulations.
                            </p>
                        </section>

                        <section>
                            <h3 class="text-lg font-semibold">Account Responsibilities</h3>
                            <p>
                                If you create an account on our portal, you are responsible for maintaining the
                                confidentiality of your account details and for all activities that occur under your
                                account. You agree to notify us immediately of any unauthorized use of your account or
                                any other breach of security.
                            </p>
                            <p>
                                We are not liable for any loss or damage arising from your failure to protect your
                                account details. You must ensure that all information provided to us is accurate and
                                up-to-date.
                            </p>
                        </section>

                        <section>
                            <h3 class="text-lg font-semibold">Intellectual Property</h3>
                            <p>
                                The content and materials on the portal, including but not limited to text, graphics,
                                logos, and software, are the intellectual property of the portal or its licensors. You
                                may not use, reproduce, distribute, or create derivative works from any content without
                                explicit permission from us.
                            </p>
                        </section>

                        <section>
                            <h3 class="text-lg font-semibold">Termination</h3>
                            <p>
                                We reserve the right to terminate or suspend your access to the portal at our sole
                                discretion, without prior notice, for any reason, including but not limited to a breach
                                of these Terms and Conditions.
                            </p>
                            <p>
                                Upon termination, your right to use the portal will cease immediately, and you must
                                promptly delete any downloaded content from the portal.
                            </p>
                        </section>

                        <section>
                            <h3 class="text-lg font-semibold">Limitation of Liability</h3>
                            <p>
                                To the maximum extent permitted by law, we shall not be liable for any direct, indirect,
                                incidental, special, or consequential damages arising from or related to your use of the
                                portal, including but not limited to damages for loss of data or profits.
                            </p>
                        </section>

                        <section>
                            <h3 class="text-lg font-semibold">Governing Law</h3>
                            <p>
                                These Terms and Conditions are governed by and construed in accordance with the laws of
                                the jurisdiction in which the portal operates. Any disputes arising from these terms
                                will be resolved in the courts located in that jurisdiction.
                            </p>
                        </section>

                        <section>
                            <h3 class="text-lg font-semibold">Changes to Terms</h3>
                            <p>
                                We may update these Terms and Conditions from time to time. Any changes will be posted
                                on this page with an updated effective date. Your continued use of the portal after any
                                changes indicates your acceptance of the new terms.
                            </p>
                        </section>

                        <section>
                            <h3 class="text-lg font-semibold">Contact Us</h3>
                            <p>
                                If you have any questions about these Terms and Conditions, please contact us at
                                <a href="mailto:support@pesocareers.com"
                                    class="text-blue-500 underline">support@pesocareers.com</a>.
                            </p>
                        </section>
                    </div>




                </div>
            </div>

        </div>
    </x-modal>
    
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


</x-guest-layout>
