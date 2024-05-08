<div id="section-to-print" onload="window.onload = function() { window.print(); }">
    <table style="width: 100%;">
        <tr>
            <td style="width: 80%">
                <h3 style="font-family: monospace;"><strong>PROOF OF REGISTRATION</strong></h3>
            </td>
            <td>
                <a href="#" class="d-block mw-150px ms-sm-auto">
                    @if($lov->where('label', 'COMPANY_LOGO')->first())
                    <img alt="Logo" src="{{ asset($lov->where('label', 'COMPANY_LOGO')->first()->value) }}" class="w-100" width="200">
                    @else
                    No Logo
                    @endif
                </a>
                <!--end::Logo-->

                <!--begin::Text-->
                <div class="text-sm-end fw-semibold fs-4 text-muted mt-7">
                    <div style="font-family: monospace;">
                        <strong>{{ $lov->where('label', 'COMPANY_NAME')->first()->value }}</strong>
                    </div>
                    <div style="font-family: monospace;">
                        {{ optional($lov->where('label', 'COMPANY_ADDRESS_1')->first())->value }} <br>
                        {{ optional($lov->where('label', 'COMPANY_ADDRESS_2')->first())->value }} <br>
                        {{ optional($lov->where('label', 'COMPANY_ADDRESS_3')->first())->value }} <br>
                        <strong>E: </strong>{{ optional($lov->where('label', 'COMPANY_EMAIL')->first())->value }} <br>
                        <strong>C: </strong>{{ optional($lov->where('label', 'COMPANY_CONTACT_NUMBER')->first())->value }} <br>
                        <strong>F: </strong>{{ optional($lov->where('label', 'COMPANY_FAX')->first())->value }} <br>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <table style="width:100%;  font-family: monospace;">
        <tr>
            <td><strong>{{ __('Student Name') }}</strong></td>
            <td>:</td>
            <td>
                {{ $studentRegistration->userInfo->first_names }} {{ $studentRegistration->userInfo->surname }}
            </td>
        </tr>
        <tr>
            <td><strong>{{ __('Student Number') }}</strong></td>
            <td>:</td>
            <td>
                {{ $studentRegistration->userInfo->student_number }}
            </td>
        </tr>
        <tr>
            <td><strong>{{ __('ID Number') }}</strong></td>
            <td>:</td>
            <td>
                {{ $studentRegistration->userInfo->id_number }}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <br>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <p style="font-weight:400; font-family: monospace; ">
                    <strong>This is to certify that the student has been registered as follows:</strong>
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <br>
            </td>
        </tr>
        <tr>
            <td><strong>{{ __('Qualification') }}</strong></td>
            <td>:</td>
            <td>
                {{ $studentRegistration->qualification->qualification_name }} ({{ $studentRegistration->qualification->qualification_code }}
            </td>
        </tr>
        <tr>
            <td><strong>{{ __('Year Level') }}</strong></td>
            <td>:</td>
            <td>
                {{ $studentRegistration->yearLevel->year_level }}
            </td>
        </tr>
        <tr>
            <td><strong>{{ __('Academic Year') }}</strong></td>
            <td>:</td>
            <td>
                {{ $studentRegistration->academicYear->name }}
            </td>
        </tr>

        <tr>
            <td><strong>{{ __('Academic Intake') }}</strong></td>
            <td>:</td>
            <td>
                {{ $studentRegistration->academicIntake->name }}
            </td>
        </tr>

        <tr>
            <td><strong>{{ __('Study Mode') }}</strong></td>
            <td>:</td>
            <td>
                {{ $studentRegistration->studyMode->study_mode }}
            </td>
        </tr>

        <tr>
            <td><strong>{{ __('Campus') }}</strong></td>
            <td>:</td>
            <td>
                {{ $studentRegistration->campus->name }}
            </td>
        </tr>
    </table>

    <br>
    <br>
    <br>

    <table style="width:100%;  font-family: monospace; border-collapse: collapse;" border="1">
        <tr class="fw-bold fs-6 text-gray-800 bg-gray-300" style="border: 1px solid #e6e6ef; padding: 10px;">
            <th style="text-align: left; padding: 10px;">Module Name</th>
            <th style="text-align: left; padding: 10px;">Module Code</th>
            <th style="text-align: left; padding: 10px;">Academic Intake</th>
            <th style="text-align: left; padding: 10px;">Study Mode</th>
            <th style="text-align: left; padding: 10px;">Study Period</th>
        </tr>
        @foreach($moduleRegistration as $registration)
        <tr style="border: 1px solid #e6e6ef; padding: 5px;">
            <td style="text-align: left; padding: 10px;">{{$registration->module->module_name}}</td>
            <td style="text-align: left; padding: 10px;">{{$registration->module->module_code}}</td>
            <td style="text-align: left; padding: 10px;">{{$registration->academicIntake->name}}</td>
            <td style="text-align: left; padding: 10px;">{{$registration->studyMode->study_mode}}</td>
            <td style="text-align: left; padding: 10px;">{{$registration->studyPeriod->study_period}}</td>
        </tr>
        @endforeach
    </table>

</div>