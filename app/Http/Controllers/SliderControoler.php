<?php

namespace App\Http\Controllers;

use App\Slider;
use Illuminate\Http\Request;
use File;
use Session;
 
use DataTables;
class SliderControoler extends Controller
{
        public function index(Request $request)

        {

            $dat = Slider::orderBy('id','DESC')->get();

        

            return view('admin/slider/index',compact('dat'));

        }

        public function store(Request $request)
            {
             
               


                if($request->hasFile('foto')){
                    $foto = $request->file('foto');
                    $nama  = time()."_".$foto->getClientOriginalName();
                    $lokasi = public_path('/foto');
                    $foto->move($lokasi,$nama);
                    Slider::updateOrCreate(

                        ['id' => $request->data_id],
                        [
                        'heding' => $request->h1,
                        'heding2' => $request->h2,
                        'color' => $request->color,
                        'keterangan' => $request->keterangan,
                        'foto' => $nama
                        ]);        

    
                }else{
                    Slider::updateOrCreate(

                        ['id' => $request->data_id],
                        [
                        'heding' => $request->h1,
                        'heding2' => $request->h2,
                        'color' => $request->color,
                        'keterangan' => $request->keterangan
                        ]);        

                }

              
        

                Session::flash('sukses','Data Berhasi Di Tambahkan');
                return redirect('/slider')->with('status','data berhasil di Simpan');

           
            }

        // edit

        public function edit($id)
        {
            $user = Slider::find($id);

            return response()->json($user);
        }


        // delete

        public function destroy($id)
        {
        // hapus file
		$gambar = Slider::where('id',$id)->first();
		File::delete('foto/'.$gambar->foto);
 

        Slider::find($id)->delete();
        Session::flash('sukses','Data Berhasi Di Hapus');
        return redirect('/slider')->with('status','data berhasil di Hapus');
        }

}
