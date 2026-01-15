<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Job_Applicants;
use App\Models\Requirements_Passed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PDFView extends Controller
{
    public function viewResume(Request $request)
    {

        // Validate the request to ensure an ID is provided
        $request->validate([
            'emp_id' => 'required|exists:employee,employee_id',
            'resume_type' => 'required',

        ]);
        $employee = Employee::findOrFail($request->input('emp_id'));

        if ($request->input('resume_type') == 1) {

            if (!$employee->resume || !Storage::exists('public/' . $employee->resume)) {

                return redirect('/404')->with('error', 'There was an error with the resume.');

            }

            $filePath = $employee->resume;

            return view('pdf.resume-view', ['pdfPath' => $filePath]);
        } elseif ($request->input('resume_type') == 2) {

            $eduLevels = [
                '1' => 'GRADE I',
                '2' => 'GRADE II',
                '3' => 'GRADE III',
                '4' => 'GRADE IV',
                '5' => 'GRADE V',
                '6' => 'GRADE VI',
                '7' => 'GRADE VII',
                '8' => 'GRADE VIII',
                '9' => 'ELEMENTARY GRADUATE',
                '10' => '1ST YEAR HIGH SCHOOL/GRADE VII (FOR K TO 12)',
                '11' => '2ND YEAR HIGH SCHOOL/GRADE VIII (FOR K TO 12)',
                '12' => '3RD YEAR HIGH SCHOOL/GRADE IX (FOR K TO 12)',
                '13' => '4TH YEAR HIGH SCHOOL/GRADE X (FOR K TO 12)',
                '14' => 'GRADE XI (FOR K TO 12)',
                '15' => 'GRADE XII (FOR K TO 12)',
                '16' => 'HIGH SCHOOL GRADUATE',
                '17' => 'VOCATIONAL UNDERGRADUATE',
                '18' => 'VOCATIONAL GRADUATE',
                '19' => '1ST YEAR COLLEGE LEVEL',
                '20' => '2ND YEAR COLLEGE LEVEL',
                '21' => '3RD YEAR COLLEGE LEVEL',
                '22' => '4TH YEAR COLLEGE LEVEL',
                '23' => '5TH YEAR COLLEGE LEVEL',
                '24' => 'COLLEGE GRADUATE',
                '25' => 'MASTERAL/POST GRADUATE LEVEL',
                '26' => 'MASTERAL/POST GRADUATE',
            ];

            return view('pdf.resume-auto',
                ['employee' => $employee,
                    'eduLevels' => $eduLevels]);

        }

    }

    public function viewRecommendation(Request $request)
    {
        // Validate the request to ensure an ID is provided
        $request->validate([
            'app_id' => 'required|exists:job_applicants,applicant_id',

        ]);

        $applicant = Job_Applicants::findOrFail($request->input('app_id'));

        // dd($applicant->peso_Letter);

        if (!$applicant->peso_Status == 'RECOMMENDED' || !Storage::exists('public/' . $applicant->peso_Letter)) {
            // return response()->json(['error' => 'Resume not found'], Response::HTTP_NOT_FOUND);
            return redirect('/404')->with('error', 'There was an error with the recommendation letter.');

        }

        $filePath = $applicant->peso_Letter;

        return view('pdf.recommendation-view', ['pdfPath' => $filePath]);

    }

    public function viewRequirement(Request $request)
    { // Validate the request to ensure an ID is provided
        $request->validate([
            'req_passed_id' => 'required|exists:requirements_passed,req_passed_id',

        ]);
        $requirement = Requirements_Passed::findOrFail($request->input('req_passed_id'));

        // dd($requirement->req_passed_Input);

        if (!Storage::exists('public/' . $requirement->req_passed_Input)) {
            // return response()->json(['error' => 'Requirement File not found'], Response::HTTP_NOT_FOUND);
            return redirect('/404')->with('error', 'There was an error with the requirements.');

        }

        $filePath = $requirement->req_passed_Input;

        return view('pdf.requirement-view', ['pdfPath' => $filePath]);

    }

}
