<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\CustomerService;
use App\Models\User;
use App\Models\UserLog;
use Auth;

class CustomerServiceUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('timeoutses');
    }

    public function index()
    {
        $data = CustomerService::orderBy('created_at', 'DESC')->get();
        return view('dashboard.user.admin.customerservice.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function uploadFile(Request $request, $oke)
    {
        $result ='';
        $file = $request->file($oke);
        $name = $file->getClientOriginalName();
        $extension = explode('.', $name);
        $extension = strtolower(end($extension));
        $key = rand().'-'.$oke.'-customer_service';
        $tmp_file_name = "{$key}.{$extension}";
        $tmp_file_path = "admin/image/profile/customer_service";
        $file->move($tmp_file_path, $tmp_file_name);
        $result = $tmp_file_name;
        return $result;
    }


    public function create()
    {
        return view('dashboard.user.admin.customerservice.add');
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
            'role'  =>'customer_service',
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
        $customer_service = CustomerService::create([
            'user_id' =>$user->id,
            'name' =>$request->name,
            'photo' =>$photo,
            'phone' =>$request->phone
        ]);

        if ($customer_service) {
            $type='create';
            $name=Auth::user()->name;
            $content='Customer Service User '.$request->name.' ';
            $ip=$request->ip();
            UserLog::log($type, $name, $content, $ip);
            return redirect('user/customer_service_index')->with(['success'=>'data berhasil disimpan']);
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
        $data = CustomerService::where('user_id', $id)->first();
        return view('dashboard.user.admin.customerservice.edit', compact('data'));
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
            'role'  =>'customer_service',
            'email' =>$request->email
        ]);


        if ($request->file('photo')!= null) {
            $cek = CustomerService::where('user_id', $id)->first();
            if ($cek) {
                $photo = $request->file('photo');
                $format = strtolower($photo->getClientOriginalExtension());
                $arr = ['jpg','png','jpeg'];
                if (!in_array($format, $arr)) {
                    return redirect()->back()->with(['gagal'=>'Format Gambar Salah !']);
                }
                $photo = $this->uploadFile($request, 'photo');

                $cs = CustomerService::where('user_id', $id)->update([
                    'photo' =>$photo,
                    'name' =>$request->name,
                    'phone'=>$request->phone
                ]);
            } else {
                $photo = $request->file('photo');
                $photo = $request->file('photo');
                $format = strtolower($photo->getClientOriginalExtension());
                $arr = ['jpg','png','jpeg'];
                if (!in_array($format, $arr)) {
                    return redirect()->back()->with(['gagal'=>'Format Gambar Salah !']);
                }
                $photo = $this->uploadFile($request, 'photo');
                $cs = CustomerService::create([
                    'user_id' =>$id,
                    'photo' =>$photo,
                    'name' =>$request->name,
                    'phone'=>$request->phone
                ]);
            }
        } else {
            $cs = CustomerService::where('user_id', $id)->update([
                'name' =>$request->name,
                'phone'=>$request->phone
            ]);
        }

        if ($cs) {
            $type='update';
            $name=Auth::user()->name;
            $content='Customer Service User '.$request->name.' ';
            $ip=$request->ip();
            UserLog::log($type, $name, $content, $ip);
            if(Auth::user()->role == 'admin')
            {
                return redirect('user/customer_service_index')->with(['success'=>'data berhasil diupdate']);
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
        $cs = CustomerService::where('user_id', $id)->first();

        //proses delete
        if ($cs) {
            CustomerService::where('user_id', $id)->delete();
        }
        if ($user) {
            User::find($id)->delete();
        }

        if ($user) {
            $type='delete';
            $name=Auth::user()->name;
            $content='Customer Service User '.$user->name.' ';
            $ip=$_SERVER['REMOTE_ADDR'];

            UserLog::log($type, $name, $content, $ip);
            return redirect()->back()->with(['success'=>'data berhasil dihapus']);
        } else {
            return redirect()->back()->with(['gagal'=>'data gagal dihapus']);
        }
    }
}
