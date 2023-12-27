<!-- resources/views/cart.blade.php -->

@extends('layout.app')

@section('content')
    <!-- ... autres éléments HTML ... -->

    <div>
        <h2>Mon Panier</h2>
        <ul id="cartItems">
            <!-- Les éléments du panier seront affichés ici -->
        </ul>
    </div>

    <script>
        // Fonction pour récupérer les articles du panier depuis localStorage
        function getCartItems() {
            return JSON.parse(localStorage.getItem('cart')) || [];
        }

        // Fonction pour afficher les articles dans le panier
        function displayCartItems() {
            const cartItems = getCartItems();
            const cartList = document.getElementById('cartItems');

            // Efface le contenu précédent du panier
            cartList.innerHTML = '';

            // Ajoute chaque élément au panier à la liste
            cartItems.forEach(item => {
                const listItem = document.createElement('li');
                listItem.textContent = `Voiture ID: ${item}`;
                cartList.appendChild(listItem);
            });
        }

        // Appelle la fonction pour afficher les articles lors du chargement de la page
        displayCartItems();
    </script>

    <!-- ... autres éléments HTML ... -->
@endsection
