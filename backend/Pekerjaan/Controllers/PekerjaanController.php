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

    public function generateData($data, $data2, $rekanan)
    {
        $data['pekerjaan_rekanan_id'] = $rekanan['rekanan_id'];
        $data['pekerjaan_rekanan_detail'] = json_encode($rekanan);

        $pejabat = (new User())->setView('v_user_all')->setMode('snapshoot')->whereIn('user_id', $data['pekerjaan_pejabat'])->findAll();
        foreach ($pejabat as $key => $value) {
            if ($value['user_id'] == $data['pekerjaan_pejabat']['penataUsahaKeuanganId'])  $data['pekerjaan_penata_usaha_keuangan_detail'] = json_encode($value);
            if ($value['user_id'] == $data['pekerjaan_pejabat']['pembuatKomitmenId'])  $data['pekerjaan_pembuat_komitmen_detail'] = json_encode($value);
            if ($value['user_id'] == $data['pekerjaan_pejabat']['pelaksanaTeknisId'])  $data['pekerjaan_pelaksana_teknis_detail'] = json_encode($value);
            if ($value['user_id'] == $data['pekerjaan_pejabat']['bendaharaPengeluaranId'])  $data['pekerjaan_bendahara_pengeluaran_detail'] = json_encode($value);
            if ($value['user_id'] == $data['pekerjaan_pejabat']['penggunaAnggaranId'])  $data['pekerjaan_pengguna_anggaran_detail'] = json_encode($value);
        }
        $data['pekerjaan_penata_usaha_keuangan_id'] = $data['pekerjaan_pejabat']['penataUsahaKeuanganId'];
        $data['pekerjaan_pembuat_komitmen_id'] = $data['pekerjaan_pejabat']['pembuatKomitmenId'];
        $data['pekerjaan_pelaksana_teknis_id'] = $data['pekerjaan_pejabat']['pelaksanaTeknisId'];
        $data['pekerjaan_bendahara_pengeluaran_id'] = $data['pekerjaan_pejabat']['bendaharaPengeluaranId'];
        $data['pekerjaan_pengguna_anggaran_id'] = $data['pekerjaan_pejabat']['penggunaAnggaranId'];
        $data['pekerjaan_is_include_ppn'] = 1;

        $data['pekerjaan_surat_undangan_tgl'] = dateId(date_create(convertSlashDate($data['pekerjaan_surat_undangan_tgl'])), "d F Y");
        $data['pekerjaan_surat_penunjukan_tgl'] = dateId(date_create(convertSlashDate($data['pekerjaan_surat_penunjukan_tgl'])), "d F Y");

        $data['pekerjaan_ppn'] = (new Configuration())->where('config_code', 'general.ppn')->first()['config_value'];

        $data['pekerjaan_created_by'] = session()->UserId;
        $data['pekerjaan_created_at'] = date('Y-m-d H:i:s');
        return $data;
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

    public function uploadDoc()
    {
        $data = getPost();
        try {
            $validationRule = [
                $data['type'] => [
                    'label' => 'Pdf File',
                    'rules' => 'uploaded[' . $data['type'] . ']'
                        . '|mime_in[' . $data['type'] . ',application/pdf]'
                        . '|max_size[' . $data['type'] . ',5000]'
                ],
            ];

            if (!$this->validate($validationRule)) throw new Exception(json_encode($this->validator->getErrors()));

            $file = $this->request->getFile($data['type']);

            if (!$file->hasMoved()) {
                if ($data[$data['type'] . 'Id'] == null) {
                    $pekerjaanDoc = [
                        'pekerjaan_dokumen_id' => Gen::key(16),
                        'pekerjaan_dokumen_pekerjaan_id' => $data['id'],
                        'pekerjaan_dokumen_created_at' => date("Y-m-d H:i:s"),
                        'pekerjaan_dokumen_created_by' => session()->UserId,
                        'pekerjaan_dokumen_pekerjaan_jenis_dokumen_id' => explode('_', $data['type'])[0],
                        'pekerjaan_dokumen_dokumen_id' => explode('_', $data['type'])[1],
                        'pekerjaan_dokumen_file' => str_replace('-', '_', $file->getName()) . ' ' . date('YmdHis'),
                    ];

                    $operation = DB::transaction(function () use ($data, $file, $pekerjaanDoc) {
                        $file->move(WRITEPATH . 'uploads/document/', $pekerjaanDoc['pekerjaan_dokumen_file']);
                        (new PekerjaanDokumen())->insert($pekerjaanDoc);
                    });
                } else {
                    $pekerjaanDoc = (new PekerjaanDokumen())->find($data[$data['type'] . 'Id']);
                    if ($pekerjaanDoc['pekerjaan_dokumen_file'] != null and file_exists(WRITEPATH . 'uploads/document/' . $pekerjaanDoc['pekerjaan_dokumen_file'])) unlink(WRITEPATH . 'uploads/document/' . $pekerjaanDoc['pekerjaan_dokumen_file']);
                    $pekerjaanDoc['pekerjaan_dokumen_file'] = str_replace('-', '_', $file->getName()) . ' ' . date('YmdHis');

                    $operation = DB::transaction(function () use ($data, $file, $pekerjaanDoc) {
                        $file->move(WRITEPATH . 'uploads/document/', $pekerjaanDoc['pekerjaan_dokumen_file']);
                        (new PekerjaanDokumen())->update($data[$data['type'] . 'Id'], ['pekerjaan_dokumen_file' => $pekerjaanDoc['pekerjaan_dokumen_file']]);
                    });
                }
            }

            $pekerjaanDoc = array_merge($pekerjaanDoc, (new DokumenMaster())->where('dokumen_id', explode('_', $data['type'])[1])->first());

            if (!$operation['success']) throw new Exception("Gagal Menyimpan Data");
            return $this->respond(array(
                'success' => true,
                'message' => 'Data Berhasil Disimpan',
                'title' => 'Berhasil',
                'data' => $pekerjaanDoc
            ));
        } catch (\Throwable $th) {
            return $this->respond(array(
                'success' => false,
                'message' => $th->getMessage(),
                'title' => 'Gagal'
            ));
        }
    }

    public function setDokumenValues($pekerjaanDoc, $data)
    {
        $legendList = [];

        $legendList = array_merge($legendList, (array) $data['pekerjaan_rekanan_detail']);
        $legendList = array_merge($legendList, keyAddPrefix((array) $data['pekerjaan_pengguna_anggaran_detail'], 'PA_'));
        $legendList = array_merge($legendList, keyAddPrefix((array) $data['pekerjaan_pembuat_komitmen_detail'], 'PK_'));
        $legendList = array_merge($legendList, keyAddPrefix((array) $data['pekerjaan_penata_usaha_keuangan_detail'], 'Pkeuangan_'));
        $legendList = array_merge($legendList, keyAddPrefix((array) $data['pekerjaan_pelaksana_teknis_detail'], 'Pteknis_'));
        $legendList = array_merge($legendList, keyAddPrefix((array) $data['pekerjaan_bendahara_pengeluaran_detail'], 'Pbendahara_'));
        $legendList = array_merge($legendList, [
            'dokumen_no' => $pekerjaanDoc['pekerjaan_dokumen_no'],
            'dokumen_tgl' => $pekerjaanDoc['pekerjaan_dokumen_tgl'],
            'tanggal_hari' =>  $pekerjaanDoc['tanggal_hari'],
            'tanggal_hari_huruf' =>  $pekerjaanDoc['tanggal_hari_huruf'],
            'tanggal_nama_hari' =>  $pekerjaanDoc['tanggal_nama_hari'],
            'tanggal_bulan' =>  $pekerjaanDoc['tanggal_bulan'],
            'tanggal_nama_bulan' =>  $pekerjaanDoc['tanggal_nama_bulan'],
            'tanggal_tahun' =>  $pekerjaanDoc['tanggal_tahun'],
            'tanggal_tahun_huruf' =>  $pekerjaanDoc['tanggal_tahun_huruf'],
            'durasi_perintah_kerja' => $pekerjaanDoc['diffSPMK'],
            'termyn_ke' => $pekerjaanDoc['termyn_ke'],
            'pembayaran' => toRp($pekerjaanDoc['pekerjaan_jenis_dokumen_pembayaran']),
            'pembayaran_huruf' => numToSpell($pekerjaanDoc['pekerjaan_jenis_dokumen_pembayaran']),
            'pembayaran_prosentase' => $pekerjaanDoc['pekerjaan_jenis_dokumen_pembayaran'] / $data['total_harga'] * 100,
            'pembayaran_prosentase_huruf' => numToSpell($pekerjaanDoc['pekerjaan_jenis_dokumen_pembayaran'] / $data['total_harga'] * 100),
            'nilai_kontrak_huruf' => numToSpell($data['total_harga']),
            'nilai_kontrak' => toRp($data['total_harga']),
            'nilai_kontrak_asli' => toRp($data['harga_asli']),
            'nilai_ppn' => toRp($data['nilai_ppn']),
            'nilai_pph' => toRp($data['nilai_pph']),
            'pekerjaan_surat_penunjukan_tgl_tanggal' => explode(' ', $data['pekerjaan_surat_penunjukan_tgl'])[0],
            'pekerjaan_surat_penunjukan_tgl_bulan' => explode(' ', $data['pekerjaan_surat_penunjukan_tgl'])[1],
            'pekerjaan_surat_penunjukan_tgl_tahun' => explode(' ', $data['pekerjaan_surat_penunjukan_tgl'])[2],
        ]);

        $legendList = array_merge($legendList, $data);
        unset(
            $legendList['rekanan_id'],
            $legendList['PA_user_id'],
            $legendList['PK_user_id'],
            $legendList['pekerjaan_id'],
            $legendList['pekerjaan_program_id'],
            $legendList['pekerjaan_kegiatan_id'],
            $legendList['pekerjaan_rekanan_id'],
            $legendList['pekerjaan_rekanan_detail'],
            $legendList['pekerjaan_pembuat_komitmen_id'],
            $legendList['pekerjaan_pembuat_komitmen_detail'],
            $legendList['pekerjaan_pengguna_anggaran_id'],
            $legendList['pekerjaan_pengguna_anggaran_detail'],
            $legendList['pekerjaan_penata_usaha_keuangan_id'],
            $legendList['pekerjaan_penata_usaha_keuangan_detail'],
            $legendList['pekerjaan_pelaksana_teknis_id'],
            $legendList['pekerjaan_pelaksana_teknis_detail'],
            $legendList['pekerjaan_bendahara_pengeluaran_id'],
            $legendList['pekerjaan_bendahara_pengeluaran_detail'],
            $legendList['pekerjaan_created_at'],
            $legendList['pekerjaan_updated_at'],
            $legendList['pekerjaan_created_by'],
            $legendList['pekerjaan_sumber_dana_id'],
            $legendList['pekerjaan_kegiatan_sub_id'],
            $legendList['pekerjaan_sumber_dana_id'],
            $legendList['pekerjaan_jenis_pph_id'],
            $legendList['rekanan_bank_id'],
        );


        $html = base64_decode($pekerjaanDoc['dokumen_template']);
        foreach ($legendList as $key => $value) {
            $html = str_replace('${' . $key . '}', $value, $html);
        }
        return $html;
    }

    public function generateDoc()
    {
        $data = getVar();
        $data['tanggal'] = date_create(convertSlashDate($data['tanggal']));

        $pekerjaanDoc = [
            'pekerjaan_dokumen_id' => ($data['dataId'] == '') ? Gen::key(16) : $data['dataId'],
            'pekerjaan_dokumen_pekerjaan_id' => $data['id'],
            'pekerjaan_dokumen_pekerjaan_jenis_dokumen_id' => explode('_', $data['type'])[0],
            'pekerjaan_dokumen_dokumen_id' => explode('_', $data['type'])[1],
            'pekerjaan_dokumen_no' => $data['nomor'],
            'pekerjaan_dokumen_tgl' => dateId($data['tanggal'], "d F Y"),
            'pekerjaan_dokumen_created_at' => date("Y-m-d H:i:s"),
            'pekerjaan_dokumen_created_by' => session()->UserId,
            'tanggal_hari' => date_format($data['tanggal'], "d"),
            'tanggal_hari_huruf' => numToSpell(date_format($data['tanggal'], "d")),
            'tanggal_nama_hari' => dateId($data['tanggal'], "l"),
            'tanggal_bulan' => date_format($data['tanggal'], "m"),
            'tanggal_nama_bulan' => dateId($data['tanggal'], "F"),
            'tanggal_tahun' => date_format($data['tanggal'], "Y"),
            'tanggal_tahun_huruf' => numToSpell(date_format($data['tanggal'], "Y")),
            'diffSPMK' => $data['diffSPMK'],
            'termyn_ke' => $data['termyn_ke'],
        ];
        $pekerjaanDoc = array_merge($pekerjaanDoc, (new DokumenMaster())->where('dokumen_id', $pekerjaanDoc['pekerjaan_dokumen_dokumen_id'])->first());
        $pekerjaanDoc['pekerjaan_dokumen_file_name'] = $pekerjaanDoc['dokumen_nama'] . ' ' . date('YmdHis');
        $pekerjaanDoc = array_merge($pekerjaanDoc, (new PekerjaanJenisDokumen())->select('pekerjaan_jenis_dokumen_pembayaran')->where('pekerjaan_jenis_dokumen_id', $pekerjaanDoc['pekerjaan_dokumen_pekerjaan_jenis_dokumen_id'])->first());
        try {
            $operation = DB::transaction(function () use ($data, $pekerjaanDoc) {
                $operation = (new Pekerjaan())->setView('v_pekerjaan_all')->find($data['id']);
                $operation['harga_asli'] -= (100 / (100 + $operation['pekerjaan_ppn'])) * $operation['harga_asli'] * ($operation['pekerjaan_ppn'] / 100);
                $operation['nilai_ppn'] = $operation['harga_asli'] * $operation['pekerjaan_ppn'] / 100;
                $operation['nilai_pph'] = $operation['harga_asli'] * $operation['jenis_pph_presentase'] / 100;
                $operation['total_harga'] = $operation['harga_asli'] + $operation['nilai_ppn'];
                $operation['pekerjaan_pengguna_anggaran_detail'] = json_decode(monthEngtoId($operation['pekerjaan_pengguna_anggaran_detail']));
                $operation['pekerjaan_pembuat_komitmen_detail'] = json_decode(monthEngtoId($operation['pekerjaan_pembuat_komitmen_detail']));
                $operation['pekerjaan_penata_usaha_keuangan_detail'] = json_decode(monthEngtoId($operation['pekerjaan_penata_usaha_keuangan_detail']));
                $operation['pekerjaan_pelaksana_teknis_detail'] = json_decode(monthEngtoId($operation['pekerjaan_pelaksana_teknis_detail']));
                $operation['pekerjaan_bendahara_pengeluaran_detail'] = json_decode(monthEngtoId($operation['pekerjaan_bendahara_pengeluaran_detail']));
                $operation['pekerjaan_rekanan_detail'] = json_decode(monthEngtoId($operation['pekerjaan_rekanan_detail']));
                $operation['pekerjaan_rekanan_detail']->rekanan_tgl_akte = dateId(date_create($operation['pekerjaan_rekanan_detail']->rekanan_tgl_akte), "d F Y");

                $html = '';
                switch ($pekerjaanDoc['dokumen_kode']) {
                    case 'DOC-002':
                        $kontrakSSk = $this->request->getFile('kontrakSSk');
                        if ($kontrakSSk->getName() != null) {
                            $validationRule = [
                                'kontrakSSk' => [
                                    'label' => 'Pdf File',
                                    'rules' => 'uploaded[kontrakSSk]'
                                        . '|mime_in[kontrakSSk,application/pdf]'
                                        . '|max_size[kontrakSSk,5000]'
                                ],
                            ];

                            if (!$this->validate($validationRule)) throw new Exception(json_encode($this->validator->getErrors()));

                            if ($operation['pekerjaan_ssk'] != null and file_exists(WRITEPATH . 'uploads/document/' . $operation['pekerjaan_ssk'])) unlink(WRITEPATH . 'uploads/document/' . $operation['pekerjaan_ssk']);
                            $kontrakSSk->move(WRITEPATH . 'uploads/document/', str_replace('-', '_', $kontrakSSk->getName()) . ' ' . date('YmdHis'));
                            (new Pekerjaan())->update($data['id'], [
                                'pekerjaan_ssk' => str_replace('-', '_', $kontrakSSk->getName()) . ' ' . date('YmdHis'),
                            ]);
                        }

                        $kontrakSSUk = $this->request->getFile('kontrakSSUk');
                        if ($kontrakSSUk->getName() != null) {
                            $validationRule = [
                                'kontrakSSUk' => [
                                    'label' => 'Pdf File',
                                    'rules' => 'uploaded[kontrakSSUk]'
                                        . '|mime_in[kontrakSSUk,application/pdf]'
                                        . '|max_size[kontrakSSUk,5000]'
                                ],
                            ];

                            if (!$this->validate($validationRule)) throw new Exception(json_encode($this->validator->getErrors()));

                            if ($operation['pekerjaan_ssuk'] != null and file_exists(WRITEPATH . 'uploads/document/' . $operation['pekerjaan_ssuk'])) unlink(WRITEPATH . 'uploads/document/' . $operation['pekerjaan_ssuk']);
                            $kontrakSSUk->move(WRITEPATH . 'uploads/document/', str_replace('-', '_', $kontrakSSUk->getName()) . ' ' . date('YmdHis'));
                            (new Pekerjaan())->update($data['id'], [
                                'pekerjaan_ssuk' => str_replace('-', '_', $kontrakSSUk->getName()) . ' ' . date('YmdHis'),
                            ]);
                        }
                        break;
                    case 'DOC-003':
                        $data['spmkMulai'] = null;
                        if (isset(explode(' - ', $data['tanggalSPMK'])[0])) {
                            $data['spmkMulai'] = explode(' - ', $data['tanggalSPMK'])[0];
                            $data['spmkMulai'] = date_create(convertSlashDate($data['spmkMulai']));
                            $data['spmkMulai'] = dateId($data['spmkMulai'], "d F Y");
                        }

                        $pekerjaanDoc['pekerjaan_dokumen_tgl_mulai'] = $data['spmkMulai'];
                        $data['spmkSelesai'] = null;
                        if (isset(explode(' - ', $data['tanggalSPMK'])[1])) {
                            $data['spmkSelesai'] = explode(' - ', $data['tanggalSPMK'])[1];
                            $data['spmkSelesai'] = date_create(convertSlashDate($data['spmkSelesai']));
                            $data['spmkSelesai'] = dateId($data['spmkSelesai'], "d F Y");
                        }

                        $pekerjaanDoc['pekerjaan_dokumen_tgl_selesai'] = $data['spmkSelesai'];
                        $operation = array_merge($operation, [
                            'pekerjaan_dokumen_tgl_mulai' => $pekerjaanDoc['pekerjaan_dokumen_tgl_mulai'],
                            'pekerjaan_dokumen_tgl_selesai' => $pekerjaanDoc['pekerjaan_dokumen_tgl_selesai'],
                            'pekerjaan_dokumen_durasi_pekerjaan' => $pekerjaanDoc['diffSPMK'],
                        ]);
                        // $pekerjaanUraian = (new Pekerjaan())->setView('v_pekerjaan_uraian_all')->where('pekerjaan_uraian_pekerjaan_id', $data['id'])->orderBy('pekerjaan_uraian_nama', 'ASC')->findAll();
                        break;

                    case 'DOC-006':
                    case 'DOC-007':
                    case 'DOC-009':
                    case 'DOC-012':
                    case 'DOC-013':
                    case 'DOC-015':
                    case 'DOC-019':
                    case 'DOC-020':
                        $operation = array_merge($operation, keyAddPrefix((new PekerjaanDokumen())->select(['pekerjaan_dokumen_no', 'pekerjaan_dokumen_tgl', 'pekerjaan_dokumen_tgl_mulai'])->where('pekerjaan_dokumen_pekerjaan_id', $data['id'])->where('pekerjaan_dokumen_dokumen_id', 'n5j9qg55y8fc0yks')->first(), 'SP_'));
                        $operation = array_merge($operation, keyAddPrefix((new PekerjaanDokumen())->select(['pekerjaan_dokumen_tgl_mulai', 'pekerjaan_dokumen_tgl_selesai'])->where('pekerjaan_dokumen_pekerjaan_id', $data['id'])->where('pekerjaan_dokumen_dokumen_id', 'i2b2wrizvq4gvynh')->first(), 'SPK_'));
                        break;

                    case 'DOC-016':
                        $operation = array_merge($operation, keyAddPrefix((new PekerjaanDokumen())->select(['pekerjaan_dokumen_no', 'pekerjaan_dokumen_tgl'])->where('pekerjaan_dokumen_pekerjaan_id', $data['id'])->where('pekerjaan_dokumen_dokumen_id', 'n5j9qg55y8fc0yks')->first(), 'SP_'));
                        $operation = array_merge($operation, keyAddPrefix((new PekerjaanDokumen())->select(['pekerjaan_dokumen_no', 'pekerjaan_dokumen_tgl', 'pekerjaan_dokumen_tgl_mulai', 'pekerjaan_dokumen_tgl_selesai'])->where('pekerjaan_dokumen_pekerjaan_id', $data['id'])->where('pekerjaan_dokumen_dokumen_id', 'i2b2wrizvq4gvynh')->first(), 'SPK_'));
                        $operation = array_merge($operation, keyAddPrefix((new PekerjaanDokumen())->select(['pekerjaan_dokumen_no', 'pekerjaan_dokumen_tgl'])->where('pekerjaan_dokumen_pekerjaan_jenis_dokumen_id', $pekerjaanDoc['pekerjaan_dokumen_pekerjaan_jenis_dokumen_id'])->whereIn('pekerjaan_dokumen_dokumen_id', ['s1bhkbmzovtysmmh', 'faz5xe0vm7u53mvy'])->first(), 'PemeriksaanPekerjaan_'));
                        break;

                    case 'DOC-005':
                    case 'DOC-011':
                        $operation = array_merge($operation, keyAddPrefix((new PekerjaanDokumen())->select(['pekerjaan_dokumen_no', 'pekerjaan_dokumen_tgl'])->where('pekerjaan_dokumen_pekerjaan_id', $data['id'])->where('pekerjaan_dokumen_dokumen_id', 'n5j9qg55y8fc0yks')->first(), 'SP_'));
                        $operation = array_merge($operation, keyAddPrefix((new PekerjaanDokumen())->select(['pekerjaan_dokumen_no', 'pekerjaan_dokumen_tgl'])->where('pekerjaan_dokumen_pekerjaan_id', $data['id'])->where('pekerjaan_dokumen_dokumen_id', 'i2b2wrizvq4gvynh')->first(), 'SPK_'));
                        break;
                    case 'DOC-018':
                        $operation = array_merge($operation, keyAddPrefix((new PekerjaanDokumen())->select(['pekerjaan_dokumen_no', 'pekerjaan_dokumen_tgl'])->where('pekerjaan_dokumen_pekerjaan_id', $data['id'])->where('pekerjaan_dokumen_dokumen_id', 'n5j9qg55y8fc0yks')->first(), 'SP_'));
                        $operation = array_merge($operation, keyAddPrefix((new PekerjaanDokumen())->select(['pekerjaan_dokumen_no', 'pekerjaan_dokumen_tgl'])->where('pekerjaan_dokumen_pekerjaan_id', $data['id'])->where('pekerjaan_dokumen_dokumen_id', 'i2b2wrizvq4gvynh')->first(), 'SPK_'));
                        $operation = array_merge($operation, keyAddPrefix((new PekerjaanDokumen())->select(['pekerjaan_dokumen_no', 'pekerjaan_dokumen_tgl'])->where('pekerjaan_dokumen_pekerjaan_id', $data['id'])->like('pekerjaan_dokumen_dokumen_id', "1b3e5icyp6affntd")->first(), 'SerahTerima_'));
                        break;
                }
                $html = $this->setDokumenValues($pekerjaanDoc, $operation);
                $html = $this->dynamicAlign($html,$pekerjaanDoc['dokumen_kode']);
                // print_r($html);
                // exit;
                $html = str_replace('<table>', '<table style="width:100%;">', $html);
                $html = str_replace('<table class="ck-table-resized" style="', '<table class="ck-table-resized" style="width:100%;', $html);

                createPdf([
                    'data' => $html,
                    'save' => true,
                    'paper_size' => ['216', '330'],
                    'file_name' => $pekerjaanDoc['pekerjaan_dokumen_file_name'],
                    'title' => $pekerjaanDoc['pekerjaan_dokumen_file_name'],
                    'margin' => '5 5 5 5',
                    'font_face' => 'sans',
                    'font_size' => '10',
                ]);

                if ($data['dataId'] == '') {
                    $operation = (new PekerjaanDokumen())->insert($pekerjaanDoc);
                } else {
                    $temp = (new PekerjaanDokumen())->find($data['dataId']);
                    if (file_exists(WRITEPATH . 'uploads/document/' . $temp['pekerjaan_dokumen_file_name'] . '.pdf')) {
                        unlink(WRITEPATH . 'uploads/document/' . $temp['pekerjaan_dokumen_file_name'] . '.pdf');
                    }
                    $operation = (new PekerjaanDokumen())->update($data['dataId'], $pekerjaanDoc);
                }

                if ($operation != 1) throw new Exception("Gagal Menyimpan Data");

                $file = new \CodeIgniter\Files\File($pekerjaanDoc['pekerjaan_dokumen_file_name'] . '.pdf', true);
                $operation = $file->move(WRITEPATH . 'uploads/document/');
            });

            if (!$operation['success']) throw new Exception("Gagal Menyimpan Data");
            unset($pekerjaanDoc['dokumen_template']);
            return $this->respond(array(
                'success' => true,
                'message' => 'Data Berhasil Disimpan',
                'title' => 'Berhasil',
                'data' => $pekerjaanDoc
            ));
        } catch (\Throwable $th) {
            if (file_exists($pekerjaanDoc['pekerjaan_dokumen_file_name'] . '.pdf')) {
                unlink($pekerjaanDoc['pekerjaan_dokumen_file_name'] . '.pdf');
            }
            return $this->respond(array(
                'success' => false,
                'message' => $th->getMessage(),
                'title' => 'Gagal'
            ));
        }
    }

    public function newTermyn()
    {
        $data = getVar();
        $saveData = [
            'pekerjaan_jenis_dokumen_id' => Gen::key(),
            'pekerjaan_jenis_dokumen_pekerjaan_id' => $data['id'],
            'pekerjaan_jenis_dokumen_jenis_dokumen_id' => $data['jenisTermyn'],
            'pekerjaan_jenis_dokumen_pembayaran' => $data['pembayaran'],
            'pekerjaan_jenis_dokumen_created_at' => date('Y-m-d H:i:s'),
        ];
        $operation = DB::transaction(function () use ($saveData) {
            (new PekerjaanJenisDokumen())->insert($saveData);
        });
        $operation['jenisDokumen'] = (new PekerjaanJenisDokumen())->setView('v_pekerjaan_jenis_dokumen_all')->where('pekerjaan_jenis_dokumen_pekerjaan_id', $data['id'])->orderBy('pekerjaan_jenis_dokumen_created_at', 'ASC')->findAll();
        $operation['dokumen'] = (new PekerjaanDokumen())->setView('v_pekerjaan_dokumen_all')->where('pekerjaan_dokumen_pekerjaan_id', $data['id'])->orderBy('pekerjaan_dokumen_created_at', 'ASC')->findAll();
        return $this->respond($operation);
    }

    public function dynamicAlign($html,$pekerjaanDoc)
    {
        $html = explode('<td>', $html);
        $html = implode('<td style="">', $html);
        $html = explode('<td style="', $html);
        $res[] = $html[0];
        unset($html[0]);
        foreach ($html as $key => $value) {
            if (strpos($value, 'text-align:center;') !== false) $res[] = 'text-align:center;' . $value;
            else if (strpos($value, 'text-align:left;') !== false) $res[] = 'text-align:left;' . $value;
            else if (strpos($value, 'text-align:justify;') !== false) $res[] = 'text-align:justify;' . $value;
            else if (strpos($value, 'text-align:right;') !== false) $res[] = 'text-align:right;' . $value;
            else $res[] = $value;
        };
        if($pekerjaanDoc == 'DOC-003'){
            return implode('<td style="vertical-align:top;', $res);
        };
        return implode('<td style="vertical-align:top;', $res);
    }
}
