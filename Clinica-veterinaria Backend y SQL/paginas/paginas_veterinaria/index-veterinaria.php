<!-- header -->
<header class = "container px-5">
    <div class="header-content py-3">
        <div class="row">
            <div class="col-md text-center m-3 header-head">
                <h2>Lorem ipsum dolor sit amet.</h2>
            </div>
        </div>
        <div class="row px-5 py-3">
            <div class="col-12 col-md-4 header-left">
                <div class="card w-75 card-border card-reaccion d-flex justify-content-center">
                    <a href="<?php echo SERVERURL; ?>cliente-registro/"><img src="<?php echo SERVERURL; ?>paginas/imagenes/card-01.jpg" class="card-img-top img-reaccion" alt="..."></a>
                    <div class="card-body text-center">
                        <h5 class="card-title text-shadow">Clientes</h5>
                        <p class="card-text">Lorem ipsum dolor, sit amet consectetur adipisicing.</p>
                    </div>
                    </div>
            </div>
            <div class="col-12 col-md-4 header-top">
                <div class="card w-75 card-border card-reaccion d-flex justify-content-center">
                    <a href="<?php echo SERVERURL; ?>mascota-registro/"><img src="<?php echo SERVERURL; ?>paginas/imagenes/card-02.jpeg" class="card-img-top img-reaccion" alt="..."></a>
                    <div class="card-body text-center">
                        <h5 class="card-title text-shadow">Mascotas</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
                    </div>
                    </div>
            </div>
            <div class="col-12 col-md-4 header-right">
                <div class="card w-75 card-border card-reaccion d-flex justify-content-center">
                    <a href="<?php echo SERVERURL; ?>index#galeria-mascotas"><img src="<?php echo SERVERURL; ?>paginas/imagenes/card-03.jpeg" class="card-img-top img-reaccion" alt="..."></a>
                    <div class="card-body text-center">
                        <h5 class="card-title text-shadow">Galeria</h5>
                        <p class="card-text">Lorem ipsum dolor, sit amet consectetur adipisicing.</p>
                    </div>
                    </div>
            </div>
        </div>
    </div>
</header>

<!-- Separador -->
<div id = "galeria-mascotas" class = "container-fluid py-5 header-buttom">
    <div id = "encuadre" class = "container w-50 ps-5 rounded">
        <div class = "row aling-items-center">
            <div class = "col-md p-2">
                <img src="<?php echo SERVERURL; ?>paginas/imagenes/separador.png" alt="" class = "w-75 mx-auto d-block">
            </div>
            <div class = "col-md p-5 text-center">
                <p class = "text-shadow h3"><br>Galeria</p>
                <h4 class = "text-shadow h2">Mascotas que estan en adopcion.</h4>
            </div>
        </div>
    </div>
</div>

<!-- Carrusel de imagenes -->
<section class = "container">
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="<?php echo SERVERURL; ?>paginas/imagenes/slide-1.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="<?php echo SERVERURL; ?>paginas/imagenes/slide-2.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="<?php echo SERVERURL; ?>paginas/imagenes/slide-3.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

</section>