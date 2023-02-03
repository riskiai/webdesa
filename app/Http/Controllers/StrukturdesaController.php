<?php

namespace App\Http\Controllers;

use App\Structurdesa;
use Illuminate\Http\Request;
use DataTables;
use File;
use Session;

class StrukturdesaController extends Controller
{
   
    public function index(Request $request)
    {
                     $dat = Structurdesa::orderBy('id','DESC')->get();
    
          

            return view('admin/structur/index',compact('dat'));
    }


          public function store(Request $request)
            {   
                
                if($request->hasFile('foto')){
                    $foto = $request->file('foto');
                    $nama  = time()."_".$foto->getClientOriginalName();
                    $lokasi = public_path('/foto');
                    $foto->move($lokasi,$nama);
                    Structurdesa::updateOrCreate(

                    ['id' => $request->data_id],
                    [
                        
                    'nama' => $request->nama,
                    'masa_jabatan' => $request->mulai.'---'.$request->selesai,
                    'jabatan' => $request->role,
                    'foto' => $nama
                    ]);        

        

 
                }else{
                    Structurdesa::updateOrCreate(

                        ['id' => $request->data_id],
                        [
                            
                        'nama' => $request->nama,
                        'masa_jabatan' => $request->mulai.'---'.$request->selesai,
                        'jabatan' => $request->role
                        ]);        

        

                }
              
              Session::flash('sukses','Data Berhasi Di Tambahkan');
                return redirect('/structur')->with('status','data berhasil di Simpan');
           
            }

        // edit

        public function edit($id)
        {
            $user = Structurdesa::find($id);

            return response()->json($user);
        }


        // delete

        public function destroy($id)
        {
        // hapus file
		$gambar = Structurdesa::where('id',$id)->first();
		File::delete('foto/'.$gambar->foto);
 

        Structurdesa::find($id)->delete();

       Session::flash('sukses','Data Berhasi Di Hapus');
        return redirect('/structur')->with('status','data berhasil di Hapus');
        }

}
