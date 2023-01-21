<?php

namespace BackEnd\Pekerjaan\Controllers;

use App\Libraries\DB;
use App\Libraries\Gen;
use BackEnd\BidangProgram\Models\BidangKegiatan;
use BackEnd\BidangProgram\Models\BidangKegiatanSub;
use BackEnd\Configuration\Models\Configuration;
use BackEnd\Pekerjaan\Models\Pekerjaan;
use BackEnd\SumberDana\Models\SumberDana;
use BackEnd\JenisPPH\Models\JenisPPH;
use BackEnd\Pekerjaan\Models\PekerjaanDokumen;
use BackEnd\Pekerjaan\Models\PekerjaanUraian;
use BackEnd\BidangProgram\Models\BidangProgram;
use BackEnd\DokumenMaster\Models\DokumenMaster;
use BackEnd\DokumenMaster\Models\JenisDokumen;
use BackEnd\Pekerjaan\Models\PekerjaanJenisDokumen;
use BackEnd\Rekanan\Models\Rekanan;
use BackEnd\Satuan\Models\Satuan;
use BackEnd\User\Models\User;
use Exception;

class PekerjaanController extends \App\Core\BaseController
{
    public function index()
    {
        $operation = (new Pekerjaan(request()))->setView('v_pekerjaan')->setMode('datatable')->draw(false);
        foreach ($operation['data'] as $key => $value) {
            $operation['data'][$key]->no = ($key + 1);
        }
        return $this->respond($operation);
    }

    public function show()
    {
        $data = getPost();
        $operation = (new Pekerjaan())->setView('v_pekerjaan_all')->find($data['id']);
        $operation['detail'] = (new PekerjaanUraian())->setView('v_pekerjaan_uraian_all')->where('pekerjaan_uraian_pekerjaan_id', $data['id'])->findAll();
        $operation['dokumen'] = (new PekerjaanDokumen())->setView('v_pekerjaan_dokumen_all')->where('pekerjaan_dokumen_pekerjaan_id', $data['id'])->orderBy('pekerjaan_dokumen_created_at', 'ASC')->findAll();
        $operation['pekerjaanJenisDokumen'] = (new PekerjaanJenisDokumen())->setView('v_pekerjaan_jenis_dokumen_all')->where('pekerjaan_jenis_dokumen_pekerjaan_id', $data['id'])->orderBy('pekerjaan_jenis_dokumen_created_at', 'ASC')->findAll();
        return $this->respondToCamel($operation, 'pekerjaan');
    }

    public function store()
    {
        $data = getVar(null, 'pekerjaan');
        $data2 = getPost();
        $rekanan = [
            'rekanan_id' => ($data2['rekanan_id'] == '') ? Gen::key(16) : $data2['rekanan_id'],
            'rekanan_kode' => "null",
            'rekanan_nama' => $data2['rekanan_nama'],
            'rekanan_nama_perusahaan' => $data2['rekanan_nama_perusahaan'],
            'rekanan_alamat' => $data2['rekanan_alamat'],
            'rekanan_kota' => $data2['rekanan_kota'],
            'rekanan_jabatan' => $data2['rekanan_jabatan'],
            'rekanan_npwp' => $data2['rekanan_npwp'],
            'rekanan_akte' => $data2['rekanan_akte'],
            'rekanan_tgl_akte' => date_format(date_create(convertSlashDate($data2['rekanan_tgl_akte'])), "Y-m-d"),
            'rekanan_pembuat_akte' => $data2['rekanan_pembuat_akte'],
            'rekanan_kop_surat' => "null",
            'rekanan_telepon' => $data2['rekanan_telepon'],
            'rekanan_email' => $data2['rekanan_email'],
            'rekanan_bank' => $data2['rekanan_bank'],
            'rekanan_rekening' => $data2['rekanan_rekening'],
        ];
        $operation = DB::transaction(function () use ($data, $data2, $rekanan) {
            $data['pekerjaan_id'] = Gen::key(16);
            $data = $this->generateData($data, $data2, $rekanan);

            $uraianPekerjaan = [];
            foreach ($data['pekerjaan_uraian_pekerjaan'] as $k => $v) {
                $uraianPekerjaan[] = [
                    'pekerjaan_uraian_id' => Gen::key(16),
                    'pekerjaan_uraian_pekerjaan_id' => $data['pekerjaan_id'],
                    'pekerjaan_uraian_nama' => $v['nama'],
                    'pekerjaan_uraian_qty' => $v['qty'],
                    'pekerjaan_uraian_satuan_id' => $v['satuan'],
                    'pekerjaan_uraian_harga' => str_replace('.', '', $v['harga']),
                    'pekerjaan_uraian_pagu' => str_replace('.', '', $v['pagu']),
                ];
            }
            $findRekan = (new Rekanan())->where('rekanan_id', $data2['rekanan_id'])->findAll();
            if ($findRekan == null) {
                (new Rekanan())->insert($rekanan);
            } else {
                (new Rekanan())->update($rekanan['rekanan_id'], $rekanan);
            };
            (new Pekerjaan())->insert($data);
            if ($uraianPekerjaan != []) (new PekerjaanUraian())->insertBatch($uraianPekerjaan);
            (new PekerjaanJenisDokumen())->insert([
                'pekerjaan_jenis_dokumen_id' => Gen::key(),
                'pekerjaan_jenis_dokumen_pekerjaan_id' => $data['pekerjaan_id'],
                'pekerjaan_jenis_dokumen_jenis_dokumen_id' => 'mdgbeeav3hzqb3cs',
                'pekerjaan_jenis_dokumen_created_at' => date('Y-m-d H:i:s'),
            ]);
        });
        return $this->respondCreated($operation);
    }

