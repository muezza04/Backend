<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use Illuminate\Http\Request;

class PatienstController extends Controller
{
    # Method index - Get All Resources
    public function index()
    {
        // menggunakan model patients untuk select data
        $patients = Patients::all();

        // menggunakan collection method
        // menggunakan if jika datanya tidak kosong
        if ($patients->isNotEmpty()) {
            $user = [
                'message' => 'Get All patients',
                'data' => $patients
            ];
    
            //menggunakan response json laravel otomatis set header content type ke json
            //otomatis mengubah data array ke JSON mengatur status code
            return response()->json($user, 200);
            
        // menggunakan elif jika data kosong
        } elseif ($patients->isEmpty()) {
            $data = [
                'message' => 'Data is Empty',
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);

        // terjadi kesalahan karena server error / yang tidak dikenal
        } else {
            $data = [
                'message' => 'An error occurred',
            ];

            // mengembalikan data (json) dan kode 504
            return response()->json($data, 500);
        }
    }

    # Method store - Add Resource 
    public function store(Request $request){
        // Kenapa field out_date_at tidak di di wajibkan(required)? karena field tersebut di isi tergantung kondisi, 
        // jika pasien tersebut baru masuk maka tanggal keluarnya tidak bisa di tentukan
        // (karena penyakit tidak tau kapan bisa sembuhnya)

        // menangkap data request
        $input = $request->validate([
            'name' => 'required',
            'phone' => 'numeric|required',
            'address' => 'string|required',
            'status' => 'string|required',
            'in_date_at' => 'date|required',
            'out_date_at' => 'date'
        ]);
        
        if ($input) {
            // membuat atau memasukkan data kedalam database
            $patients = Patients::create($input);

            $data = [
                'message' => 'Resource is added succesfuly',
                'data' => $patients
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 201);
        
        // Terjadi kegagalan saat menambahkan data pasient
        } else {
            $data = [
                'message' => 'Resource not found',
            ];

            // mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    # Method show - Get Detail Resource
    public function show($id)
    {
        // cari id patients yang ingin didapatkan
        $patients = Patients::find($id);

        // perbadingan untuk data yg ada dan tidak ada
        if ($patients) {
            $data = [
                'message' => 'Get Detail Resource',
                'data' => $patients,
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not found',
            ];

            // mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    # Method Update - Edit Resource
    public function update(Request $request, $id){
        // Mengambil id pasient yang ingin di dapatkan
        $patients = patients::find($id);
        
        if($patients) {

            // menangkap data request
            $input = [
                'name' => $request->name ?? $patients->name,
                'phone' => $request->phone ?? $patients->phone,
                'address' => $request->address ?? $patients->address,
                'status' => $request->status ?? $patients->status,
                'in_date_at' => $request->in_date_at ?? $patients->in_date_at,
                'out_date_at' => $request->out_date_at ?? $patients->out_date_at
            ];

            // melakukan update data
            $patients->update($input);

            $data = [
                'message' => 'Resource is update succesfuly',
                'data' => $patients
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);

        } else {
            $data = [
                'message' => 'Resource not found',
            ];

            // mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }

        
    }
    # Method Delete - Delete Resource
    public function destroy($id)
    {
        $patients = patients::find($id);

        if ($patients) {
            $patients->delete();

            $data = [
                'message' => 'Resource is deleted succesfuly'
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not found',
            ];

            // mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    # Method search - Search Resource by name
    public function search($name)
    {
        // Mencari dan menyesuaikan data di dalama database dengan yang di cari
        $names = Patients::where('name', 'like', "%".$name."%")->get();

        // perbadingan untuk data yg ada dan tidak ada
        if ($names) {
            $data = [
                'message' => 'Get detail Patients',
                'data' => $names,
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Patients not found',
            ];

            // mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    # Method positive - Get Positive Resource
    public function positive()
    {
        // menggunakan method count untuk mengetahui banyak record yg terkena status positif
        $total = Patients::where('status', 'Positif')->count();

        // mencari status positif menggunakan where and get
        $patients = Patients::where('status', 'Positif')->get();

        // menggunakan collection method
        // menggunakan if jika datanya tidak kosong
        if ($patients->isNotEmpty()) {
            $user = [
                'message' => 'Get Positive Resource',
                'total' => $total,
                'data' => $patients
            ];
    
            //menggunakan response json laravel otomatis set header content type ke json
            //otomatis mengubah data array ke JSON mengatur status code
            return response()->json($user, 200);
            
        // menggunakan elif jika data kosong
        } elseif ($patients->isEmpty()) {
            $data = [
                'message' => 'Positive is Empty',
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);

        // terjadi kesalahan karena server error / yang tidak dikenal
        } else {
            $data = [
                'message' => 'An error occurred',
            ];

            // mengembalikan data (json) dan kode 504
            return response()->json($data, 500);
        }
    }

    # Method recovered - Get Recovered Resource
    public function recovered()
    {
        // menggunakan method count untuk mengetahui banyak record yg terkena status sembuh
        $total = Patients::where('status', 'Sembuh')->count();

        // mencari status sembuh menggunakan where and get
        $patients = Patients::where('status', 'Sembuh')->get();

        // menggunakan collection method
        // menggunakan if jika datanya tidak kosong
        if ($patients->isNotEmpty()) {
            $user = [
                'message' => 'Get recovered resource',
                'total' => $total,
                'data' => $patients
            ];
    
            //menggunakan response json laravel otomatis set header content type ke json
            //otomatis mengubah data array ke JSON mengatur status code
            return response()->json($user, 200);
            
        // menggunakan elif jika data kosong
        } elseif ($patients->isEmpty()) {
            $data = [
                'message' => 'Recovered is Empty',
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);

        // terjadi kesalahan karena server error / yang tidak dikenal
        } else {
            $data = [
                'message' => 'An error occurred',
            ];

            // mengembalikan data (json) dan kode 504
            return response()->json($data, 500);
        }
    }

    # Method dead - Get Recovered Resource
    public function dead()
    {
        // menggunakan method count untuk mengetahui banyak record yg terkena status dead
        $total = Patients::where('status', 'Dead')->count();

        // mencari status dead menggunakan where and get
        $patients = Patients::where('status', 'Dead')->get();

        // menggunakan collection method
        // menggunakan if jika datanya tidak kosong
        if ($patients->isNotEmpty()) {
            $user = [
                'message' => 'Get dead resource',
                'total' => $total,
                'data' => $patients
            ];
    
            //menggunakan response json laravel otomatis set header content type ke json
            //otomatis mengubah data array ke JSON mengatur status code
            return response()->json($user, 200);
            
        // menggunakan elif jika data kosong
        } elseif ($patients->isEmpty()) {
            $data = [
                'message' => 'Dead is Empty',
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);

        // terjadi kesalahan karena server error / yang tidak dikenal
        } else {
            $data = [
                'message' => 'An error occurred',
            ];

            // mengembalikan data (json) dan kode 504
            return response()->json($data, 500);
        }
    }
}
