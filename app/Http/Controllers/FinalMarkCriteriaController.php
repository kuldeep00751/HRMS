<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\AssessmentResultCode;
use App\Models\AssessmentType;
use App\Models\FinalMarkCriteria;
use App\Models\Module;
use Exception;
use Illuminate\Http\Request;

class FinalMarkCriteriaController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    /**
     * Display a listing of the study modes.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        $modules = Module::where('active',1)->pluck('module_name', 'id')->all();

        $assessmentTypes = AssessmentType::where('active',1)->pluck('assessment_type', 'id')->all();

        $academicYears = AcademicYear::pluck('name', 'id')->all();

        $finalMarkCriterias = [];

        
        return view('pages.settings.final_mark_criterias.index', compact('finalMarkCriterias', 'modules', 'assessmentTypes', 'academicYears'));
    }

    private function filterData($request)
    {
        if (count($request->all())) {
            return $request->all();
        } else {
            return [
                'academic_year_id' => 0,
                'module_id' => 0,
                'assessment_type_id' => 0,
            ];
        }
    }

    public function filter(Request $request)
    {
        $academicYears = AcademicYear::pluck('name', 'id')->all();

        $modules = Module::where('active',1)->pluck('module_name', 'id')->all();

        $assessmentTypes = AssessmentType::where('active',1)->pluck('assessment_type', 'id')->all();

        $filterData = $this->filterData($request);
        
        session()->put($filterData);

        $finalMarkCriterias = FinalMarkCriteria::with('module', 'academicYear', 'assessmentType', 'assessmentResultCode')
                                                ->where('module_id', $filterData['module_id'])
                                                ->where('assessment_type_id', $filterData['assessment_type_id'])
                                                ->where('academic_year_id', $filterData['academic_year_id'])
                                                ->get();

        return view('pages.settings.final_mark_criterias.index', compact('academicYears', 'modules', 'filterData', 'assessmentTypes', 'finalMarkCriterias'));
    }


    /**
     * Show the form for creating a new study mode.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {

        $modules = Module::where('active',1)->pluck('module_name', 'id')->all();

        $assessmentTypes = AssessmentType::where('active',1)->pluck('assessment_type', 'id')->all();

        $academicYears = AcademicYear::pluck('name', 'id')->all();

        $assessmentResultCode = AssessmentResultCode::selectRaw('concat(result_code, concat("-",result_code_description)) as result_code, id')->pluck('result_code', 'id')->all();

        return view('pages.settings.final_mark_criterias.create', compact('modules', 'assessmentTypes', 'academicYears', 'assessmentResultCode'));
    }

    /**
     * Store a new study mode in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {

            $data = $this->getData($request);

            foreach ($data['assessment_result_code_id'] as $key => $value) {
                FinalMarkCriteria::create(
                    [
                        'module_id' => $data['module_id'],
                        'academic_year_id' => $data['academic_year_id'],
                        'assessment_type_id' => $data['assessment_type_id'],
                        'assessment_result_code_id' => $data['assessment_result_code_id'][$key],
                        'min_mark' => $data['min_mark'][$key],
                        'max_mark' => $data['max_mark'][$key],
                        'created_by' => auth()->user()->id
                    ]
                );
            }


            return redirect()->route('final_mark_criterias.final_mark_criteria.index')
            ->with('success_message', 'Grading Scale was successfully added.');
        } catch (Exception $exception) {
            dd($exception);
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Display the specified study mode.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $assessmentType = AssessmentType::findOrFail($id);

        return view('pages.settings.exam_paper_mark_criterias.show', compact('assessmentType'));
    }

    /**
     * Show the form for editing the specified study mode.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $finalMarkCriteria = FinalMarkCriteria::findOrFail($id);

        $finalMarkCriterias = FinalMarkCriteria::where('module_id', $finalMarkCriteria->module_id)
                                                    ->where('academic_year_id', $finalMarkCriteria->academic_year_id)
                                                    ->where('assessment_type_id', $finalMarkCriteria->assessment_type_id)
                                                    ->get();

        $modules = Module::where('active',1)->pluck('module_name', 'id')->all();

        $assessmentTypes = AssessmentType::where('active',1)->pluck('assessment_type', 'id')->all();

        $academicYears = AcademicYear::pluck('name', 'id')->all();

        $assessmentResultCodes = AssessmentResultCode::selectRaw('concat(result_code, concat("-",result_code_description)) as result_code, id')->pluck('result_code', 'id')->all();

        return view('pages.settings.final_mark_criterias.edit', compact('finalMarkCriterias', 'modules', 'assessmentTypes', 'academicYears', 'assessmentResultCodes'));
    }

    /**
     * Update the specified study mode in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        try {

            $data = $this->getData($request);

            if($this->markRangesOverlaps($request)){
                return back()->withInput()
                    ->withErrors(['unexpected_error' => 'Error saving record. Please make sure there are no overlapping mark ranges.']);
            }

            $finalMarkCriteria = FinalMarkCriteria::findOrFail($id);
            
            FinalMarkCriteria::where('module_id', $finalMarkCriteria->module_id)
                            ->where('academic_year_id', $finalMarkCriteria->academic_year_id)
                            ->where('assessment_type_id', $finalMarkCriteria->assessment_type_id)
                            ->delete();

            foreach ($data['assessment_result_code_id'] as $key => $value) {
                FinalMarkCriteria::create(
                    [
                        'module_id' => $data['module_id'],
                        'academic_year_id' => $data['academic_year_id'],
                        'assessment_type_id' => $data['assessment_type_id'],
                        'assessment_result_code_id' => $data['assessment_result_code_id'][$key],
                        'min_mark' => $data['min_mark'][$key],
                        'max_mark' => $data['max_mark'][$key],
                        'created_by' => auth()->user()->id
                    ]
                );
            }

            return redirect()->route('final_mark_criterias.final_mark_criteria.index')
            ->with('success_message', 'Grading Scale was successfully updated.');
        } catch (Exception $exception) {
            
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    private function markRangesOverlaps($data){
        for ($i = 0; $i < count($data['assessment_result_code_id']) - 1; $i++) {
            
            if ($data['max_mark'][$i] >= $data['min_mark'][$i + 1]) {
                return true;
            }
        }

        return false;
    }

    public function getResultCodes()
    {

        $assessmentResultCodes = AssessmentResultCode::selectRaw('concat(result_code, concat("-",result_code_description)) as result_code, id')->pluck('result_code', 'id')->all();

        return view('pages.settings.final_mark_criterias.criteria-tr', compact('assessmentResultCodes'))->render();
    }

    public function copy(Request $request)
    {

        try {
            $fromFinalMarkGradings = FinalMarkCriteria::where('academic_year_id', $request->from_academic_year_id)->get();
            
            if (!count($fromFinalMarkGradings)) {
                return back()->withInput()
                    ->withErrors(['unexpected_error' => 'The selected from academic year does not have any final mark grading scales.']);
            }

            $toFinalMarkGradings = FinalMarkCriteria::where('academic_year_id', $request->to_academic_year_id)->get();
            foreach ($fromFinalMarkGradings as $fromFinalMarkGrading) {
                
                $toFinalMarkGrading = $toFinalMarkGradings->where('module_id', $fromFinalMarkGrading->module_id);

                if (!count($toFinalMarkGrading)) {
                    
                    FinalMarkCriteria::create([
                        'module_id' => $request->from_academic_year_id,
                        'academic_year_id' => $request->to_academic_year_id,
                        'assessment_type_id' => $fromFinalMarkGrading->assessment_type_id,
                        'assessment_result_code_id' => $fromFinalMarkGrading->assessment_result_code_id,
                        'min_mark' => $fromFinalMarkGrading->min_mark,
                        'max_mark' => $fromFinalMarkGrading->max_mark,
                        'created_by' => auth()->user()->id
                    ]);
                    
                }
                
            }

            return redirect()->route('final_mark_criterias.final_mark_criteria.index')
            ->with('success_message', 'Grading Scale was successfully updated.');
        } catch (Exception $exception) {
            dd($exception);
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }



    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request 
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
            'module_id' => 'required',
            'academic_year_id' => 'required',
            'assessment_type_id' => 'required',
            'assessment_result_code_id' => 'required',
            'min_mark' => 'required',
            'max_mark' => 'required',
        ];

        $data = $request->validate($rules);

        return $data;
    }
}
