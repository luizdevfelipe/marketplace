<?php 
declare(strict_types=1);

namespace Code\Controller;

use Code\Models\CardModel;
use Code\View;

class CardController 
{
    public function __construct(private CardModel $cardModel)
    {        
    }

    public function index()
    {
        if (empty($_SESSION['id'])) {
            return View::make('error/perfil');
        }
        
        $products = $this->cardModel->getProducts();
        return View::make('user/carrinho', ['products' => $products]);
    }

    public function remove(){
        if(!empty($_GET['id'])){
            $this->cardModel->removeProduct();
        } else {
            return View::make('error/404');
        }
    }
}