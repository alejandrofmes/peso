<?php

use App\Http\Controllers\Error\ErrorController;
use App\Http\Controllers\PDF\PDFView;
use App\Http\Controllers\ProfileController;
use App\Livewire\Admin\Accounts\Employer\EmployerManagement;
use App\Livewire\Admin\Accounts\Employer\EmployerOverview;
use App\Livewire\Admin\Accounts\Jobseeker\JobseekerManagement;
use App\Livewire\Admin\Accounts\Jobseeker\JobseekerOverview;
use App\Livewire\Admin\Accounts\Peso\PesoManagement;
use App\Livewire\Admin\Accounts\Peso\PesoOverview;
use App\Livewire\Admin\Announcement\AnnouncementList;
use App\Livewire\Admin\Announcement\CreateAnnouncement;
use App\Livewire\Admin\Announcement\EditAnnouncement;
use App\Livewire\Admin\Certificates\Certificates;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\EligibilityLicense\EligibilityLicense;
use App\Livewire\Admin\JobPosting\Applicants\ApplicantOverview;
use App\Livewire\Admin\JobPosting\Applicants\JobPostApplicants;
use App\Livewire\Admin\JobPosting\JobPosting;
use App\Livewire\Admin\JobPosting\JobPostOverview;
use App\Livewire\Admin\LocationManagement\Location;
use App\Livewire\Admin\Maintenance\Audits;
use App\Livewire\Admin\Maintenance\Backup;
use App\Livewire\Admin\Maintenance\Features;
use App\Livewire\Admin\Maintenance\MunicipalityAudits;
use App\Livewire\Admin\Maintenance\PesoBranch;
use App\Livewire\Admin\Partnership\PartnershipDetails;
use App\Livewire\Admin\Partnership\PartnershipList;
use App\Livewire\Admin\PositionIndustry\PositionIndustry;
use App\Livewire\Admin\Reports\BarangayReports;
use App\Livewire\Admin\Reports\MunicipalityReports;
use App\Livewire\Admin\Requirements\Requirements;
use App\Livewire\Admin\Super\Dashboard as SuperDashboard;
use App\Livewire\Admin\Super\Reports\MunicipalityReports as ReportsMunicipalityReports;
use App\Livewire\Admin\Super\Reports\ProvinceReports;
use App\Livewire\Admin\Training\CreateTrainining;
use App\Livewire\Admin\Training\EditTraining;
use App\Livewire\Admin\Training\TrainingDetails;
use App\Livewire\Admin\Training\TrainingList;
use App\Livewire\Admin\Training\TrainingRegistrants;
use App\Livewire\Employer\Dashboard\JobApplicants;
use App\Livewire\Employer\Dashboard\JobPostList;
use App\Livewire\Employer\Jobpost\JobpostApplication;
use App\Livewire\Employer\Jobpost\JobPostDetails;
use App\Livewire\Employer\Jobpost\JobPostEdit;
use App\Livewire\Jobseeker\ApplicationHistory;
use App\Livewire\Public\AnnouncementView;
use App\Livewire\Public\Dashboard;
use App\Livewire\Public\JobpostView;
use App\Livewire\Public\Profile\Employer\EmployerProfile;
use App\Livewire\Public\Profile\Employer\Partials\EditDetails as EmployerEditDetails;
use App\Livewire\Public\Profile\Jobseeker\JobseekerProfile;
use App\Livewire\Public\Profile\Jobseeker\Partials\EditDetails;
use App\Livewire\Public\Profile\Peso\PesoProfile;
use App\Livewire\Public\SearchProfiles;
use App\Livewire\Public\Trainings;
use App\Livewire\Public\TrainingView;
use App\Livewire\Signup\Employer\EmployerInformation;
use App\Livewire\Signup\Jobseeker\JobseekerInformation;
// use function Spatie\LaravelPdf\Support\pdf;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */
// Route::get('/a', function () {
//     return view('pdf.reports.sample-report');
// })->name('a');

