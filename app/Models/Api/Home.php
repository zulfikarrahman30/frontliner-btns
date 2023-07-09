<?php

namespace App\Models\Api;

use DB;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Home extends Model
{
    public static function getDataHome($request)
    {

        $result = [];
        $result['data'] = [];
        //count
        // $onProg = DB::table('marketing_assignments as mks')
        //     ->join('action_status as ast', 'ast.id', 'mks.status')
        //     ->where('mks.marketing_id', $request->marketing_id)
        //     ->where('ast.status', 'hot')
        //     ->orWhere('ast.status', 'warm')
        //     ->orWhere('ast.status', 'cold')
        //     ->count();
        $new = DB::table('marketing_assignments')->where('marketing_id', $request->marketing_id)
            ->whereNull('status')->count();
        $hot = DB::table('marketing_assignments as mks')
            ->join('action_status as ast', 'ast.id', 'mks.status')
            ->where('mks.marketing_id', $request->marketing_id)
            ->where('ast.status', 'hot')
            ->count();
        $warm = DB::table('marketing_assignments as mks')
            ->join('action_status as ast', 'ast.id', 'mks.status')
            ->where('mks.marketing_id', $request->marketing_id)
            ->where('ast.status', 'warm')
            ->count();
        $cold = DB::table('marketing_assignments as mks')
            ->join('action_status as ast', 'ast.id', 'mks.status')
            ->where('mks.marketing_id', $request->marketing_id)
            ->where('ast.status', 'cold')
            ->count();
        $unqualified = DB::table('marketing_assignments as mks')
            ->join('action_status as ast', 'ast.id', 'mks.status')
            ->where('mks.marketing_id', $request->marketing_id)
            ->where('ast.status', 'unqualified')
            ->count();
        $closed = DB::table('marketing_assignments as mks')
            ->join('action_status as ast', 'ast.id', 'mks.status')
            ->where('mks.marketing_id', $request->marketing_id)
            ->where('ast.status', 'closed')
            ->count();
        //end-count
        //new customer
        $newNasabah = null;
        $arrRelationTable = [
            'teller' => 'teller_submissions', 'financing_service' => 'financing_service_submissions', 'customer_service' => 'customer_service_submissions'
        ];
        $cnb = DB::table('marketing_assignments')->where('marketing_id', $request->marketing_id)
            ->whereNull('status')
            ->select('source')
            ->orderBy('created_at', 'DESC')
            ->first();
        if ($cnb) {
            $dataNewNasabah = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->join('' . $arrRelationTable[$cnb->source] . ' as art', 'art.id', '=', 'mks.source_id')
                ->join('customers as cts', 'cts.id', '=', 'art.customer_id')
                ->whereNull('mks.status')
                ->select(
                    'mks.id',
                    'cts.name as nama_nasabah',
                    'art.potential_category as jenis',
                    DB::Raw('IFNULL( ast.status , "Perlu difollow up" ) as status'),
                    'mks.created_at'
                )
                ->orderBy('created_at', 'DESC')
                ->first();
            if ($dataNewNasabah) {
                $newNasabah = json_decode(json_encode($dataNewNasabah), true);
                $tanggal = Carbon::parse($newNasabah['created_at'])->format('m/d/Y');
                $jam = Carbon::parse($newNasabah['created_at'])->format('g:i A');
                $fixTime = 'Created at ' . $jam . ' ' . $tanggal;
                $newNasabah['created_at'] = $fixTime;
            }
        }
        $onProg = $warm + $cold + $hot;
        //end new customer
        $result['data']['count']['badges']['new'] = $new;
        $result['data']['count']['badges']['on_progress'] = $onProg;
        $result['data']['count']['type']['hot'] = $hot;
        $result['data']['count']['type']['warm'] = $warm;
        $result['data']['count']['type']['cold'] = $cold;
        $result['data']['count']['type']['unqualified'] = $unqualified;
        $result['data']['count']['type']['closed'] = $closed;
        $result['data']['new_nasabah'] = $newNasabah;
        $result['status'] = 'success';
        $result['message'] = 'Berhasil mendapatkan data!';
        $result['code'] = 200;
        return $result;
    }

    public function getAllAssigment($request)
    {

        $arrRelation = [
            'teller' => 'teller_submissions', 'financing_service' => 'financing_service_submissions', 'customer_service' => 'customer_service_submissions'
        ];
        $arrAll = [];
        $result = [];
        $cnb = DB::table('marketing_assignments')
            ->where('marketing_id', $request->marketing_id)
            ->select('source', 'id')
            ->get();
        if (!$cnb->isEmpty()) {
            foreach ($cnb as $key => $value) {
                $newNasabah = [];
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

    public function getAllAssigmentByCategory($request)
    {

        $arrRelation = [
            'teller' => 'teller_submissions', 'financing_service' => 'financing_service_submissions', 'customer_service' => 'customer_service_submissions'
        ];
        $arrAll = [];
        $result = [];
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
                    ->where('ast.status', $request->category)
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

    public static function getDetailAssigment($request)
    {
        $masterStatus = DB::table('action_status')->select('id', 'action as kategori', 'status')->get();
        $arrRelationTable = [
            'teller' => 'teller_submissions', 'financing_service' => 'financing_service_submissions', 'customer_service' => 'customer_service_submissions'
        ];
        $cnb = DB::table('marketing_assignments')->where('id', $request->id)
            ->select('source')->orderBy('created_at', 'DESC')
            ->first();
        $newNasabah = null;
        $riwayatTemp = null;
        $riwayatArr = null;
        if ($cnb) {
            $dataNewNasabah = DB::table('marketing_assignments as mks')
                ->leftjoin('action_status as ast', 'ast.id', 'mks.status')
                ->join('' . $arrRelationTable[$cnb->source] . ' as art', 'art.id', '=', 'mks.source_id')
                ->join('customers as cts', 'cts.id', '=', 'art.customer_id')
                ->where('mks.id', $request->id)
                ->select(
                    'mks.id',
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
                $newNasabah = json_decode(json_encode($dataNewNasabah), true);
                $tanggal = Carbon::parse($newNasabah['created_at'])->format('m/d/Y');
                $jam = Carbon::parse($newNasabah['created_at'])->format('g:i A');
                $fixTime = 'Created at ' . $jam . ' ' . $tanggal;
                $newNasabah['created_at'] = $fixTime;

                //phone
                $takeWa = str_split($newNasabah['whatsapp']);
                if ($takeWa[0] == 0) {
                    unset($takeWa[0]);
                    $fixWa = '62' . implode('', $takeWa);
                } else {
                    $fixWa = implode('', $takeWa);
                }
                $newNasabah['whatsapp'] = 'https://wa.me/' . $fixWa;
                $newNasabah['email'] = 'mailto:' . $newNasabah['email'];
                //endphone
                //boomark check
                $data = DB::table('marketings')
                    ->where('id', $newNasabah['bookmark'])
                    ->select('bookmark_assignment')
                    ->first();
                $newNasabah['bookmark'] = false;
                if ($data) {
                    $tmp = explode(',', $data->bookmark_assignment);
                    if (in_array($newNasabah['id'], $tmp)) {
                        $newNasabah['bookmark'] = true;
                    }
                }
                //end bookmark check
            }
            //riwayat
            $url = url('admin/image/attachment');
            $riwayat = DB::table('marketing_assignment_activities as maa')
                ->join('action_status as ast', 'ast.id', '=', 'maa.status')
                ->where('assignment_id', $request->id)
                ->select(
                    'ast.action as kategori',
                    'ast.status',
                    DB::raw("CONCAT('$url/', maa.attachment) as attachment"),
                    'maa.title',
                    'maa.date_submit',
                    'maa.note'
                )
                ->orderBy('maa.created_at', 'DESC')
                ->first();
            if ($riwayat) {
                $riwayatTemp = json_decode(json_encode($riwayat), true);
                $status = $riwayatTemp['kategori'] . ' - ' . $riwayatTemp['status'];
                $riwayatArr['status'] = $status;
                $riwayatArr['tanggal'] = Carbon::parse($riwayatTemp['date_submit'])->format('m/d/Y');
                $riwayatArr['title'] = $riwayatTemp['title'];
                $riwayatArr['note'] = $riwayatTemp['note'];
                $riwayatArr['attachment'] = $riwayatTemp['attachment'];
            }
        }
        $result['data']['nasabah'] = $newNasabah;
        $result['data']['status'] = $masterStatus;
        $result['data']['riwayat'] = $riwayatArr;
        $result['status'] = 'success';
        $result['message'] = 'Berhasil mendapatkan data!';
        $result['code'] = 200;
        return $result;
    }

    public static function getAllRiwayat($request)
    {
        $url = url('admin/image/attachment');
        $riwayat = DB::table('marketing_assignment_activities as maa')
            ->join('action_status as ast', 'ast.id', '=', 'maa.status')
            ->where('assignment_id', $request->assignment_id)
            ->select(
                'ast.action as kategori',
                'ast.status',
                DB::raw("CONCAT('$url/', maa.attachment) as attachment"),
                'maa.title',
                'maa.date_submit',
                'maa.note'
            )
            ->orderBy('maa.created_at', 'DESC')
            ->get();
        $riwayatArr = [];
        if (!$riwayat->isEmpty()) {
            $riwayatTemp = json_decode(json_encode($riwayat), true);
            foreach ($riwayatTemp as $key => $value) {
                $status = $value['kategori'] . ' - ' . $value['status'];
                $riwayatArr[$key]['status'] = $status;
                $riwayatArr[$key]['tanggal'] = Carbon::parse($value['date_submit'])->format('m/d/Y');
                $riwayatArr[$key]['title'] = $value['title'];
                $riwayatArr[$key]['note'] = $value['note'];
                $riwayatArr[$key]['attachment'] = $value['attachment'];
            }
        }
        $result['data'] = $riwayatArr;
        $result['status'] = 'success';
        $result['message'] = 'Berhasil mendapatkan data!';
        $result['code'] = 200;
        return $result;
    }

    public function getNumberAdmin()
    {
        $data = DB::table('admins')->select('phone')->first();
        $wa = 'https://wa.me/';
        if($data)
        {
            $takeWa = str_split($data->phone);
            if ($takeWa[0] == 0) {
                unset($takeWa[0]);
                $wa .= '62' . implode('', $takeWa);
            } else {
                $wa .= implode('', $takeWa);
            }
        }
        $result = [];
        $result['data'] = $wa;
        $result['status'] = 'success';
        $result['message'] = 'Berhasil mendapatkan data!';
        $result['code'] = 200;
        return $result;
    }
}
