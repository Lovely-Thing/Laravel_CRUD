<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addressList = Address::paginate(2);
      
        return view('address.index',compact('addressList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('address.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
            'post_code' => 'required|postal_code:JP', 
            ],
            [
                'post_code'  => '正しい郵便番号を入力してください。',
            ]
        );

        $zipcode = $request->post_code;
        $zipcode = str_replace("-","", $zipcode);

        $data = $this->getZipData($zipcode);
        if($data['results'] == null) {
            return redirect()->route('address.create')->with('error', '操作失敗。正しい郵便番号を入力してください。');
        }

        $addressData = $data['results'][0]['address1'].'　'.$data['results'][0]['address2'].'　'.$data['results'][0]['address3'].'　'.$data['results'][0]['kana1'];

        Address::create([
            'post_code' => $zipcode,
            'address' => $addressData
        ]); 
        
        return redirect()->route('address.index')
                        ->with('success','新規作成しました。');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        return view('address.show',compact('address'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        return view('address.edit',compact('address'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        $request->validate(
            [
            'post_code' => 'required|postal_code:JP', 
            ],
            [
                'post_code'  => '正しい郵便番号を入力してください。',
            ]
        );

        $zipcode = $request->post_code;
        $zipcode = str_replace("-","", $zipcode);
      
        $data = $this->getZipData($zipcode); 

        if($data['results'] == null) {
            return redirect()->route('address.index')
                        ->with('error','正しい郵便番号を入力してください。');
        }

        $addressData = $data['results'][0]['address1'].'　'.$data['results'][0]['address2'].'　'.$data['results'][0]['address3'].'　'.$data['results'][0]['kana1'];

        $address->update([
            'post_code' => $zipcode,
            'address' => $addressData
        ]);
      
        return redirect()->route('address.index')
                        ->with('success','更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        $address->delete();
       
        return redirect()->route('address.index')
                        ->with('success','削除しました。');
    }

    public function getZipData($zipcode = '') {        
        $url = "http://zipcloud.ibsnet.co.jp/api/search?zipcode=".$zipcode;
        $json = file_get_contents($url);
        $arr = json_decode($json,true); 
        return $arr;
    }
}
