@extends('welcome')

@section('contenido')
<div class="inicio-container">
    <section class="content">
        <div class="box">
            <div class="box-body">
                <!-- Breve presentación del sistema -->
                <div class="presentation">
                    <h1 class="title">Bienvenido a Cuidavet</h1>
                    <p class="description">Cuidavet es un sistema diseñado para gestionar los servicios de una veterinaria de manera eficiente. Nuestro objetivo es brindar la mejor atención para tus mascotas.</p>
                </div>
                
                <!-- Servicios ofrecidos -->
                <div class="services">
                    <h2 class="subtitle">Servicios</h2>
                    <ul class="services-list">
                        <li>Consultas veterinarias</li>
                        <li>Vacunación</li>
                        <li>Cirugías</li>
                        <li>Estética y cuidado</li>
                        <li>Venta de productos para mascotas</li>
                    </ul>
                </div>
                
                <!-- Información adicional -->
                <div class="information">
                    <h2 class="subtitle">Información</h2>
                    <p class="info-text">Contamos con un equipo de profesionales altamente capacitados y con instalaciones modernas para garantizar el bienestar de tus mascotas.</p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
