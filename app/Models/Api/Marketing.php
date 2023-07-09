<?php

namespace App\Models\Api;

use DB;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class Marketing extends Model
{
    public static function uploadFile($request, $oke)
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
            static::compressImage($path, $source, $quality);
            $result = $tmp_file_name;
        }
        return $result;
    }

    public static function updateProfileUplaod($request, $oke)
    {
        $result = null;
        if ($request->file($oke) != null) {
            $file = $request->file($oke);
            $name = $file->getClientOriginalName();
            $extension = explode('.', $name);
            $extension = strtolower(end($extension));
            $key = rand() . '-' . $oke . '-marketing';
            $tmp_file_name = "{$key}.{$extension}";
            $path = $request->file($oke)->getPathName();
            $tmp_file_path = "admin/image/profile/marketing";
            $quality = 60;
            $source = $tmp_file_path . '/' . $tmp_file_name;
            static::compressImage($path, $source, $quality);
            $result = $tmp_file_name;
        }
        return $result;
    }

    public static function compressImage($source, $destination, $quality)
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

    public static function submitActivity($request)
    {
        $attachment = static::uploadFile($request, 'attachment');
        $h1 = str_replace(' ', '', $request->date_submit); // M/d/Y
        $arrStart = explode('/', $h1);
        $fixdate = $arrStart[2] . '-' . $arrStart[0] . '-' . $arrStart[1];
        $result = [];
        //insert
        DB::table('marketing_assignment_activities')->insert([
            'assignment_id' => $request->assignment_id,
            'title' => $request->title,
            'date_submit' => $fixdate,
            'note' => $request->note,
            'attachment' => $attachment,
            'status' => $request->status,
            'created_at' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString()
        ]);
        DB::table('marketing_assignments')->where('id', $request->assignment_id)->update([
            'status' => $request->status,
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString()
        ]);
        $result['status'] = 'success';
        $result['message'] = 'Berhasil meyimpan data!';
        $result['code'] = 200;
        return $result;
    }

    public static function bookmarOrUnBookmarkkActivity($request)
    {
        $marketing_id = $request->marketing_id;
        $action = $request->action;
        $assignment_id = $request->assignment_id;
        $data = DB::table('marketings')->where('id', $marketing_id)->select('bookmark_assignment')->first();
        $arrImp = NULL;
        if ($data) {
            $arr = $data->bookmark_assignment;
            if ($data->bookmark_assignment != NULL) {
                $expArr = explode(',', $arr);
                if ($action == 'unbookmark') {
                    $key = array_search($assignment_id, $expArr);
                    if ($key) {
                        unset($expArr[$key]);
                        $arrImp = implode(',', $expArr);
                    } else {
                        $arrImp = implode(',', $expArr);
                    }
                } else {
                    $key = array_search($assignment_id, $expArr);
                    if (!$key) {
                        array_push($expArr, $assignment_id);
                        $arrImp = implode(',', $expArr);
                    } else {
                        $arrImp = implode(',', $expArr);
                    }
                }
            } else {
                $arrImp = $assignment_id;
            }
        }
        DB::table('marketings')->where('id', $marketing_id)->update([
            'bookmark_assignment' => $arrImp,
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString()
        ]);
        $result['status'] = 'success';
        $result['message'] = 'Berhasil ' . $action . ' data!';
        $result['code'] = 200;
        return $result;
    }

    public static function getBookmarkAssignment($request)
    {
        $arrRelation = [
            'teller' => 'teller_submissions', 'financing_service' => 'financing_service_submissions', 'customer_service' => 'customer_service_submissions'
        ];
        $arrAll = [];
        $result = [];
        $data = DB::table('marketings')
            ->where('id', $request->marketing_id)
            ->select('bookmark_assignment')
            ->first();
        $tmp = null;
        if ($data) {
            $tmp = explode(',', $data->bookmark_assignment);
        }
        $cnb = DB::table('marketing_assignments')
            ->whereIn('id', $tmp)
            ->select('source', 'id')
            ->get();
        if (!$cnb->isEmpty()) {
            foreach ($cnb as $key => $value) {
                $newNasabah = null;
                $dataNewNasabah = DB::table('marketing_assignments as mks')
                    ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                    ->join('' . $arrRelation[$value->source] . ' as art', 'art.id', '=', 'mks.source_id')
                    ->join('customers as cts', 'cts.id', '=', 'art.customer_id')
                    ->where('mks.id', $value->id)
                    ->select(
                        'mks.id',
                        'cts.name as nama_nasabah',
                        'art.potential_category as jenis',
                        DB::Raw('IFNULL( ast.status , "Perlu difollow up" ) as status'),
                        'mks.created_at'
                    )
                    ->first();
                if ($dataNewNasabah) {
                    $newNasabah = json_decode(json_encode($dataNewNasabah), true);
                    $tanggal = Carbon::parse($newNasabah['created_at'])->format('m/d/Y');
                    $jam = Carbon::parse($newNasabah['created_at'])->format('g:i A');
                    $fixTime = 'Created at ' . $jam . ' ' . $tanggal;
                    $newNasabah['created_at'] = $fixTime;
                    array_push($arrAll, $newNasabah);
                }
            }
        }

        $result['data'] = $arrAll;
        $result['status'] = 'success';
        $result['message'] = 'Berhasil mendapatkan data!';
        $result['code'] = 200;
        return $result;
    }

    public static function updateProfile($request)
    {
        $marketing_id = $request->marketing_id;
        $arr = [
            'name' => $request->name,
            'phone' => $request->phone,
            'updated_at' => Carbon::now('Asia/Jakarta')->toDateTimeString()
        ];
        $user = [];
        $result = [];
        $data = DB::table('marketings')->where('id', $marketing_id)->first();
        if ($data) {

            $user['name'] = $request->name;
            $user['updated_at'] = Carbon::now('Asia/Jakarta')->toDateTimeString();
            if ($request->password) {
                if ($request->password != NULL) {
                    $user['password'] = bcrypt($request->password);
                }
            }
            $cek = DB::table('users')->where('email', $request->email)->first();
            if ($cek) {
                if ($data->user_id == $cek->id) // email nya dia sendiri
                {
                    $user['email'] = $request->email;
                } else {
                    $result['status'] = 'error';
                    $result['message'] = 'Gagal mengupdate data, email ' . $request->email . ' telah digunakan!';
                    $result['code'] = 400;
                    return $result;
                }
            } else {
                $user['email'] = $request->email;
            }
            if ($request->file('photo') != null) {
                $photo = static::updateProfileUplaod($request, 'photo');
                $arr['photo'] = $photo;
            }
            DB::table('marketings')->where('id', $marketing_id)->update($arr);
            DB::table('users')->where('id', $data->user_id)->update($user);
            $url = url('admin/image/profile/marketing');
            $updatedData = DB::table('users as us')
                ->join('marketings as mks', 'mks.user_id', '=', 'us.id')
                ->select(
                    'us.*',
                    'mks.type',
                    'mks.id as marketing_id',
                    'mks.phone',
                    DB::raw("CONCAT('$url/', mks.photo) as photo")
                )
                ->where('mks.id', $request->marketing_id)
                ->first();
            $result['status'] = 'success';
            $result['message'] = 'Berhasil mengupdate data!';
            $result['data'] = $updatedData;
            $result['code'] = 200;
            return $result;
        } else {
            $result = [];
            $result['status'] = 'error';
            $result['message'] = 'Gagal mendapatkan data!';
            $result['data'] = [];
            $result['code'] = 400;
            return $result;
        }
    }

    public static function updatePhotoProfile($request)
    {
        $marketing_id = $request->marketing_id;
        $arr = [];
        $arr['updated_at'] = Carbon::now('Asia/Jakarta')->toDateTimeString();
        $data = DB::table('marketings')->where('id', $marketing_id)->first();
        if ($data) {
            if ($request->file('photo') != null) {
                $photo = static::updateProfileUplaod($request, 'photo');
                $arr['photo'] = $photo;
            }
            DB::table('marketings')->where('id', $marketing_id)->update($arr);
            $result = [];
            $result['status'] = 'success';
            $result['message'] = 'Berhasil mengupdate data!';
            $result['code'] = 200;
            return $result;
        } else {
            $result = [];
            $result['status'] = 'error';
            $result['message'] = 'Gagal mendapatkan data!';
            $result['code'] = 400;
            return $result;
        }
    }

    public static function changePassword($request)
    {
        $arr = [];
        $arr['updated_at'] = Carbon::now('Asia/Jakarta')->toDateTimeString();
        if ($request->old_password) {
            $data = DB::table('marketings')->where('id', $request->marketing_id)->first();
            if ($data) {
                $userLog = DB::table('users')->where('id', $data->user_id)->first();
                if ($userLog) {
                    if ($request->new_password) {
                        if ($request->new_confirm_password) {
                            if ($request->new_password == $request->new_confirm_password) {
                                if (!Hash::check($request->old_password, $userLog->password)) {
                                    $result = [];
                                    $result['status'] = 'error';
                                    $result['message'] = 'Gagal password lama salah!';
                                    $result['code'] = 400;
                                    return $result;
                                } else {
                                    $arr['password'] = bcrypt($request->new_password);
                                    DB::table('users')->where('id', $userLog->id)->update($arr);
                                    $result = [];
                                    $result['status'] = 'success';
                                    $result['message'] = 'Berhasil mengubah password!';
                                    $result['code'] = 200;
                                    return $result;
                                }
                            } else {
                                $result = [];
                                $result['status'] = 'error';
                                $result['message'] = 'Gagal password baru tidak sama dengan password konfirmasi!';
                                $result['code'] = 400;
                                return $result;
                            }
                        } else {
                            $result = [];
                            $result['status'] = 'error';
                            $result['message'] = 'Gagal password konfirmasi tidak boleh kosong!';
                            $result['code'] = 400;
                            return $result;
                        }
                    } else {
                        $result = [];
                        $result['status'] = 'error';
                        $result['message'] = 'Gagal password baru tidak boleh kosong!';
                        $result['code'] = 400;
                        return $result;
                    }
                } else {
                    $result = [];
                    $result['status'] = 'error';
                    $result['message'] = 'Gagal user tidak ditemukan!';
                    $result['code'] = 400;
                    return $result;
                }
            } else {
                $result = [];
                $result['status'] = 'error';
                $result['message'] = 'Gagal marketing tidak ditemukan!';
                $result['code'] = 400;
                return $result;
            }
        } else {
            $result = [];
            $result['status'] = 'error';
            $result['message'] = 'Gagal field old password tidak boleh kosong!';
            $result['code'] = 400;
            return $result;
        }
    }

    public static function searchByCategoryName($request)
    {
        $arrRelation = [
            'teller' => 'teller_submissions', 'financing_service' => 'financing_service_submissions', 'customer_service' => 'customer_service_submissions'
        ];
        $arrAll = [];
        $cnb = DB::table('marketing_assignments')
            ->where('marketing_id', $request->marketing_id)
            ->select('source', 'id')
            ->get();
        if (!$cnb->isEmpty()) {
            foreach ($cnb as $key => $value) {
                $newNasabah = null;
                $dataNewNasabah = DB::table('marketing_assignments as mks')
                    ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                    ->join('' . $arrRelation[$value->source] . ' as art', 'art.id', '=', 'mks.source_id')
                    ->join('customers as cts', 'cts.id', '=', 'art.customer_id')
                    ->where('mks.id', $value->id)
                    ->where('ast.status', $request->type)
                    ->where('cts.name', 'like', '%' . $request->name . '%')
                    ->select(
                        'mks.id',
                        'cts.name as nama_nasabah',
                        'art.potential_category as jenis',
                        DB::Raw('IFNULL( ast.status , "Perlu difollow up" ) as status'),
                        'mks.created_at'
                    )
                    ->first();
                if ($dataNewNasabah) {
                    $newNasabah = json_decode(json_encode($dataNewNasabah), true);
                    $tanggal = Carbon::parse($newNasabah['created_at'])->format('m/d/Y');
                    $jam = Carbon::parse($newNasabah['created_at'])->format('g:i A');
                    $fixTime = 'Created at ' . $jam . ' ' . $tanggal;
                    $newNasabah['created_at'] = $fixTime;
                    array_push($arrAll, $newNasabah);
                }
            }
        }

        $result['data'] = $arrAll;
        $result['status'] = 'success';
        $result['message'] = 'Berhasil mendapatkan data!';
        $result['code'] = 200;
        return $result;
    }

    public static function searchByNewsName($request)
    {
        $arrRelationTable = [
            'teller' => 'teller_submissions', 'financing_service' => 'financing_service_submissions', 'customer_service' => 'customer_service_submissions'
        ];
        $cnb = DB::table('marketing_assignments')
            ->where('marketing_id', $request->marketing_id)
            ->whereNull('status')
            ->select('source')
            ->orderBy('created_at', 'DESC')
            ->get();
        $newNasabah = [];
        if (!$cnb->isEmpty()) {
            foreach ($cnb as $key => $value) {
                $dataNew = null;
                $dataNewNasabah = DB::table('marketing_assignments as mks')
                    ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                    ->join('' . $arrRelationTable[$value->source] . ' as art', 'art.id', '=', 'mks.source_id')
                    ->join('customers as cts', 'cts.id', '=', 'art.customer_id')
                    ->where('cts.name', 'like', '%' . $request->name . '%')
                    ->select(
                        'mks.id',
                        'mks.source',
                        'cts.name as nama_nasabah',
                        'art.potential_category as jenis',
                        DB::Raw('IFNULL( ast.status , "Perlu difollow up" ) as status'),
                        'mks.created_at'
                    )
                    ->orderBy('created_at', 'DESC')
                    ->first();
                if ($dataNewNasabah) {
                    $dataNew = json_decode(json_encode($dataNewNasabah), true);
                    $tanggal = Carbon::parse($dataNew['created_at'])->format('m/d/Y');
                    $jam = Carbon::parse($dataNew['created_at'])->format('g:i A');
                    $fixTime = 'Created at ' . $jam . ' ' . $tanggal;
                    $dataNew['created_at'] = $fixTime;
                }
                if ($dataNew != null) {
                    array_push($newNasabah, $dataNew);
                }
            }
        }
        $filter = [];
        $filterResult = [];
        if (count($newNasabah) > 0) {
            foreach ($newNasabah as $value) {
                $filter[$value['id']] = $value;
            }
            $filterResult = array_values($filter);
        }
        $result['data'] = $filterResult;
        $result['status'] = 'success';
        $result['message'] = 'Berhasil menemukan data!';
        $result['code'] = 200;
        return $result;
    }

    public static function searchByBookmarkName($request)
    {
        $arrRelation = [
            'teller' => 'teller_submissions', 'financing_service' => 'financing_service_submissions', 'customer_service' => 'customer_service_submissions'
        ];
        $arrAll = [];
        $result = [];
        $data = DB::table('marketings')
            ->where('id', $request->marketing_id)
            ->select('bookmark_assignment')
            ->first();
        $tmp = null;
        if ($data) {
            $tmp = explode(',', $data->bookmark_assignment);
        }
        $cnb = DB::table('marketing_assignments')
            ->whereIn('id', $tmp)
            ->select('source', 'id')
            ->get();
        if (!$cnb->isEmpty()) {
            foreach ($cnb as $key => $value) {
                $newNasabah = null;
                $dataNewNasabah = DB::table('marketing_assignments as mks')
                    ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                    ->join('' . $arrRelation[$value->source] . ' as art', 'art.id', '=', 'mks.source_id')
                    ->join('customers as cts', 'cts.id', '=', 'art.customer_id')
                    ->where('mks.id', $value->id)
                    ->where('cts.name', 'like', '%' . $request->name . '%')
                    ->select(
                        'mks.id',
                        'cts.name as nama_nasabah',
                        'art.potential_category as jenis',
                        DB::Raw('IFNULL( ast.status , "Perlu difollow up" ) as status'),
                        'mks.created_at'
                    )
                    ->first();
                if ($dataNewNasabah) {
                    $newNasabah = json_decode(json_encode($dataNewNasabah), true);
                    $tanggal = Carbon::parse($newNasabah['created_at'])->format('m/d/Y');
                    $jam = Carbon::parse($newNasabah['created_at'])->format('g:i A');
                    $fixTime = 'Created at ' . $jam . ' ' . $tanggal;
                    $newNasabah['created_at'] = $fixTime;
                    array_push($arrAll, $newNasabah);
                }
            }
        }

        $result['data'] = $arrAll;
        $result['status'] = 'success';
        $result['message'] = 'Berhasil mendapatkan data!';
        $result['code'] = 200;
        return $result;
    }
}
