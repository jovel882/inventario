<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\StoreProduct;

class ProductController extends Controller
{
    /**
     * Muestra todos los productos deacuerdo al acceso.
     * @param Request $req Todos los datos de la peticion request.
     * @return View Con la vista de los productos.
     */
    public function index(Request $req){
        $delete=false;
        if($req->delete){
            $delete=true;
        }
        $rows=Product::getProducts();
        return view('admin.product.search',compact("rows","delete"));
    }    
    /**
     * Muestra la vista para crear un producto.
     * @param Request $req Todos los datos de la peticion request.
     * @return View Con la vista de creacion.
     */
    public function add(Request $req){
        $providers= \App\User::getProviders();
        return view('admin.product.add',compact("providers"));                
    }    
    /**
     * Guardar el producto.
     * @param  StoreParticipant  $request Datos de la peticion
     * @return Response
     */
    public function storage(StoreProduct $request){
        switch (Product::storageProducts($request)) {
            case 1:
                return redirect()->route('product')->with('create', true);  
            break;
            case 2:
                return redirect()->route('product')->with('update', true);  
            break;
            default:
                $errors = new \Illuminate\Support\MessageBag();
                $errors->add('msg_0', "Se genero un error al guardar el producto.");
                return back()->withInput()->withErrors($errors);
            break;
        }
    }        
    /**
     * Edita el producto.
     * @param Request $req Todos los datos de la peticion request.
     * @param integer $id Id del producto a eliminar.
     * @return Redirect Redirige al index del producto.
     */
    public function edit(Request $req,$id){
        $row= Product::getProducts($id);
        if($row){
            $providers= \App\User::getProviders();
            return view('admin.product.add',compact("row","providers"));                            
        }
        else{
            return redirect()->route("product")->with('not_found', true);  
        }
    }
    /**
     * Muestra el producto.
     * @param Request $req Todos los datos de la peticion request.
     * @param integer $id Id del producto a mostrar.
     * @return View Con la vista de las tombolas.
     */
    public function view(Request $req,$id){
        $row= Product::getProducts($id);
        if($row){
            return view('admin.product.view',compact("row"));                
        }
        else{
            return redirect()->route("product")->with('not_found', true);  
        }
    }
    /**
     * Eliminar el producto.
     * @param request $req Todos los datos de la peticion request.
     * @return string Con el resultado de la eliminacion.
     */
    public function remove(Request $req){
        if(Product::removeProduct($req)){
            echo  "true";                
        }
        else{
            echo "false";  
        }
    }
    /**
     * Muestra todos las tombolas.
     * @param Request $req Todos los datos de la peticion request.
     * @param integer $id Id del producto a restaurar.
     * @return View Con la vista de las tombolas.
     */
    public function restore(Request $req,$id){
        if(Product::restoreProduct($id)){
            return redirect()->route("product")->with('restore', true);                  
        }
        else{
            return redirect()->route("product")->with('not_found', true);  
        }
    }
}
