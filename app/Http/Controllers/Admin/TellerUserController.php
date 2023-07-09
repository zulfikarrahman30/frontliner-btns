<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Teller;
use App\Models\User;
use App\Models\UserLog;
use Auth;

class TellerUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('timeoutses');
    }

    public function index()
    {
        $data = Teller::orderBy('created_at', 'DESC')->get();
        return view('dashboard.user.admin.teller.index', compact('data'));
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
        $tmp_file_path = "admin/image/profile/teller";
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
        return view('dashboard.user.admin.teller.add');
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
            'role'  =>'teller',
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
        $teller = Teller::create([
           'user_id' =>$user->id,
           'name' =>$request->name,
           'photo' =>$photo,
           'phone' =>$request->phone
    ]);

        if ($teller) {
            $type='create';
            $name=Auth::user()->name;
            $content='Teller User '.$request->name.' ';
            $ip=$request->ip();
            UserLog::log($type, $name, $content, $ip);
            return redirect('user/teller_index')->with(['success'=>'data berhasil disimpan']);
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
        $data = Teller::where('user_id', $id)->first();
        return view('dashboard.user.admin.teller.edit', compact('data'));
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
            'role'  =>'teller',
            'email' =>$request->email
        ]);

        if ($request->file('photo')!= null) {
            $cek = Teller::where('user_id', $id)->first();
            if ($cek) {
                $photo = $request->file('photo');
                $format = strtolower($photo->getClientOriginalExtension());
                $arr = ['jpg','png','jpeg'];
                if (!in_array($format, $arr)) {
                    return redirect()->back()->with(['gagal'=>'Format Gambar Salah !']);
                }
                $photo = $this->uploadFile($request, 'photo');

                $teller = Teller::where('user_id', $id)->update([
                    'photo' =>$photo,
                    'name' =>$request->name,
                    'phone'=>$request->phone
                ]);
            } else {
                $photo = $request->file('photo');
                $format = strtolower($photo->getClientOriginalExtension());
                $arr = ['jpg','png','jpeg'];
                if (!in_array($format, $arr)) {
                    return redirect()->back()->with(['gagal'=>'Format Gambar Salah !']);
                }
                $photo = $this->uploadFile($request, 'photo');
                $teller = Teller::create([
                    'user_id' =>$id,
                    'photo' =>$photo,
                    'name' =>$request->name,
                    'phone'=>$request->phone
                ]);
            }
        } else {
            $teller = Teller::where('user_id', $id)->update([
                'name' =>$request->name,
                'phone'=>$request->phone
            ]);
        }

        if ($teller) {
            $type='update';
            $name=Auth::user()->name;
            $content='Teller User '.$request->name.' ';
            $ip=$request->ip();
            UserLog::log($type, $name, $content, $ip);
            if(Auth::user()->role == 'admin'){
               return redirect('user/teller_index')->with(['success'=>'data berhasil diupdate']);
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
        $teller = Teller::where('user_id', $id)->first();

        //proses delete
        if ($teller) {
            Teller::where('user_id', $id)->delete();
        }
        if ($user) {
            User::find($id)->delete();
        }

        if ($user) {
            $type='delete';
            $name=Auth::user()->name;
            $content='Teller User '.$user->name.' ';
            $ip=$_SERVER['REMOTE_ADDR'];

            UserLog::log($type, $name, $content, $ip);
            return redirect()->back()->with(['success'=>'data berhasil dihapus']);
        } else {
            return redirect()->back()->with(['gagal'=>'data gagal dihapus']);
        }
    }
}
