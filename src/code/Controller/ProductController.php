<?php 
namespace Code\Controller;

use Code\Models\ProductModel;
use Code\View;

class ProductController
{
    public function __construct(private ProductModel $productModel)
    {        
    }

    public function index()
    {        
        $_SESSION['p_id'] = $_GET['id'];
        $produto = $this->productModel->productData();
        if (isset($_SESSION['id']) && $_SESSION['id'] == $produto['vendedor']){
            return View::make('products/productOwner', ['produto' => $produto]);
        } else {            
            return View::make('products/productView', ['produto' => $produto]);
        }        
    }

    public function search()
    {
        $results = $this->productModel->searchProduct();
        return View::make('products/search', ['results' => $results]);
    }

    public function newProduct()
    {
        $this->productModel->insertProduct();
        header('Location: /perfil');
    }

    public function buying()
    {
        $produto = $this->productModel->productData();
        if (isset($_SESSION['id']) && $_SESSION['id'] != $produto['vendedor']){
            $this->productModel->addToCard($produto['id']);
            header('Location: /carrinho');
        } else{
            header('Location: /login');
        }
    }

    public function chageData()
    {
        if(isset($_POST['nproduto']) && isset($_SESSION['p_id'])){
            $this->productModel->changeData();            
        } 
        header('Location: /produto?id=' . $_SESSION['p_id']);
    }
}