<div class="row mb-5">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('student_charge_type_id') ? 'has-error' : '' }}">
            <label for="student_charge_type_id" class="control-label required">Charge </label>
            <select class="form-control" id="student_charge_type_id" name="student_charge_type_id" required>
                <option value="" style="display: none;" {{ old('student_charge_type_id', optional($studentCharge)->student_charge_type_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select charge type</option>
                @foreach ($studentChargeTypes as $key => $studentChargeType)
                <option value="{{ $key }}" {{ old('student_charge_type_id', optional($studentCharge)->student_charge_type_id) == $key ? 'selected' : '' }}>
                    {{ $studentChargeType }}
                </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

@if($bulk)
<div class="row mb-5">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('academic_intake_id') ? 'has-error' : '' }}">
            <label for="academic_intake_id" class="control-label required">Academic Intake</label>
            <select class="form-control" id="academic_intake_id" name="academic_intake_id" required>
                <option value="" style="display: none;" {{ old('academic_intake_id', optional($studentCharge)->academic_intake_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select academic intake</option>
                @foreach ($academicIntakes as $key => $academicIntake)
                <option value="{{ $key }}" {{ old('academic_intake_id', optional($studentCharge)->academic_intake_id) == $key ? 'selected' : '' }}>
                    {{ $academicIntake }}
                </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('module_id') ? 'has-error' : '' }}">
            <label for="module_id" class="control-label">Module</label>

            <select class="form-control" id="module_id" name="module_id" data-control="select2">
                <option value="" style="display: none;" {{ old('module_id', optional($studentCharge)->module_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select module</option>
                @foreach ($modules as $key => $module)
                <option value="{{ $key }}" {{ old('module_id', optional($studentCharge)->module_id) == $key ? 'selected' : '' }}>
                    {{ $module }}
                </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('qualification_id') ? 'has-error' : '' }}">
            <label for="qualification_id" class="control-label">Qualification </label>
            <select class="form-control" id="qualification_id" name="qualification_id" data-control="select2">
                <option value="" style="display: none;" {{ old('qualification_id', optional($studentCharge)->qualification_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select qualification</option>
                @foreach ($qualifications as $key => $qualification)
                <option value="{{ $key }}" {{ old('qualification_id', optional($studentCharge)->qualification_id) == $key ? 'selected' : '' }}>
                    {{ $qualification }}
                </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
@else
<div class="row mb-5">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
            <label for="amount" class="control-label">Student Number <span class="text-danger">*</span></label>
            <input class="form-control" name="student_number" type="number" id="student_number" value="{{ old('student_number', optional($studentCharge)->student_number) }}">
            <p class="help-block text-danger" id="student_number_error"></p>
        </div>
    </div>
</div>

<div class="mb-5 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="student_name" class="control-label"><strong>Student Name</strong></label>
    <input class="form-control" type="text" name="student_name" id="student_name" value="{{old('student_name')}}" disabled>
</div>
@endif

<div class="row mb-5">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
            <label for="amount" class="control-label">Transaction Date <span class="text-danger">*</span></label>
            <input class="form-control" name="transaction_date" type="text" id="transaction_date" value="{{date('Y-m-d')}}" readonly>
        </div>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
            <label for="amount" class="control-label">Amount (N$) <span class="text-danger">*</span></label>
            <input class="form-control" name="amount" type="text" id="amount" value="{{ old('amount', optional($studentCharge)->amount) }}">
            <input class="form-control" name="created_by" type="hidden" id="created_by" value="{{ auth()->user()->id }}">
        </div>
    </div>
</div>

<script>
    let studentNumber = document.getElementById('student_number')

    let studentName = document.getElementById('student_name')

    let studentNumberError = document.getElementById('student_number_error')

    studentNumber.addEventListener('change', function(e) {
        let url = `/get-student-info/${studentNumber.value}`

        const response = fetch(url, {
                method: "GET",
            })
            .then((response) => response.json())
            .then((data) => {
                console.log(data)
                if (data.status) {
                    studentName.value = `${data.student_info.first_names} ${data.student_info.surname}`;
                    studentNumberError.innerHTML = "";
                } else {
                    studentNumberError.innerHTML = data.message
                    userInfoId.value = "";
                    studentName.value = "";
                }
            })
    })
</script>