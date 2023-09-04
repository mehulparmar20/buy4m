<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tax;

class TaxController extends Controller
{
    public function index(Request $request)
    {
        $data=Tax::all();
        $tr="";
        foreach($data as $row)
        {
            $tr.="<tr> 
                    <td><a href='#' id='tax_update' data-value=".$row->id."><i class='bx bxs-edit-alt'></i></a></td>
                    <td>".$row->buy4meFee."%</td>
                    <td>".$row->payment_proccessing_tax."%</td>
                    <td>".$row->travel_tax."%</td>
            </tr>";
        }
        return $tr;
    }
    public function edit(Request $request)
    {
       $id=$request->id;
       $data=Tax::findOrFail($id);
       return $data;
    }
    public function update(Request $request)
    {
       $id=$request->id;
       $data=Tax::findOrFail($id);
       $data->buy4meFee=$request->buy4me_fee;
       $data->payment_proccessing_tax=$request->payment_proccessing_tax;
       $data->travel_tax=$request->travel_tax;
       $data->save();
       return array("status"=>200,'msg'=>"updated successfully");
      
    }
}
