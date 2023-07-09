<?php

namespace App\Http\Controllers\Nasabah;

use Illuminate\Http\Request;
use App\Models\CustomerServiceSubmission;
use App\Models\User;
use App\Models\CustomerService;
use App\Models\Customer;
use App\Models\MarketingAssignment;
use App\Models\MarketingAssignmentService;
use App\Models\MarketingAssignmentActivities;
use App\Models\UserLog;
use Auth;
use Carbon\Carbon;
use DB;

class CustomerServiceSubmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('timeoutses');
    }

    public function index(Request $request)
    {
        $filterRequest = count($request->all());
        if(Auth::user()->role == 'customer_service'){
        $customer_service = CustomerService::where('user_id', Auth::user()->id)->first();
        }
        if ($filterRequest > 0) {
            if ($request->filter != 'all') {
                if ($request->filter == 'potential_category') {
                    if ($request->potential_category != null) {
                        $filter = DB::table('customer_service_submissions as css');
                        $filter->join('customers as cst', 'cst.id', '=', 'css.customer_id');
                        if(Auth::user()->role == 'customer_service'){
                            $filter->where('css.customer_service_id', $customer_service->id);
                        }
                        $filter ->where('css.potential_category',$request->potential_category);
                        $filter ->select('cst.name as nama_nasabah', 'css.service', 'cst.type as tipe_nasabah', 'cst.category as  kategori_nasabah', 'css.potential_category', 'css.id'
                            ,'css.created_at');
                        $filter->orderBy('css.created_at','DESC');
                        $data = $filter->get();
                        return view('dashboard.user.nasabah.customer_service_index_filter', compact('data'));
                    }
                }
                if ($request->filter == 'tipe') {
                    if ($request->tipe != null) {
                        $filter = DB::table('customer_service_submissions as css');
                        $filter->join('customers as cst', 'cst.id', '=', 'css.customer_id');
                        if(Auth::user()->role == 'customer_service'){
                        $filter ->where('css.customer_service_id', $customer_service->id);
                        }
                        $filter->where('cst.type',$request->tipe);
                        $filter->select('cst.name as nama_nasabah', 'css.service', 'cst.type as tipe_nasabah', 'cst.category as  kategori_nasabah', 'css.potential_category', 'css.id','css.created_at');
                        $filter->orderBy('css.created_at','DESC');
                        $data = $filter->get();
                        return view('dashboard.user.nasabah.customer_service_index_filter', compact('data'));
                    }
                }
            } else {
                $filter = DB::table('customer_service_submissions as css');
                $filter->join('customers as cst', 'cst.id', '=', 'css.customer_id');
                if(Auth::user()->role == 'customer_service'){
                $filter ->where('css.customer_service_id', $customer_service->id);
                }
                $filter->select('cst.name as nama_nasabah', 'css.service', 'cst.type as tipe_nasabah', 'cst.category as  kategori_nasabah', 'css.potential_category', 'css.id','css.created_at');
                $filter->orderBy('css.created_at','DESC');
                $data = $filter->get();
                return view('dashboard.user.nasabah.customer_service_index_filter', compact('data'));
            }
        }
        if ($request->type) {
            $filter = DB::table('marketing_assignments as mks');
            $filter->where('mks.source', 'customer_service');
            $filter->join('customer_service_submissions as css', 'css.id', '=', 'mks.source_id');
            $filter->join('customers as cst', 'cst.id', '=', 'css.customer_id');
            $filter->leftjoin('action_status as ast', 'ast.id', '=', 'mks.status');
            $filter->where('ast.status', $request->type);
            if(Auth::user()->role == 'customer_service'){
            $filter->where('css.customer_service_id', $customer_service->id);
            }
            $filter->select('cst.name as nama_nasabah', 'css.service', 'cst.type as tipe_nasabah', 'cst.category as  kategori_nasabah', 'css.potential_category', 'mks.id','css.created_at');
            $filter ->orderBy('mks.created_at','DESC');
            $data = $filter->get();
            return view('dashboard.user.nasabah.customer_service_index_filter', compact('data'));
        } else {
            if (Auth::user()->role=='customer_service') {
                $filter = DB::table('customer_service_submissions as css');
                $filter->join('customers as cst', 'cst.id', '=', 'css.customer_id');
                $filter->where('css.customer_service_id', $customer_service->id);
                $filter->select('cst.name as nama_nasabah', 'css.service', 'cst.type as tipe_nasabah', 'cst.category as  kategori_nasabah', 'css.potential_category', 'css.id','css.created_at');
                $filter->orderBy('css.created_at','DESC');
                $data = $filter->get();
                return view('dashboard.user.nasabah.customer_service_index_filter', compact('data'));
            } else {
                $data = CustomerServiceSubmission::orderBy('created_at', 'DESC')->get();
                return view('dashboard.user.nasabah.customer_service_index', compact('data'));
            }
            $filter->select(
                'mks.id',
                //'mks.manager_id',
                'mks.source',
                'cts.name as nama_nasabah',
                'mkg.name as nama_marketing',
                'cts.type',
                'art.potential_category as jenis',
                'ast.status',
               // DB::Raw('IFNULL(ast.status , "Perlu difollow up" ) as status'),
                'css.created_at'
            );
            $data = $filter->get();
            return view('dashboard.user.nasabah.customer_service_index_filter', compact('data'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('dashboard.user.nasabah.customer_service_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = Customer::create([
            'name' =>$request->name,
            'date_birth'=>$request->date_birth,
            'address'=>$request->address,
            'phone'  =>$request->phone,
            'whatsapp' =>$request->whatsapp,
            'email'   =>$request->email,
            'profession' =>$request->profession,
            'job_status'=>$request->job_status,
            'company_name'  =>$request->company_name,
            'position' =>$request->position,
            'income_per_month'   =>$request->income_per_month,
            'category' =>$request->category,
            'type'  =>$request->type,
        ]);

        $customer_service = CustomerService::where('user_id', Auth::user()->id)->first();
        $customer_service_submission = CustomerServiceSubmission::create([
            'customer_service_id' =>$customer_service->id,
            'customer_id' =>$customer->id,
            'date_submit' =>Carbon::now('Asia/Jakarta')->format('Y-m-d'),
            'service' =>$request->service,
            'original_account' =>0,
            'destination_account'=>0,
            //'amount' =>$request->amount,
            'merchant_id' =>0,
            //'allocation' =>$request->allocation,
            'potential_category' =>$request->potential_category,
            'potential_description' =>$request->potential_description,
        ]);

        if ($customer_service_submission) {
            $type='create';
            $name=Auth::user()->name;
            $content=' Customer Service Submission '.$request->name.' ';
            $ip=$request->ip();
            UserLog::log($type, $name, $content, $ip);
            return redirect('layanan/customer_service_submission_index')->with(['success'=>'data berhasil disimpan']);
        } else {
            return redirect()->back()->with(['error'=>'data error disimpan']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = CustomerServiceSubmission::where('id', $id)->first();
        return view('dashboard.user.nasabah.customer_service_edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customer_service_submission = CustomerServiceSubmission::where('id', $id)->update([
            'date_submit' =>Carbon::now('Asia/Jakarta')->format('Y-m-d'),
            'service' =>$request->service,
            'original_account' =>0,
            'destination_account'=>0,
            'amount' =>0,
            'merchant_id' =>0,
            'potential_category' =>$request->potential_category,
            'potential_description' =>$request->potential_description,
        ]);
        $customer_service_submission_get = CustomerServiceSubmission::where('id', $id)->first();
        $customer = Customer::where('id', $customer_service_submission_get->customer_id)->update([
            'name' =>$request->name,
            'date_birth'=>$request->date_birth,
            'phone'  =>$request->phone,
            'whatsapp' =>$request->whatsapp,
            'email'   =>$request->email,
            'address'   =>$request->address,
            'profession' =>$request->profession,
            'job_status'=>$request->job_status,
            'company_name'  =>$request->company_name,
            'position' =>$request->position,
            'income_per_month'   =>$request->income_per_month,
            'category' =>$request->category,
            'type'  =>$request->type,
        ]);
        if ($customer_service_submission) {
            $type='update';
            $name=Auth::user()->name;
            $content=' Customer Service Submission '.$request->name.' ';
            $ip=$request->ip();
            UserLog::log($type, $name, $content, $ip);
            return redirect('layanan/customer_service_submission_index')->with(['success'=>'data berhasil diupdate']);
        } else {
            return redirect()->back()->with(['error'=>'data gagal diupdate']);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer_service_submission = CustomerServiceSubmission::where('id', $id)->first();
        $customer = Customer::find($customer_service_submission->customer_id);
        //proses delete
        if ($customer_service_submission) {
            $cekAssignment = MarketingAssignment::where('source', 'customer_service')->where('source_id', $id)->first();
            if ($cekAssignment) {
                MarketingAssignmentActivities::where('assignment_id', $cekAssignment->id)->delete();
                MarketingAssignment::where('id', $cekAssignment->id)->delete();
            }
            CustomerServiceSubmission::where('id', $id)->delete();
        }

        if ($customer) {
            Customer::find($customer_service_submission->customer_id)->delete();
        }

        if ($customer) {
            $type='delete';
            $name=Auth::user()->name;
            $content='Teller User '.$customer->name.' ';
            $ip=$_SERVER['REMOTE_ADDR'];

            UserLog::log($type, $name, $content, $ip);
            return redirect()->back()->with(['success'=>'data berhasil dihapus']);
        } else {
            return redirect()->back()->with(['gagal'=>'data gagal dihapus']);
        }
    }
}
