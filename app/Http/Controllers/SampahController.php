<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Sampah;
use Exception;
use Illuminate\Http\Request;

class SampahController extends Controller
{
    public function index()
    {
        try {
            $sampahs = Sampah::all();

            if ($sampahs->isNotEmpty()) {
                return ApiFormatter::createApi(200, 'success', $sampahs);
            } else {
                return ApiFormatter::createApi(404, 'No records found.');
            }
        } catch (\Exception $e) {
            return ApiFormatter::createApi(500, 'An error occurred.', $e->getMessage());
        }
    }

    public function store(Request $request)
    {   
        try {
            $request->validate([
                'kepala_keluarga' => 'required',
                'no_rumah' => 'required',
                'rt_rw' => 'required',
                'total_karung_sampah' => 'required',
                'tanggal_pengangkutan' => 'required',
            ]);

            $kriteria = ($request->total_karung_sampah > 3) ? 'collapse' : 'standar';

            $sampah = new Sampah();
            $sampah->kepala_keluarga = $request->kepala_keluarga;
            $sampah->no_rumah = $request->no_rumah;
            $sampah->rt_rw = $request->rt_rw;
            $sampah->total_karung_sampah = $request->total_karung_sampah;
            $sampah->kriteria = $kriteria;
            $sampah->tanggal_pengangkutan = $request->tanggal_pengangkutan;
            $sampah->save();

            $getDataSaved = Sampah::find($sampah->id);

            if ($getDataSaved) {
                return ApiFormatter::createApi(200, 'success', $getDataSaved);
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (\Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $sampah = Sampah::find($id);

            if ($sampah) {
                return ApiFormatter::createApi(200, 'success', $sampah);
            } else {
                return ApiFormatter::createApi(404, 'No records found.');
            }
        } catch (\Exception $e) {
            return ApiFormatter::createApi(500, 'An error occurred.', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'kepala_keluarga' => 'required',
                'no_rumah' => 'required',
                'rt_rw' => 'required',
                'total_karung_sampah' => 'required',
                'tanggal_pengangkutan' => 'required',
            ]);

            $kriteria = ($request->total_karung_sampah > 3) ? 'collapse' : 'standar';

            $sampah = Sampah::find($id);

            if (!$sampah) {
                return ApiFormatter::createApi(404, 'No records found.');
            }

            $sampah->update([
                'kepala_keluarga' => $request->kepala_keluarga,
                'no_rumah' => $request->no_rumah,
                'rt_rw' => $request->rt_rw,
                'total_karung_sampah' => $request->total_karung_sampah,
                'kriteria' => $kriteria,
                'tanggal_pengangkutan' => $request->tanggal_pengangkutan,
            ]);

            $updatedData = Sampah::find($sampah->id);

            if ($updatedData) {
                return ApiFormatter::createApi(200, 'success', $updatedData);
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (\Exception $error) {
            return ApiFormatter::createApi(400, 'error', $error->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $sampah = Sampah::findOrFail($id);
            $proses = $sampah->delete();
            if ($proses) {
                return ApiFormatter::createApi(200, 'success delete data');
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'error', $error->getMessage());
        }
    }

    public function trash()
    {
        try {
            $sampah = Sampah::onlyTrashed()->get();
            if ($sampah->isNotEmpty()) {
                return ApiFormatter::createApi(200, 'success', $sampah);
            } else {
                return ApiFormatter::createApi(404, 'No trashed records found.');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'error', $error->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $sampah = Sampah::onlyTrashed()->where('id', $id);
            $sampah->restore();
            $dataRestore = Sampah::where('id', $id)->first();
            if ($dataRestore) {
                return ApiFormatter::createApi(200, 'success', $dataRestore);
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'error', $error->getMessage());
        }
    }

    public function permanentDelete($id)
    {
        try {
            $sampah = Sampah::onlyTrashed()->where('id', $id);
            $proses = $sampah->forceDelete();
            if ($proses) {
                return ApiFormatter::createApi(200, 'success delete data', 'Data dihapus permanen!');
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'error', $error->getMessage());
        }
    }
}