Route::get('/404', [ErrorController::class, 'notFound'])->name('error.404');

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/test', function () {
    // return pdf()
    //     ->view('pdf.reports.sample-report')
    //     ->name('test_report.pdf')
    //     ->download();
    return Pdf::view('pdf.reports.sample-report')
        ->withBrowsershot(function (Browsershot $shot) {
            $shot->noSandbox();
        })
        ->headerView('pdf.reports.pdfHeader')
        ->footerView('pdf.reports.pdfFooter')
        ->download('purchase-order.pdf');
});

Route::middleware(['auth', 'verified', 'usertype:4,6,7,8,9,10,11', 'check.user.status', 'google2fa'])->group(function () {
    // Route::middleware(['auth', 'usertype:4,6,7,8,9,10,11', 'check.user.status', 'google2fa'])->group(function () {

    Route::get('/settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/settings', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//------------------------------ SIGN UP ------------------------------

Route::middleware(['verified'])->group(function () {
    Route::get('/jobseeker/details', JobseekerInformation::class)->name('fill_profile')->middleware(['usertype:2']);
    Route::get('/employer/details', EmployerInformation::class)->name('fill_employer')->middleware(['usertype:3']);
});

//------------------------------ PUBLIC ------------------------------
Route::middleware(['verifiedOrPublic', 'incomplete.user', 'check.user.status', 'google2fa'])->group(function () {
    // Route::middleware(['incomplete.user', 'check.user.status', 'google2fa'])->group(function () {

    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/trainings', Trainings::class)->name('trainings');

    Route::get('/jobpost/{id}', JobpostView::class)->name('jobpost.show');
    Route::get('/announcements/{id}', AnnouncementView::class)->name('announcement.show');
    Route::get('/training/{id}', TrainingView::class)->name('training.show');
});
//------------------------------ PUBLIC - PROFILE ------------------------------
Route::middleware(['auth', 'verified', 'usertype:4,6,7,8,9,10,11', 'check.user.status'])->group(function () {
    // Route::middleware(['auth', 'usertype:4,6,7,8,9,10,11', 'check.user.status'])->group(function () {

    Route::get('/profile/jid={id}', JobseekerProfile::class)->name('jobseeker.profile')->middleware('profile.privacy');;
    Route::get('/profile/eid={id}', EmployerProfile::class)->name('employer.profile');
    Route::get('/profile/pid={id}', PesoProfile::class)->name('peso.profile');
    Route::get('/search/profile', SearchProfiles::class)->name('search.profiles');
});

//------------------------------ JOBSEEKER ------------------------------
Route::middleware(['auth', 'verified', 'usertype:4', 'check.user.status', 'google2fa'])->group(function () {
    // Route::middleware(['auth', 'usertype:4', 'check.user.status', 'google2fa'])->group(function () {

    Route::get('/applications/history', ApplicationHistory::class)->name('jobseeker.application');
    Route::get('/profile/edit', EditDetails::class)->name('edit.details');
});

Route::middleware(['auth', 'verified', 'usertype:6', 'check.user.status', 'google2fa'])->group(function () {
    // Route::middleware(['auth', 'usertype:6', 'check.user.status', 'google2fa'])->group(function () {

    Route::get('/apply', JobpostApplication::class)->name('jobpost.apply');
    Route::get('/jobpost/details/{id}', JobPostDetails::class)->name('jobpost.details');
    Route::get('/edit/jobpost', JobPostEdit::class)->name('jobpost.edit');

    Route::get('/employer/jobpost', JobPostList::class)->name('employer.dashboard');
    Route::get('/applicants', JobApplicants::class)->name('jobpost.applicants');
});
Route::middleware(['auth', 'verified', 'usertype:5,6', 'google2fa'])->group(function () {
    Route::get('/employer/edit', EmployerEditDetails::class)->name('edit.details.emp');
});
//------------------------------ ADMIN  NAVIGATION ------------------------------\
Route::prefix('admin')->group(function () {

    Route::middleware(['auth', 'verified', 'usertype:8,9,10', 'check.user.status', 'google2fa'])->group(function () {
        // Route::middleware(['auth', 'usertype:8,9,10', 'check.user.status', 'google2fa'])->group(function () {

        Route::get('/', AdminDashboard::class)->name('admin');

        Route::get('/jobs', JobPosting::class)->name('admin-joblist');

        Route::get('/partnership', PartnershipList::class)->name('admin-partnership');
        Route::get('/partnership/{id}', PartnershipDetails::class)->name('admin-partnership-details');

        Route::get('/announcements', AnnouncementList::class)->name('admin-announcement');
        Route::get('/announcements/create', CreateAnnouncement::class)->name('admin-create-announcement');
        Route::get('/announcements/edit', EditAnnouncement::class)->name('admin-edit-announcement');

        Route::get('/manage/jobseeker', JobseekerManagement::class)->name('admin-users-jobseeker');
        Route::get('/manage/jobseeker/{id}', JobseekerOverview::class)->name('admin-users-jobseeker-overview');

        Route::get('/manage/employer', EmployerManagement::class)->name('admin-users-employer');
        Route::get('/manage/employer/{id}', EmployerOverview::class)->name('admin-users-employer-overview');
        Route::middleware('usertype:10')->group(function () {
            Route::get('/manage/peso/', PesoManagement::class)->name('admin-users-peso');
            Route::get('/manage/peso/{id}', PesoOverview::class)->name('admin-users-peso-overview');
        });
        Route::get('/training', TrainingList::class)->name('admin-training');
        Route::get('/training/create', CreateTrainining::class)->name('admin-create-training');
        Route::get('/training/edit', EditTraining::class)->name('admin-edit-training');
        Route::get('/training/details/{id}', TrainingDetails::class)->name('admin-view-training');
        Route::get('/training/{id}', TrainingRegistrants::class)->name('admin-registrants-training');

        Route::get('/reports/barangay', BarangayReports::class)->name('admin-reports-barangay');
        Route::get('/reports/municipality', MunicipalityReports::class)->name('admin-reports-municipality');

        Route::get('/job/overview/{id}', JobPostOverview::class)->name('admin.jobpost');
        Route::get('/job/applicants/{id}', JobPostApplicants::class)->name('admin.jobpost.applicants');
        Route::get('/job/applicants/overview/{id}', ApplicantOverview::class)->name('admin.jobpost.applicants.overview');

        Route::get('/municipality/audits', MunicipalityAudits::class)->name('admin-municipality-audits');
    });

    // EVERYTHING UNDER HERE IS SUPER ADMIN
    Route::middleware(['auth', 'verified', 'usertype:11', 'check.user.status'])->group(function () {
        // Route::middleware(['auth', 'usertype:11', 'check.user.status'])->group(function () {

        Route::get('super/', SuperDashboard::class)->name('super-dashboard');
        Route::get('super/municipality', ReportsMunicipalityReports::class)->name('super-municipality');
        Route::get('super/province', ProvinceReports::class)->name('super-province');

        // MAINTENANCE

        Route::get('/peso', PesoBranch::class)->name('admin-peso');
        Route::get('/audits', Audits::class)->name('admin-audits');
        Route::get('/backups', Backup::class)->name('admin-backups');

        Route::get('/eligibility', EligibilityLicense::class)->name('admin-eligibility');

        Route::get('/location', Location::class)->name('admin-location');

        Route::get('/industry', PositionIndustry::class)->name('admin-industry');

        Route::get('/certificate', Certificates::class)->name('admin-certificate');

        Route::get('/requirements', Requirements::class)->name('admin-req');

        Route::get('/features', Features::class)->name('admin-features');
    });
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'verified', 'usertype:4,6,7,8,9,10,11', 'google2fa'])->group(function () {
    // Route::middleware(['auth', 'usertype:4,6,7,8,9,10,11', 'google2fa'])->group(function () {

    Route::post('/resume/view', [PDFView::class, 'viewResume'])->name('view.resume');
    Route::post('/recommendation/view', [PDFView::class, 'viewRecommendation'])->name('view.recommendation');
    Route::post('/requirement/view', [PDFView::class, 'viewRequirement'])->name('view.requirement');
});

Route::middleware(['auth', 'verified', 'usertype:8,9,10,11', 'google2fa'])->group(function () {
    Route::get('/export/barangay/jobseeker/pdf/{data}', function ($data) {
        try {
            $decryptedData = json_decode(Crypt::decryptString($data), true);
            $employees = $decryptedData['employees'];
            $peso = $decryptedData['peso'];

            return Pdf::view('pdf.reports.barangay-jobseeker-report', [
                'employees' => $employees,
                'peso' => $peso,
            ])
                ->withBrowsershot(function (Browsershot $shot) {
                    $shot->noSandbox();
                })
                ->margins(1.5, 1, 1, 1)
                ->download($decryptedData['fileName']);

        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Invalid data provided');
        }
    })->name('export.barangay.jobseeker');

    Route::get('/export/municipality/jobseeker/pdf/{data}', function ($data) {
        try {
            $decryptedData = json_decode(Crypt::decryptString($data), true);
            $employees = $decryptedData['employees'];
            $peso = $decryptedData['peso'];

            return Pdf::view('pdf.reports.municipality-jobseeker-report', [
                'employees' => $employees,
                'peso' => $peso,
            ])
                ->withBrowsershot(function (Browsershot $shot) {
                    $shot->noSandbox();
                })
                ->margins(1.5, 1, 1, 1)
                ->download($decryptedData['fileName']);

        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Invalid data provided');
        }
    })->name('export.municipality.jobseeker');

    Route::get('/export/employer/pdf/{data}', function ($data) {
        try {
            $decryptedData = json_decode(Crypt::decryptString($data), true);
            $employers = $decryptedData['employer'];
            $peso = $decryptedData['peso'];

            return Pdf::view('pdf.reports.employer-report', [
                'employers' => $employers,
                'peso' => $peso,
            ])
                ->withBrowsershot(function (Browsershot $shot) {
                    $shot->noSandbox();
                })
                ->margins(1.5, 1, 1, 1)
                ->download($decryptedData['fileName']);

        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Invalid data provided');
        }
    })->name('export.employer');
    Route::get('/export/programs/pdf/{data}', function ($data) {
        try {
            $decryptedData = json_decode(Crypt::decryptString($data), true);
            $programs = $decryptedData['programs'];
            $peso = $decryptedData['peso'];

            return Pdf::view('pdf.reports.program-report', [
                'programs' => $programs,
                'peso' => $peso,
            ])
                ->withBrowsershot(function (Browsershot $shot) {
                    $shot->noSandbox();
                })
                ->margins(1.5, 1, 1, 1)
                ->download($decryptedData['fileName']);

        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Invalid data provided');
        }
    })->name('export.programs');
    Route::get('/export/jobpost/pdf/{data}', function ($data) {
        try {
            $decryptedData = json_decode(Crypt::decryptString($data), true);
            $jobposts = $decryptedData['jobposts'];
            $peso = $decryptedData['peso'];

            return Pdf::view('pdf.reports.jobpost-report', [
                'jobposts' => $jobposts,
                'peso' => $peso,
            ])
                ->withBrowsershot(function (Browsershot $shot) {
                    $shot->noSandbox();
                })
                ->margins(1.5, 1, 1, 1)
                ->download($decryptedData['fileName']);

        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Invalid data provided');
        }
    })->name('export.jobposts');
});