    public function update()
    {
        $data = getVar(null, 'pekerjaan');
        $data2 = getPost();
        $rekanan = [
            'rekanan_id' => ($data2['rekanan_id'] == '') ? Gen::key(16) : $data2['rekanan_id'],
            'rekanan_kode' => "null",
            'rekanan_nama' => $data2['rekanan_nama'],
            'rekanan_nama_perusahaan' => $data2['rekanan_nama_perusahaan'],
            'rekanan_alamat' => $data2['rekanan_alamat'],
            'rekanan_kota' => $data2['rekanan_kota'],
            'rekanan_jabatan' => $data2['rekanan_jabatan'],
            'rekanan_npwp' => $data2['rekanan_npwp'],
            'rekanan_akte' => $data2['rekanan_akte'],
            'rekanan_tgl_akte' => date_format(date_create(convertSlashDate($data2['rekanan_tgl_akte'])), "Y-m-d"),
            'rekanan_pembuat_akte' => $data2['rekanan_pembuat_akte'],
            'rekanan_telepon' => $data2['rekanan_telepon'],
            'rekanan_email' => $data2['rekanan_email'],
            'rekanan_bank' => $data2['rekanan_bank'],
            'rekanan_rekening' => $data2['rekanan_rekening'],
        ];
        $operation = DB::transaction(function () use ($data, $data2, $rekanan) {
            $data = $this->generateData($data, $data2, $rekanan);

            $uraianPekerjaan = [];
            if (isset($data['pekerjaan_uraian_pekerjaan'])) {
                foreach ($data['pekerjaan_uraian_pekerjaan'] as $k => $v) {
                    $uraianPekerjaan[] = [
                        'pekerjaan_uraian_id' => Gen::key(16),
                        'pekerjaan_uraian_pekerjaan_id' => $data['pekerjaan_id'],
                        'pekerjaan_uraian_nama' => $v['nama'],
                        'pekerjaan_uraian_qty' => $v['qty'],
                        'pekerjaan_uraian_satuan_id' => $v['satuan'],
                        'pekerjaan_uraian_harga' => str_replace('.', '', $v['harga']),
                        'pekerjaan_uraian_pagu' => str_replace('.', '', $v['pagu']),
                    ];
                }
            }
            $findRekan = (new Rekanan())->where('rekanan_id', $data2['rekanan_id'])->findAll();
            if ($findRekan == null) {
                (new Rekanan())->insert($rekanan);
            } else {
                (new Rekanan())->update($rekanan['rekanan_id'], $rekanan);
            };
            (new Pekerjaan())->update($data['pekerjaan_id'], $data);
            (new PekerjaanUraian())->where('pekerjaan_uraian_pekerjaan_id', $data['pekerjaan_id'])->delete();
            if ($uraianPekerjaan != []) (new PekerjaanUraian())->insertBatch($uraianPekerjaan);
        });
        return $this->respondCreated($operation);
    }

    public function destroy()
    {
        $data = getPost();
        try {
            $operation = DB::transaction(function () use ($data) {
                $operation = (new PekerjaanJenisDokumen())->where('pekerjaan_jenis_dokumen_pekerjaan_id', $data['id'])->delete();
                if ($operation['success'] == false) throw new Exception($operation['errors'], $operation['code']);
                $operation = (new PekerjaanUraian())->where('pekerjaan_uraian_pekerjaan_id', $data['id'])->delete();
                if ($operation['success'] == false) throw new Exception($operation['errors'], $operation['code']);
                $operation = (new Pekerjaan())->delete($data['id']);
                if ($operation['success'] == false) throw new Exception($operation['errors'], $operation['code']);
            });
            return $this->respondDeleted($operation);
        } catch (\Throwable $th) {
            if ($th->getCode() == '1451') {
                return $this->respondDeleted([
                    'success' => false,
                    'message' => "Gagal menghapus Data, Data sudah digunakan",
                ]);
            } else {
                return $this->respondDeleted([
                    'success' => false,
                    'message' => "Gagal menghapus Data",
                ]);
            }
        }
    }

