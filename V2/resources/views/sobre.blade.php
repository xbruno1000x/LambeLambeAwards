@extends('layouts.app')

@section('title', 'Sobre - Lambe Lambe Awards')

@section('content')
<div style="background-image: url('{{ asset('images/fundo.jpeg') }}'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 100vh; position: relative;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.85);"></div>
    <div class="container py-5" style="position: relative; z-index: 1;">
        <h2 class="section-title">Sobre o Lambe Lambe Awards</h2>
    
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <img src="{{ asset('images/icon.png') }}" alt="Lambe Lambe Awards" style="width: 120px; height: 120px; object-fit: contain;">
                    </div>
                    
                    <h3 class="text-gold mb-4">O que é o Lambe Lambe Awards?</h3>
                    <p class="lead">
                        O Lambe Lambe Awards é uma paródia bem-humorada do Oscar, criada para celebrar 
                        (e zoar) os momentos mais marcantes do Lambe Lambe ao longo do ano.
                    </p>
                    
                    <hr class="border-gold my-4" style="opacity: 0.3;">
                    
                    <h3 class="text-gold mb-4">Como funciona?</h3>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-gold me-2"></i>
                            São criadas categorias especiais baseadas nos acontecimentos do ano
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-gold me-2"></i>
                            Os amigos são indicados nas categorias correspondentes
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-gold me-2"></i>
                            A votação é aberta e você pode votar quantas vezes quiser
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-gold me-2"></i>
                            Os vencedores são revelados em uma cerimônia especial
                        </li>
                    </ul>
                    
                    <hr class="border-gold my-4" style="opacity: 0.3;">
                    
                    <h3 class="text-gold mb-4">Tradição entre amigos</h3>
                    <p>
                        Realizado anualmente, o Lambe Lambe Awards se tornou uma tradição esperada por todos. 
                        É um momento de descontração, risadas e celebração da amizade.
                    </p>
                    
                    <div class="text-center mt-5">
                        <a href="{{ route('votacao') }}" class="btn btn-primary btn-lg px-5">
                            <i class="bi bi-check2-circle me-2"></i>Participar da Votação
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
