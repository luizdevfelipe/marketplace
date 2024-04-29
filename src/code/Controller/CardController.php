<?php 
declare(strict_types=1);

namespace Code\Controller;

use Code\Attributes\Get;
use Code\Models\CardModel;
use Code\Service\CardService;
use Code\View;

class CardController 
{
    public function __construct(private CardService $cardService)
    {        
    }

    #[Get('/carrinho')]
    public function index()
    {
        if (empty($_SESSION['id'])) {
            return View::make('error/perfil');
        }
        
        $products = $this->cardService->getProducts();
        return View::make('user/carrinho', ['products' => $products]);
    }

    #[Get('/remover')]
    public function remove(){
        if(!empty($_GET['id'])){
            $this->cardService->removeProduct();
        } else {
            return View::make('error/404');
        }
    }
}