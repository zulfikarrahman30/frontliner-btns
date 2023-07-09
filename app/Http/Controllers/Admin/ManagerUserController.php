<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Manager;
use App\Models\Marketing;
use App\Models\MarketingAssignment;
use App\Models\MarketingAssignmentActivities;
use App\Models\CustomerServiceSubmission;
use App\Models\FinancingServiceSubmission;
use App\Models\TellerSubmission;
use App\Models\Customer;
use App\Models\User;
use App\Models\UserLog;
use Carbon\Carbon;
use DB;
use Auth;

class ManagerUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('timeoutses');
    }

    public function assignment_create()
    {
        $customerAssignedByTeller = MarketingAssignment::where('source', 'teller')->get();
        $customerAssignedByCustomerService = MarketingAssignment::where('source', 'customer_service')->get();
        $customerAssignedByFinancingService = MarketingAssignment::where('source', 'financing_service')->get();
        $tmpCustomerIdCs = [];
        $tmpCustomerIdFcS = [];
        $tmpCustomerIdTeller = [];
        foreach ($customerAssignedByCustomerService as $item) {
            array_push($tmpCustomerIdCs, $item->source_id);
        }
        foreach ($customerAssignedByFinancingService as $item) {
            array_push($tmpCustomerIdFcS, $item->source_id);
        }
        foreach ($customerAssignedByTeller as $item) {
            array_push($tmpCustomerIdTeller, $item->source_id);
        }
        $customerAssignedByTellerGet = TellerSubmission::whereNotIn('id', $tmpCustomerIdTeller)->get();
        $customerAssignedByCustomerServiceGet = CustomerServiceSubmission::whereNotIn('id', $tmpCustomerIdCs)->get();
        $customerAssignedByFinancingServiceGet = FinancingServiceSubmission::whereNotIn('id', $tmpCustomerIdFcS)->get();
        $arrCsId = [];
        foreach ($customerAssignedByCustomerServiceGet as $item) {
            array_push($arrCsId, $item->customer_id);
        }
        foreach ($customerAssignedByFinancingServiceGet as $item) {
            array_push($arrCsId, $item->customer_id);
        }
        foreach ($customerAssignedByTellerGet as $item) {
            array_push($arrCsId, $item->customer_id);
        }
        // dd($customerAssignedByFinancingServiceGet);
        $marketing = Marketing::orderBy('created_at', 'DESC')->get();
        $nasabah = Customer::whereIn('id', $arrCsId)->get();
        return view('dashboard.user.admin.manager.assignment', compact('marketing', 'nasabah'));
    }

    public function assignment(Request $request)
    {
        $filterRequest = count($request->all());
        $arrRelation = [
            'teller'=>'teller_submissions'
            ,'financing_service'=>'financing_service_submissions'
            ,'customer_service'=>'customer_service_submissions'
        ];
        $data = [];
        $cnb = DB::table('marketing_assignments')->get();
        $manager = Manager::where('user_id', Auth::user()->id)->first();
        if (!$cnb->isEmpty()) {
            foreach ($cnb as $key => $value) {
                $nasabah = [];
                $filter = DB::table('marketing_assignments as mks');
                $filter->leftjoin('action_status as ast', 'ast.id', 'mks.status');
                $filter->join(''.$arrRelation[$value->source].' as art', 'art.id', '=', 'mks.source_id');
                $filter->join('customers as cts', 'cts.id', '=', 'art.customer_id');
                $filter->join('marketings as mkg', 'mkg.id', '=', 'mks.marketing_id');
                $filter->where('mks.id', $value->id);
                if (Auth::user()->role=='manager') {
                    $filter->where('mks.manager_id', $manager->id);
                }

                if ($filterRequest > 0) {
                    if ($request->filter != 'all') {
                        if ($request->filter == 'sumber_data') {
                            if ($request->sumber_data != null) {
                                $filter->where('mks.source', $request->sumber_data);
                            }
                        }
                        if ($request->filter == 'potential_category') {
                            if ($request->potential_category != null) {
                                $filter->where('art.potential_category', $request->potential_category);
                            }
                        }
                        if ($request->filter == 'tipe') {
                            if ($request->tipe != null) {
                                $filter->where('cts.type', $request->tipe);
                            }
                        }
                    }
                }
                if ($request->type) {
                    $filter->where('ast.status', $request->type);
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
                    'mks.created_at'
                );
                $filter->orderBy('mks.created_at', 'DESC');
                $dataNewNasabah = $filter->first();

                if ($dataNewNasabah) {
                    $nasabah = json_decode(json_encode($dataNewNasabah), true);
                    $tanggal = Carbon::parse($nasabah['created_at'])->format('m/d/Y');
                    $jam = Carbon::parse($nasabah['created_at'])->format('g:i A');
                    $fixTime = 'Created at '.$jam.' '.$tanggal;
                    $nasabah['created_at'] = $fixTime;
                    array_push($data, $nasabah);
                }
            }
        }
        //dd($data);
        $this->array_sort_by_column($data, 'created_at');
        // dd($data);
        return view('dashboard.user.admin.manager.listnasabah', compact('data'));
    }

    public function getHistoryAssigment($id)
    {
        $nasabah = null;
        $arrRelationTable = [
            'teller' => 'teller_submissions', 'financing_service' => 'financing_service_submissions', 'customer_service' => 'customer_service_submissions'
        ];
        $cnb = DB::table('marketing_assignments')->where('id', $id)
            ->select('source')->orderBy('created_at', 'DESC')
            ->first();
        $marketing = null;
        if ($cnb) {
            $dataNewNasabah = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->join('' . $arrRelationTable[$cnb->source] . ' as art', 'art.id', '=', 'mks.source_id')
                ->join('customers as cts', 'cts.id', '=', 'art.customer_id')
                ->where('mks.id', $id)
                ->select(
                    'mks.id',
                    //'mks.marketing_id',
                    'cts.name as nama_nasabah',
                    'art.potential_category as jenis',
                    DB::Raw('IFNULL( ast.status , "Perlu difollow up" ) as status'),
                    'cts.whatsapp as whatsapp',
                    'cts.phone as phone',
                    'cts.email as email',
                    'mks.marketing_id as bookmark',
                    'mks.created_at'
                )
                ->orderBy('created_at', 'DESC')
                ->first();
            if ($dataNewNasabah) {
                
                $nasabah = json_decode(json_encode($dataNewNasabah), true);
                $tanggal = Carbon::parse($nasabah['created_at'])->format('m/d/Y');
                $jam = Carbon::parse($nasabah['created_at'])->format('g:i A');
                $fixTime = 'Created at ' . $jam . ' ' . $tanggal;
                $nasabah['created_at'] = $fixTime;

                //phone
                $takeWa = str_split($nasabah['whatsapp']);
                if ($takeWa[0] == 0) {
                    unset($takeWa[0]);
                    $fixWa = '62' . implode('', $takeWa);
                } else {
                    $fixWa = implode('', $takeWa);
                }
                $nasabah['whatsapp'] = 'https://wa.me/' . $fixWa;
                $nasabah['email'] = 'mailto:' . $nasabah['email'];
                //endphone
                //boomark check

                $data = DB::table('marketings as mk')
                    ->where('mk.id', $nasabah['bookmark'])
                    ->join('users as us','us.id','=','mk.user_id')
                    ->select('mk.*','us.email')
                    ->first();
                $nasabah['bookmark'] = false;
                if ($data) {
                    $marketing = json_decode(json_encode($data), true);
                    $tmp = explode(',', $data->bookmark_assignment);
                    if (in_array($nasabah['id'], $tmp)) {
                        $nasabah['bookmark'] = true;
                    }
                }
                //end bookmark check
            }

            $url = url('admin/image/attachment');
            $riwayat = DB::table('marketing_assignment_activities as maa')
                ->join('action_status as ast', 'ast.id', '=', 'maa.status')
                ->where('assignment_id', $id)
                ->select(
                    'ast.action as kategori',
                    'ast.status',
                    DB::raw("CONCAT('$url/', maa.attachment) as attachment"),
                    'maa.title',
                    'maa.date_submit',
                    'maa.created_at',
                    'maa.note',
                    'maa.attachment as image'
                )
                ->orderBy('maa.created_at', 'DESC')
                ->get();
            $history = [];
            $riwayatTemp = json_decode(json_encode($riwayat), true);
            foreach ($riwayatTemp as $key => $value) {
                $status = $value['kategori'] . ' - ' . $value['status'];
                $history[$key]['status'] = $status;
                $history[$key]['tanggal'] = Carbon::parse($value['date_submit'])->format('m/d/Y');
                $history[$key]['jam'] = Carbon::parse($value['created_at'])->format('H:i:s');
                $history[$key]['title'] = $value['title'];
                $history[$key]['note'] = $value['note'];
                $history[$key]['attachment'] = $value['attachment'];
                $history[$key]['image'] = $value['image'];
            }
        }
        $urlMarketing = url('admin/image/profile/marketing');
        //dd($history);
        $masterStatus = DB::table('action_status')->select('id', 'action as kategori', 'status')->get();
        return view('dashboard.user.admin.manager.history', compact('id','history','nasabah','marketing','urlMarketing','masterStatus'));
    }

    public function array_sort_by_column(&$arr, $col, $dir = SORT_DESC)
    {
        $sort_col = array();
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col];
        }

        array_multisort($sort_col, $dir, $arr);
    }

    public function find_source_customer($id)
    {
        $result = null;
        $customerAssignedByTellerGet = TellerSubmission::where('customer_id', $id)->first();
        if ($customerAssignedByTellerGet) {
            $result['data'] = $customerAssignedByTellerGet;
            $result['type'] = 'teller';
        }
        $customerAssignedByCustomerServiceGet = CustomerServiceSubmission::where('customer_id', $id)->first();
        if ($customerAssignedByCustomerServiceGet) {
            $result['data'] = $customerAssignedByCustomerServiceGet;
            $result['type'] = 'customer_service';
        }
        $customerAssignedByFinancingServiceGet = FinancingServiceSubmission::where('customer_id', $id)->first();
        if ($customerAssignedByFinancingServiceGet) {
            $result['data'] = $customerAssignedByFinancingServiceGet;
            $result['type'] = 'financing_service';
        }
        return $result;
    }

    public function assignment_store(Request $request)
    {
        $manager = Manager::where('user_id', Auth::user()->id)->first();
        if($manager)
        {
            $source = $this->find_source_customer($request->customer_id);
            if ($source != null) {
                MarketingAssignment::create([
                    'source' =>$source['type'],
                    'source_id'  =>$source['data']->id,
                    'marketing_id' =>$request->marketing_id,
                    'manager_id'   =>$manager->id
                ]);
            }

            if ($source != null) {
                $type='create';
                $name=Auth::user()->name;
                $content='Marketing Assignment '.$request->name.' ';
                $ip=$request->ip();
                UserLog::log($type, $name, $content, $ip);
                return redirect('layanan/assignment_index')->with(['success'=>'data berhasil disimpan']);
            } else {
                return redirect()->back()->with(['error'=>'data error disimpan']);
            }
        }else{
            if(!Auth::check())
            {   
                return redirect('login')->with(['error'=>'Harap login kembali dengan role manager!']);
            }else{
                return redirect('/')->with(['error'=>'anda tidak memiliki akses untuk layanan ini karena role anda adalah '.Auth::user()->role.' ']);
            }
        }
        
    }

    public function assignment_update(Request $request, $id)
    {
        $source = $this->find_source_customer($request->customer_id);
        $manager = Manager::where('user_id', Auth::user()->id)->first();

        if ($source != null) {
            MarketingAssignment::where('id', $id)->update([
                'source' =>$source['type'],
                'source_id'  =>$source['data']->id,
                'marketing_id' =>$request->marketing_id,
                'manager_id'   =>$manager->id
            ]);
        }

        if ($source != null) {
            $type='update';
            $name=Auth::user()->name;
            $content='Marketing Assignment '.$request->name.' ';
            $ip=$request->ip();
            UserLog::log($type, $name, $content, $ip);
            return redirect('layanan/assignment_index')->with(['success'=>'data berhasil diperbarui']);
        } else {
            return redirect()->back()->with(['error'=>'data tidak dapat diperbarui']);
        }
    }

    public function find_source_customer_id($data)
    {
        $result = null;
        if ($data) {
            if ($data->source == 'teller') {
                $result = TellerSubmission::where('id', $data->source_id)->first();
            } elseif ($data->source == 'customer_service') {
                $result = CustomerServiceSubmission::where('id', $data->source_id)->first();
            } else {
                $result = FinancingServiceSubmission::where('id', $data->source_id)->first();
            }
        }
        return $result;
    }

    public function assignment_edit($id)
    {
        $data = MarketingAssignment::find($id);
        $data_assignment = $this->find_source_customer_id($data);
        $customerAssignedByTeller = MarketingAssignment::where('source', 'teller')->get();
        $customerAssignedByCustomerService = MarketingAssignment::where('source', 'customer_service')->get();
        $customerAssignedByFinancingService = MarketingAssignment::where('source', 'financing_service')->get();
        $tmpCustomerIdCs = [];
        $tmpCustomerIdFcS = [];
        $tmpCustomerIdTeller = [];
        foreach ($customerAssignedByCustomerService as $item) {
            array_push($tmpCustomerIdCs, $item->source_id);
        }
        foreach ($customerAssignedByFinancingService as $item) {
            array_push($tmpCustomerIdFcS, $item->source_id);
        }
        foreach ($customerAssignedByTeller as $item) {
            array_push($tmpCustomerIdTeller, $item->source_id);
        }
        $customerAssignedByTellerGet = TellerSubmission::whereNotIn('id', $tmpCustomerIdTeller)->get();
        $customerAssignedByCustomerServiceGet = CustomerServiceSubmission::whereNotIn('id', $tmpCustomerIdCs)->get();
        $customerAssignedByFinancingServiceGet = FinancingServiceSubmission::whereNotIn('id', $tmpCustomerIdFcS)->get();
        $arrCsId = [];
        foreach ($customerAssignedByCustomerServiceGet as $item) {
            array_push($arrCsId, $item->customer_id);
        }
        foreach ($customerAssignedByFinancingServiceGet as $item) {
            array_push($arrCsId, $item->customer_id);
        }
        foreach ($customerAssignedByTellerGet as $item) {
            array_push($arrCsId, $item->customer_id);
        }
        array_push($arrCsId, $data_assignment->customer_id);
        // dd($customerAssignedByFinancingServiceGet);
        $marketing = Marketing::orderBy('created_at', 'DESC')->get();
        $nasabah = Customer::whereIn('id', $arrCsId)->get();
        //dd($nasabah);
        return view('dashboard.user.admin.manager.assignment_edit', compact('data', 'data_assignment', 'marketing', 'nasabah'));
    }

    public function assignment_destroy($id)
    {
        $data = MarketingAssignment::find($id)->delete();
        $activity = MarketingAssignmentActivities::where('assignment_id', $id)->delete();

        if ($data) {
            $type='delete';
            $name=Auth::user()->name;
            $content='Marketing Assignment '.$id.' ';
            $ip=$_SERVER['REMOTE_ADDR'];

            UserLog::log($type, $name, $content, $ip);
            return redirect()->back()->with(['success'=>'data berhasil dihapus']);
        } else {
            return redirect()->back()->with(['gagal'=>'data gagal dihapus']);
        }
    }

    public function index()
    {
        $data = Manager::orderBy('created_at', 'DESC')->get();
        return view('dashboard.user.admin.manager.index', compact('data'));
    }

    public function uploadFile(Request $request, $oke)
    {
        $result ='';
        $file = $request->file($oke);
        $name = $file->getClientOriginalName();
        $extension = explode('.', $name);
        $extension = strtolower(end($extension));
        $key = rand().'-'.$oke.'-manager';
        $tmp_file_name = "{$key}.{$extension}";
        $tmp_file_path = "admin/image/profile/manager";
        $file->move($tmp_file_path, $tmp_file_name);
        $result = $tmp_file_name;
        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('dashboard.user.admin.manager.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cek = User::where('email', $request->email)->first();
        if ($cek) {
            return redirect()->back()->with(['error'=>'data error di simpan , email '.$request->email.' sudah terdaftar']);
        }

        $user = User::create([
            'name' =>$request->name,
            'role'  =>'manager',
            'email' =>$request->email,
            'password'   =>bcrypt($request->password),
        ]);
        $photo = 'none.jpg';
        if ($request->file('photo')!= null) {
            $photo = $request->file('photo');
            $format = strtolower($photo->getClientOriginalExtension());
            $arr = ['jpg','png','jpeg'];
            if (!in_array($format, $arr)) {
                return redirect()->back()->with(['gagal'=>'Format Gambar Salah !']);
            }
            $photo = $this->uploadFile($request, 'photo');
        }
        $manager = Manager::create([
            'user_id' =>$user->id,
            'name' =>$request->name,
            'photo' =>$photo,
            'phone' =>$request->phone
    ]);

        if ($manager) {
            $type='create';
            $name=Auth::user()->name;
            $content='Manager User '.$request->name.' ';
            $ip=$request->ip();
            UserLog::log($type, $name, $content, $ip);
            return redirect('user/manager_index')->with(['success'=>'data berhasil disimpan']);
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
        $data = Manager::where('user_id', $id)->first();
        return view('dashboard.user.admin.manager.edit', compact('data'));
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
        $user = User::where('id', $id)->update([
            'name' =>$request->name,
            'role'  =>'manager',
            'email' =>$request->email
        ]);

        if ($request->file('photo')!= null) {
            $cek = Manager::where('user_id', $id)->first();
            if ($cek) {
                $photo = $request->file('photo');
                $format = strtolower($photo->getClientOriginalExtension());
                $arr = ['jpg','png','jpeg'];
                if (!in_array($format, $arr)) {
                    return redirect()->back()->with(['gagal'=>'Format Gambar Salah !']);
                }
                $photo = $this->uploadFile($request, 'photo');

                $manager = Manager::where('user_id', $id)->update([
                    'photo' =>$photo,
                    'name' =>$request->name,
                    'phone'=>$request->phone
                ]);
            } else {
                $photo = $request->file('photo');
                $format = $photo->getClientOriginalExtension();
                $format = strtolower($photo->getClientOriginalExtension());
                $arr = ['jpg','png','jpeg'];
                if (!in_array($format, $arr)) {
                    return redirect()->back()->with(['gagal'=>'Format Gambar Salah !']);
                }
                $photo = $this->uploadFile($request, 'photo');
                $manager = Manager::create([
                    'user_id' =>$id,
                    'photo' =>$photo,
                    'name' =>$request->name,
                    'phone'=>$request->phone
                ]);
            }
        } else {
            $manager = Manager::where('user_id', $id)->update([
                'name' =>$request->name,
                'phone'=>$request->phone
            ]);
        }

        if ($manager) {
            $type='update';
            $name=Auth::user()->name;
            $content='Manager User '.$request->name.' ';
            $ip=$request->ip();
            UserLog::log($type, $name, $content, $ip);
            if(Auth::user()->role == 'admin'){
               return redirect('user/manager_index')->with(['success'=>'data berhasil diupdate']);
            }
            return redirect('/home')->with(['success'=>'data berhasil diupdate']);
        } else {
            return redirect()->back()->with(['error'=>'data error diupdate']);
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
        $user = User::find($id);
        $manager = Manager::where('user_id', $id)->first();

        //proses delete
        if ($manager) {
            Manager::where('user_id', $id)->delete();
        }
        if ($user) {
            User::find($id)->delete();
        }

        if ($user) {
            $type='delete';
            $name=Auth::user()->name;
            $content='Manager User '.$user->name.' ';
            $ip=$_SERVER['REMOTE_ADDR'];

            UserLog::log($type, $name, $content, $ip);
            return redirect()->back()->with(['success'=>'data berhasil dihapus']);
        } else {
            return redirect()->back()->with(['gagal'=>'data gagal dihapus']);
        }
    }

    public function klasifikasi(Request $request){
        $customer_service = CustomerServiceSubmission::orderBy('created_at', 'DESC')->get();
        $financing_service = FinancingServiceSubmission::orderBy('created_at', 'DESC')->get();
        $teller = TellerSubmission::orderBy('created_at', 'DESC')->get();
        return view('dashboard.user.admin.manager.klasifikasi',compact('request','customer_service','financing_service','teller'));
        

    }
}
