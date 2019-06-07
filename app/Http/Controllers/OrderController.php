<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Http\Requests\StoreOrder;

class OrderController extends Controller
{
    /**
     * Muestra todos las ordenes deacuerdo al acceso.
     * @param Request $req Todos los datos de la peticion request.
     * @return View Con la vista de las ordenes.
     */
    public function index(Request $req){
        $delete=false;
        if($req->delete){
            $delete=true;
        }
        $rows=Order::getOrders();
        return view('admin.order.search',compact("rows","delete"));
    }    
    /**
     * Muestra la vista para crear un orden.
     * @param Request $req Todos los datos de la peticion request.
     * @return View Con la vista de creacion.
     */
    public function add(Request $req){
        $providers= \App\User::getProviders();
        $products=json_encode(\App\Models\Product::getProducts());
        return view('admin.order.add',compact("providers","products"));                
    }    
    /**
     * Guardar el orden.
     * @param  StoreParticipant  $request Datos de la peticion
     * @return Response
     */
    public function storage(StoreOrder $request){
        switch (Order::storageOrders($request)) {
            case 1:
                return redirect()->route('order')->with('create', true);  
            break;
            case 2:
                return redirect()->route('order')->with('update', true);  
            break;
            default:
                $errors = new \Illuminate\Support\MessageBag();
                $errors->add('msg_0', "Se genero un error al guardar la orden");
                return back()->withInput()->withErrors($errors);
            break;
        }
    }        
    /**
     * Edita el orden.
     * @param Request $req Todos los datos de la peticion request.
     * @param integer $id Id del orden a eliminar.
     * @return Redirect Redirige al index del orden.
     */
    public function edit(Request $req,$id){
        $data= Order::getOrders($id); 
        $row=$data["order"];
        if($row){
            $productsOrder=$data["productsOrder"];
            $providers= \App\User::getProviders();
            $products=json_encode(\App\Models\Product::getProducts());
            return view('admin.order.add',compact("row","providers","products","productsOrder"));                            
        }
        else{
            return redirect()->route("order")->with('not_found', true);  
        }
    }
    /**
     * Muestra el orden.
     * @param Request $req Todos los datos de la peticion request.
     * @param integer $id Id del orden a mostrar.
     * @return View Con la vista de las tombolas.
     */
    public function view(Request $req,$id){
        $data= Order::getOrders($id); 
        $row=$data["order"];        
        if($row){
            $productsOrder=$data["productsOrder"];
            return view('admin.order.view',compact("row","productsOrder"));                
        }
        else{
            return redirect()->route("order")->with('not_found', true);  
        }
    }
    /**
     * Eliminar el orden.
     * @param request $req Todos los datos de la peticion request.
     * @return string Con el resultado de la eliminacion.
     */
    public function remove(Request $req){
        if(Order::removeOrder($req)){
            echo  "true";                
        }
        else{
            echo "false";  
        }
    }
    /**
     * Muestra todos las tombolas.
     * @param Request $req Todos los datos de la peticion request.
     * @param integer $id Id del orden a restaurar.
     * @return View Con la vista de las tombolas.
     */
    public function restore(Request $req,$id){
        if(Order::restoreOrder($id)){
            return redirect()->route("order")->with('restore', true);                  
        }
        else{
            return redirect()->route("order")->with('not_found', true);  
        }
    }
}
