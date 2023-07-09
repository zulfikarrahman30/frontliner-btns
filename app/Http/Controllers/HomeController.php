<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Manager;
use App\Models\Teller;
use App\Models\TellerSubmission;
use App\Models\Marketing;
use App\Models\FinancingService;
use App\Models\FinancingServiceSubmission;
use App\Models\CustomerService;
use App\Models\CustomerServiceSubmission;
use App\Models\MarketingAssignment;
use Carbon\Carbon;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('timeoutses');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $teller = count(Teller::all());
        $marketing = count(Marketing::all());
        $customerService = count(CustomerService::all());
        $financingService = count(FinancingService::all());
        $manager = count(Manager::all());
        if (Auth::user()->role == 'admin') {
            $assignment = count(MarketingAssignment::all());
        } elseif (Auth::user()->role == 'manager') {
            $manager = Manager::where('user_id', Auth::user()->id)->first();
            $assignment = count(MarketingAssignment::where('manager_id', $manager->id)->get());
        } elseif (Auth::user()->role == 'customer_service') {
            $customer_service = CustomerService::where('user_id', Auth::user()->id)->first();
            $assignment = count(CustomerServiceSubmission::where('customer_service_id', $customer_service->id)->get());
        } elseif (Auth::user()->role == 'financing_service') {
            $financing_service = FinancingService::where('user_id', Auth::user()->id)->first();
            $assignment = count(FinancingServiceSubmission::where('financing_service_id', $financing_service->id)->get());
        } elseif (Auth::user()->role == 'teller') {
            $teller = Teller::where('user_id', Auth::user()->id)->first();
            $assignment = count(TellerSubmission::where('teller_id', $teller->id)->get());
        }
        elseif (Auth::user()->role == 'marketing') {
            $marketing = Marketing::where('user_id', Auth::user()->id)->first();
            $assignment = count(MarketingAssignment::where('marketing_id', $marketing->id)->get());
        }

        if (Auth::user()->role == 'admin') {
            $hot = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('ast.status', 'hot')
                ->count();

            $warm = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('ast.status', 'warm')
                ->count();

            $cold = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('ast.status', 'cold')
                ->count();

            $unqualified = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('ast.status', 'unqualified')
                ->count();

            $closed = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('ast.status', 'closed')
                ->count();
        } elseif (Auth::user()->role == 'manager') {
            $manager = Manager::where('user_id', Auth::user()->id)->first();
            $hot = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('ast.status', 'hot')
                ->where('mks.manager_id', $manager->id)
                ->count();

            $warm = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('ast.status', 'warm')
                ->where('mks.manager_id', $manager->id)
                ->count();

            $cold = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('ast.status', 'cold')
                ->where('mks.manager_id', $manager->id)
                ->count();

            $unqualified = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('ast.status', 'unqualified')
                ->where('mks.manager_id', $manager->id)
                ->count();

            $closed = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('ast.status', 'closed')
                ->where('mks.manager_id', $manager->id)
                ->count();
        } elseif (Auth::user()->role == 'customer_service') {
            $customer_service = CustomerService::where('user_id', Auth::user()->id)->first();
            $hot = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', '=', 'mks.status')
                ->join('customer_service_submissions as css', 'css.id', '=', 'mks.source_id')
                ->where('mks.source', '=', 'customer_service')
                ->where('ast.status', 'hot')
                ->where('css.customer_service_id', $customer_service->id)
                ->count();

            $warm = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('mks.source', '=', 'customer_service')
                ->where('ast.status', 'warm')
                ->join('customer_service_submissions as css', 'css.id', '=', 'mks.source_id')
                ->where('css.customer_service_id', $customer_service->id)
                ->count();

            $cold = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('mks.source', '=', 'customer_service')
                ->where('ast.status', 'cold')
                ->join('customer_service_submissions as css', 'css.id', '=', 'mks.source_id')
                ->where('css.customer_service_id', $customer_service->id)
                ->count();

            $unqualified = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('mks.source', '=', 'customer_service')
                ->where('ast.status', 'unqualified')
                ->join('customer_service_submissions as css', 'css.id', '=', 'mks.source_id')
                ->where('css.customer_service_id', $customer_service->id)
                ->count();

            $closed = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('mks.source', '=', 'customer_service')
                ->where('ast.status', 'closed')
                ->join('customer_service_submissions as css', 'css.id', '=', 'mks.source_id')
                ->where('css.customer_service_id', $customer_service->id)
                ->count();
        } elseif (Auth::user()->role == 'financing_service') {
            // dd('tes');
            $financing_service = FinancingService::where('user_id', Auth::user()->id)->first();
            $hot = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('mks.source', '=', 'financing_service')
                ->where('ast.status', 'hot')
                ->join('financing_service_submissions as fss', 'fss.id', '=', 'mks.source_id')
                ->where('fss.financing_service_id', $financing_service->id)
                ->count();
            $warm = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('mks.source', '=', 'financing_service')
                ->where('ast.status', 'warm')
                ->join('financing_service_submissions as fss', 'fss.id', '=', 'mks.source_id')
                ->where('fss.financing_service_id', $financing_service->id)
                ->count();

            $cold = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('mks.source', '=', 'financing_service')
                ->where('ast.status', 'cold')
                ->join('financing_service_submissions as fss', 'fss.id', '=', 'mks.source_id')
                ->where('fss.financing_service_id', $financing_service->id)
                ->count();

            $unqualified = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('mks.source', '=', 'financing_service')
                ->where('ast.status', 'unqualified')
                ->join('financing_service_submissions as fss', 'fss.id', '=', 'mks.source_id')
                ->where('fss.financing_service_id', $financing_service->id)
                ->count();

            $closed = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('mks.source', '=', 'financing_service')
                ->where('ast.status', 'closed')
                ->join('financing_service_submissions as fss', 'fss.id', '=', 'mks.source_id')
                ->where('fss.financing_service_id', $financing_service->id)
                ->count();
        } elseif (Auth::user()->role == 'teller') {
            $teller = Teller::where('user_id', Auth::user()->id)->first();
            $hot = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->join('teller_submissions as ts', 'ts.id', '=', 'mks.source_id')
                ->where('mks.source', '=', 'teller')
                ->where('ast.status', 'hot')
                ->where('ts.teller_id', $teller->id)
                ->count();

            $warm = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('mks.source', '=', 'teller')
                ->where('ast.status', 'warm')
                ->join('teller_submissions as ts', 'ts.id', '=', 'mks.source_id')
                ->where('ts.teller_id', $teller->id)
                ->count();

            $cold = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('mks.source', '=', 'teller')
                ->where('ast.status', 'cold')
                ->join('teller_submissions as ts', 'ts.id', '=', 'mks.source_id')
                ->where('ts.teller_id', $teller->id)
                ->count();

            $unqualified = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('mks.source', '=', 'teller')
                ->where('ast.status', 'unqualified')
                ->join('teller_submissions as ts', 'ts.id', '=', 'mks.source_id')
                ->where('ts.teller_id', $teller->id)
                ->count();

            $closed = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('mks.source', '=', 'teller')
                ->where('ast.status', 'closed')
                ->join('teller_submissions as ts', 'ts.id', '=', 'mks.source_id')
                ->where('ts.teller_id', $teller->id)
                ->count();
        }

        elseif (Auth::user()->role == 'marketing') {
            $marketing = Marketing::where('user_id', Auth::user()->id)->first();
            $hot = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('ast.status', 'hot')
                ->where('mks.marketing_id', $marketing->id)
                ->count();

            $warm = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('ast.status', 'warm')
                ->where('mks.marketing_id', $marketing->id)
                ->count();

            $cold = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('ast.status', 'cold')
                ->where('mks.marketing_id', $marketing->id)
                ->count();

            $unqualified = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('ast.status', 'unqualified')
                ->where('mks.marketing_id', $marketing->id)
                ->count();

            $closed = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->where('ast.status', 'closed')
                ->where('mks.marketing_id', $marketing->id)
                ->count();
        }

        return view('dashboard.home.index', compact('teller', 'marketing', 'customerService', 'financingService', 'manager', 'assignment','marketing', 'hot', 'warm', 'cold', 'closed', 'unqualified'));
    }

    public function getEditProfile()
    {
        $role = Auth::user()->role;
        $id = Auth::user()->id;
        return redirect('user/'.$role.'_edit/'.$id);
    }
}