    public function getData()
    {
        $data = getPost();
        if ($data == []) {
            $user = (new User())->setView('v_user_all')->where('user_active', '1')->orderBy('user_code', 'ASC')->findAll();
            $penataUsahaKeuangan = [];
            $pembuatKomitmen = [];
            $pelaksanaTeknis = [];
            $bendaharaPengeluaran = [];
            $penggunaAnggaran = [];
            foreach ($user as $key => $value) {
                if ($value['user_position_id'] == 'yficc5zcin1jt0il') $penataUsahaKeuangan[] = $value;
                if ($value['user_position_id'] == 'egqoyod8sdoeos7z') $pembuatKomitmen[] = $value;
                if ($value['user_position_id'] == 'mc4g93t70dgppdvu') $pelaksanaTeknis[] = $value;
                if ($value['user_position_id'] == 'qjlrn8gcmmocf6dz') $bendaharaPengeluaran[] = $value;
                if ($value['user_position_id'] == 'nejb9wk9ovypwhwg') $penggunaAnggaran[] = $value;
            }

            $program = (new BidangProgram())->setView('v_position_program')->where('position_program_bidang_id', session()->BidangId)->orderBy('program_kode', 'ASC')->findAll();
            $sumberDana = (new SumberDana())->where('sumber_dana_aktif', '1')->orderBy('sumber_dana_kode', 'ASC')->findAll();
            $JenisPPH = (new JenisPPH())->where('jenis_pph_aktif', '1')->orderBy('jenis_pph_kode', 'ASC')->findAll();
            $rekanan = (new Rekanan())->orderBy('rekanan_kode', 'ASC')->findAll();
            $satuan = (new Satuan())->where('satuan_aktif', '1')->orderBy('satuan_kode', 'ASC')->findAll();
            $ppn = (new Configuration())->where('config_code', 'general.ppn')->first();
            $dokumen = (new DokumenMaster())->setView('v_dokumen_master')->where('dokumen_aktif', 1)->orderBy('dokumen_kode', 'ASC')->findAll();
            $JenisDokumen = (new JenisDokumen())->where('jenis_dokumen_id <>', 'mdgbeeav3hzqb3cs')->orderBy('jenis_dokumen_kode', 'ASC')->findAll();
            $start = date('Y', strtotime('-10 years'));
            $end = date('Y', strtotime('+10 years'));
            $year = [];
            for ($start; $start <= $end; $start++) {
                $year[]['year'] = $start;
            };
            return $this->respond([
                'program' => $program,
                'sumberDana' => $sumberDana,
                'JenisPPH' => $JenisPPH,
                'rekanan' => $rekanan,
                'satuan' => $satuan,
                'penataUsahaKeuangan' => $penataUsahaKeuangan,
                'pembuatKomitmen' => $pembuatKomitmen,
                'pelaksanaTeknis' => $pelaksanaTeknis,
                'bendaharaPengeluaran' => $bendaharaPengeluaran,
                'penggunaAnggaran' => $penggunaAnggaran,
                'ppn' => $ppn['config_value'],
                'dokumen' => $dokumen,
                'JenisDokumen' => $JenisDokumen,
                'year' => $year,
            ]);
        } else {
            if (isset($data['programId'])) {
                $program = (new BidangProgram())->setView('v_position_program')->where('position_program_bidang_id', session()->BidangId)->orderBy('program_kode', 'ASC')->findAll();

                return $this->respond([
                    'kegiatan' => (new BidangKegiatan())->setView('v_position_kegiatan')->where('kegiatan_program_id', $data['programId'])->where('position_kegiatan_bidang_id', session()->BidangId)->orderBy('kegiatan_kode', 'ASC')->findAll()
                ]);
            }
            if (isset($data['kegiatanId'])) {
                return $this->respond([
                    'kegiatanSub' => (new BidangKegiatanSub())->setView('v_position_kegiatan_sub')->where('kegiatan_sub_kegiatan_id', $data['kegiatanId'])->where('position_kegiatan_sub_bidang_id', session()->BidangId)->orderBy('kegiatan_sub_kode', 'ASC')->findAll()
                ]);
            }
        }
    }
}
