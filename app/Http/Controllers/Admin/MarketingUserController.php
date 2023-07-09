<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Marketing;
use App\Models\User;
use App\Models\UserLog;
use App\Models\MarketingAssignment;
use App\Models\MarketingAssignmentActivities;
use App\Models\CustomerServiceSubmission;
use App\Models\FinancingServiceSubmission;
use App\Models\TellerSubmission;
use App\Models\Customer;
use DB;
use Auth;
use Carbon\Carbon;

class MarketingUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('timeoutses');
    }

    public function index()
    {
        $data = Marketing::orderBy('created_at', 'DESC')->get();
        return view('dashboard.user.admin.marketing.index', compact('data'));
    }

    public function uploadFile(Request $request, $oke)
    {
        $result = '';
        $file = $request->file($oke);
        $name = $file->getClientOriginalName();
        $extension = explode('.', $name);
        $extension = strtolower(end($extension));
        $key = rand() . '-' . $oke . '-marketing';
        $tmp_file_name = "{$key}.{$extension}";
        $tmp_file_path = "admin/image/profile/marketing";
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
        return view('dashboard.user.admin.marketing.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $marketing = false;
        $cek = User::where('email', $request->email)->first();
        if ($cek) {
            return redirect()->back()->with(['error' => 'data error di simpan , email ' . $request->email . ' sudah terdaftar']);
        }

        $user = User::create([
            'name' => $request->name,
            'role'  => 'Marketing',
            'email' => $request->email,
            'password'   => bcrypt($request->password),
        ]);
        $photo = 'none.jpg';
        if ($request->file('photo') != null) {
            $photo = $request->file('photo');
            $format = strtolower($photo->getClientOriginalExtension());
            $arr = ['jpg', 'png', 'jpeg'];
            if (!in_array($format, $arr)) {
                return redirect()->back()->with(['gagal' => 'Format Gambar Salah !']);
            }
            $photo = $this->uploadFile($request, 'photo');
        }
        $marketing = Marketing::create([
            'user_id' => $user->id,
            'type' => $request->type,
            'name' => $request->name,
            'photo' => $photo,
            'phone' => $request->phone
        ]);


        if ($marketing) {
            $type = 'create';
            $name = Auth::user()->name;
            $content = 'Marketing User ' . $request->name . ' ';
            $ip = $request->ip();
            UserLog::log($type, $name, $content, $ip);
            return redirect('user/marketing_index')->with(['success' => 'data berhasil disimpan']);
        } else {
            return redirect()->back()->with(['error' => 'data error disimpan']);
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
        $data = Marketing::where('user_id', $id)->first();
        return view('dashboard.user.admin.marketing.edit', compact('data'));
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
        if($request->password)
        {
            $user = User::where('id', $id)->update([
                'name' => $request->name,
                'role'  => 'Marketing',
                'email' => $request->email,
                'password'=>bcrypt($request->password)
            ]);
        }else{
            $user = User::where('id', $id)->update([
                'name' => $request->name,
                'role'  => 'Marketing',
                'email' => $request->email
            ]);
        }
        if ($request->file('photo') != null) {
            $cek = Marketing::where('user_id', $id)->first();
            if ($cek) {
                $photo = $request->file('photo');
                $format = strtolower($photo->getClientOriginalExtension());
                $arr = ['jpg', 'png', 'jpeg'];
                if (!in_array($format, $arr)) {
                    return redirect()->back()->with(['gagal' => 'Format Gambar Salah !']);
                }
                $photo = $this->uploadFile($request, 'photo');

                $marketing = Marketing::where('user_id', $id)->update([
                    'photo' => $photo,
                    'name' => $request->name,
                    'phone' => $request->phone
                ]);
            } else {
                $photo = $request->file('photo');
                $format = strtolower($photo->getClientOriginalExtension());
                $arr = ['jpg', 'png', 'jpeg'];
                if (!in_array($format, $arr)) {
                    return redirect()->back()->with(['gagal' => 'Format Gambar Salah !']);
                }
                $photo = $this->uploadFile($request, 'photo');
                $marketing = Marketing::create([
                    'user_id' => $id,
                    'photo' => $photo,
                    'name' => $request->name,
                    'phone' => $request->phone
                ]);
            }
        } else {
            $marketing = Marketing::where('user_id', $id)->update([
                'name' => $request->name,
                'phone' => $request->phone
            ]);
        }

        if ($marketing) {
            $type = 'update';
            $name = Auth::user()->name;
            $content = 'Marketing User ' . $request->name . ' ';
            $ip = $request->ip();
            UserLog::log($type, $name, $content, $ip);
            if(Auth::user()->role == 'admin'){
               return redirect('user/marketing_index')->with(['success' => 'data berhasil diupdate']);
            }
            return redirect('/home')->with(['success'=>'data berhasil diupdate']);
        } else {
            return redirect()->back()->with(['error' => 'data error diupdate']);
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
        $marketing = Marketing::where('user_id', $id)->first();

        //proses delete
        if ($marketing) {
            Marketing::where('user_id', $id)->delete();
        }
        if ($user) {
            User::find($id)->delete();
        }

        if ($user) {
            $type = 'delete';
            $name = Auth::user()->name;
            $content = 'Marketing User ' . $user->name . ' ';
            $ip = $_SERVER['REMOTE_ADDR'];

            UserLog::log($type, $name, $content, $ip);
            return redirect()->back()->with(['success' => 'data berhasil dihapus']);
        } else {
            return redirect()->back()->with(['gagal' => 'data gagal dihapus']);
        }
    }

    public function marketing_assignment(Request $request)
    {
        $filterRequest = count($request->all());
        $arrRelation = [
            'teller' => 'teller_submissions', 'financing_service' => 'financing_service_submissions', 'customer_service' => 'customer_service_submissions'
        ];
        $data = [];
        $cnb = DB::table('marketing_assignments')->get();
        $marketing = Marketing::where('user_id', Auth::user()->id)->first();
        if (!$cnb->isEmpty()) {
            foreach ($cnb as $key => $value) {
                $nasabah = [];
                $filter = DB::table('marketing_assignments as mks');
                $filter->leftjoin('action_status as ast', 'ast.id', 'mks.status');
                $filter->join('' . $arrRelation[$value->source] . ' as art', 'art.id', '=', 'mks.source_id');
                $filter->join('customers as cts', 'cts.id', '=', 'art.customer_id');
                $filter->join('marketings as mkg', 'mkg.id', '=', 'mks.marketing_id');
                $filter->where('mks.id', $value->id);
                if (Auth::user()->role == 'marketing') {
                    $filter->where('mks.marketing_id', $marketing->id);
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
                    'mks.source',
                    'cts.name as nama_nasabah',
                    'mkg.name as nama_marketing',
                    'cts.type',
                    'art.potential_category as jenis',
                     DB::Raw('IFNULL(ast.status , "Perlu difollow up" ) as status'),
                    'mks.created_at'
                );
                $filter->orderBy('mks.created_at', 'DESC');
                $dataNewNasabah = $filter->first();

                if ($dataNewNasabah) {
                    $nasabah = json_decode(json_encode($dataNewNasabah), true);
                    $tanggal = Carbon::parse($nasabah['created_at'])->format('m/d/Y');
                    $jam = Carbon::parse($nasabah['created_at'])->format('g:i A');
                    $fixTime = 'Created at ' . $jam . ' ' . $tanggal;
                    $nasabah['created_at'] = $fixTime;
                    array_push($data, $nasabah);
                }
            }
        }
        //dd($data);
        $this->array_sort_by_column($data, 'created_at');
        // dd($data);
        return view('dashboard.user.admin.marketing.marketing_assignment_index', compact('data'));
    }

    public function submitActivity(Request $request)
    {
        $png = $request->file('attachment');    
        $format = strtolower($png->getClientOriginalExtension());
        $arr = ['png','jpg','jpeg'];
            if(!in_array($format,$arr)) {
                return redirect()->back()->with(['gagal'=>'Format Gambar Harus Menggunakan PNG, JPG atau JPEG !']);
            }

        $attachment = $this->uploadFileAttach($request, 'attachment');
        $result = [];
        //insert
        DB::table('marketing_assignment_activities')->insert([
            'assignment_id' => $request->id,
            'title' => $request->title,
            'date_submit' =>$request->date_submit,
            'note' => $request->note,
            'attachment' => $attachment,
            'status' => $request->status,
            'created_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString()
        ]);
        DB::table('marketing_assignments')->where('id', $request->id)->update([
            'status' => $request->status,
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString()
        ]);

        return redirect()->back()->with(['success' => 'data berhasil ditambahkan']);
    }

    public  function uploadFileAttach($request, $oke)
    {
        $result = null;
        if ($request->file($oke) != null) {
            $file = $request->file($oke);
            $name = $file->getClientOriginalName();
            $extension = explode('.', $name);
            $extension = strtolower(end($extension));
            $key = rand() . '-' . $oke . '-attachment';
            $tmp_file_name = "{$key}.{$extension}";
            $path = $request->file($oke)->getPathName();
            $tmp_file_path = "admin/image/" . $oke . "";
            $quality = 60;
            $source = $tmp_file_path . '/' . $tmp_file_name;
            $this->compressImage($path, $source, $quality);
            $result = $tmp_file_name;
        }
        return $result;
    }

    public function compressImage($source, $destination, $quality)
    {

        $info = getimagesize($source);

        if (strtolower($info['mime']) == 'image/jpeg')
            $image = imagecreatefromjpeg($source);

        elseif (strtolower($info['mime']) == 'image/gif')
            $image = imagecreatefromgif($source);

        elseif (strtolower($info['mime']) == 'image/png')
            $image = imagecreatefrompng($source);

        imagejpeg($image, $destination, $quality);
    }

    public function array_sort_by_column(&$arr, $col, $dir = SORT_DESC)
    {
        $sort_col = array();
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col];
        }

        array_multisort($sort_col, $dir, $arr);
    }

    public function marketing_assignment_store(Request $request)
    {
        $marketing = Marketing::where('user_id', Auth::user()->id)->first();
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
            return redirect('layanan/marketing_assignment_index')->with(['success'=>'data berhasil disimpan']);
        } else {
            return redirect()->back()->with(['error'=>'data error disimpan']);
        }
    }

    public function marketing_assignment_create()
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
        return view('dashboard.user.admin.marketing.marketing_assignment_create', compact('marketing', 'nasabah'));
    }
}
