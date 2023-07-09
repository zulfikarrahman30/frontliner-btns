<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\UserLog;
use Auth;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('timeoutses');
    }

    public function index()
    {
        $data = Admin::orderBy('created_at', 'DESC')->get();
        return view('dashboard.user.admin.index', compact('data'));
    }

    public function uploadFile(Request $request, $oke)
    {
        $result ='';
        $file = $request->file($oke);
        $name = $file->getClientOriginalName();
        $extension = explode('.', $name);
        $extension = strtolower(end($extension));
        $key = rand().'-'.$oke.'-admin';
        $tmp_file_name = "{$key}.{$extension}";
        $tmp_file_path = "admin/image/profile/admin";
        $file->move($tmp_file_path, $tmp_file_name);
        $result = $tmp_file_name;
        return $result;
    }

    public function filter(Request $request)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('dashboard.user.admin.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $type.' '.$name.' '.$content.' '.$ip;
        // dd($request->all());
        $cek = User::where('email', $request->email)->first();
        if ($cek) {
            //return "Gagal email ada";
            return redirect()->back()->with(['error'=>'data error di simpan , email '.$request->email.' sudah terdaftar']);
        }

        $user = User::create([
            'name' =>$request->name,
            'role'  =>'admin',
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
                //return $format;
            }
            $photo = $this->uploadFile($request, 'photo');
        }
        $admin = Admin::create([
            'user_id' =>$user->id,
            'name' =>$request->name,
            'photo'=>$photo,
        ]);

        if ($admin) {
            $type='create';
            $name=Auth::user()->name;
            $content='Admin User '.$request->name.' ';
            $ip=$request->ip();
            UserLog::log($type, $name, $content, $ip);
            return redirect('user/admin_index')->with(['success'=>'data berhasil disimpan']);
        //return "data berhasil disimpan";
        } else {
            return redirect()->back()->with(['error'=>'data error disimpan']);
            //return "data error disimpan";
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
        $data = Admin::where('user_id', $id)->first();
        return view('dashboard.user.admin.edit', compact('data'));
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
        //  return $request->all();
        $user = User::where('id', $id)->update([
            'name' =>$request->name,
            'role'  =>'admin',
            'email' =>$request->email
        ]);


        if ($request->file('photo')!= null) {
            $cek = Admin::where('user_id', $id)->first();
            if ($cek) {
                $photo = $request->file('photo');
                $format = strtolower($photo->getClientOriginalExtension());
                $arr = ['jpg','png','jpeg'];
                if (!in_array($format, $arr)) {
                    return redirect()->back()->with(['gagal'=>'Format Gambar Salah !']);
                }
                $photo = $this->uploadFile($request, 'photo');

                $admin = Admin::where('user_id', $id)->update([
                    'photo' =>$photo,
                    'name' =>$request->name,
                ]);
            }
        } else {
            $admin = Admin::where('user_id', $id)->update([
                'name' =>$request->name,
            ]);
        }

        if ($admin) {
            $type='update';
            $name=Auth::user()->name;
            $content='Admin User '.$request->name.' ';
            $ip=$request->ip();

            UserLog::log($type, $name, $content, $ip);
            return redirect('/home')->with(['success'=>'data berhasil diupdate']);
        } else {
            return redirect()->back()->with(['error'=>'data tidak berhasil diupdate']);
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
        $admin = Admin::where('user_id', $id)->first();

        //proses delete
        if ($admin) {
            Admin::where('user_id', $id)->delete();
        }
        if ($user) {
            User::find($id)->delete();
        }

        if ($user) {
            $type='delete';
            $name=Auth::user()->name;
            $content='Admin User '.$user->name.' ';
            $ip=$_SERVER['REMOTE_ADDR'];

            UserLog::log($type, $name, $content, $ip);
            return redirect()->back()->with(['success'=>'data berhasil dihapus']);
        } else {
            return redirect()->back()->with(['gagal'=>'data gagal dihapus']);
        }
    }
}
