<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema</title>

    <!--CSS BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Enlace a la hoja de estilos CSS -->
    <link rel="stylesheet" href="{{ asset('css/Cartelera.css') }}">

    <script src="https://kit.fontawesome.com/c494e3bce7.js" crossorigin="anonymous"></script>
</head>
<body>

        <script>
        document.getElementById('searchButton').addEventListener('click', function() {
            var searchTerm = document.getElementById('searchInput').value.toLowerCase();
            var searchResults = document.getElementById('searchResults');
            var found = false;

            searchResults.innerHTML = ''; // Limpiar resultados anteriores

            // Obtener todos los elementos en el contenedor
            var elements = document.querySelectorAll('#container-to-search [data-searchable]');

            elements.forEach(function(element) {
                var text = element.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    // Mostrar el elemento si se encuentra el término de búsqueda en su texto
                    searchResults.appendChild(element.cloneNode(true));
                    found = true;
                }
            });

            // Mostrar mensaje si no se encontraron resultados
            if (!found) {
                searchResults.innerHTML = '<p>No se encontraron resultados.</p>';
            }
        });
        </script>
        
        <nav class="navbar navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('crud.index') }}">
                    <img src="images/Cineco.jpg" alt="Logo" width="100" height="60" class="d-inline-block align-text-top">
                </a>
                <form action="{{ route('buscar') }}" method="GET">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Buscar película o actor" name="searchTerm">
                        <button class="btn custom-btn" type="submit">Buscar</button>
                    </div>
                </form>
            </div>
        </nav>


    <h1 class="text-center p-1 titulo-peliculas ">Peliculas en cartelera</h1>

    @if(session("correcto"))
        <div class="alert alert-success">{{session("correcto")}}</div>
    @endif

    @if(session("incorrecto"))
        <div class="alert alert-danger">{{session("incorrecto")}}</div>
    @endif

    <script>
        var res = function() {
            var not = confirm("¿Estás seguro de eliminar la película?");
            return not;
        };
    </script>

    <!-- Modal de Crear -->
    <div class="modal fade" id="ModalCrear" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar una película</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para Registrar una Película -->
                    <form method="POST" action="{{ route('crud.create') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre de la Película</label>
                            <input type="text" class="form-control" id="nombre" name="txtnombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción de la Película</label>
                            <input type="text" class="form-control" id="descripcion" name="txtdescripcion" required>
                        </div>
                        <div class="mb-3">
                            <label for="cartelera" class="form-label">Cartelera de la Película</label>
                            <input type="file" class="form-control" id="cartelera" name="cartelera" required>
                        </div>
                        <div class="mb-3">
                            <label for="elenco" class="form-label">Elenco de la Película</label>
                            <input type="text" class="form-control" id="elenco" name="txtelenco" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <div class="p-5 table-responsive">
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#ModalCrear">Añadir película</button>
        <table class="table table-bordered table-hover">
            <thead class="table-info">
                <tr>
                    <th scope="col">CODIGO</th>
                    <th scope="col">NOMBRE</th>
                    <th scope="col">DESCRIPCIÓN</th>
                    <th scope="col">CARTELERA</th>
                    <th scope="col">ELENCO</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datos as $item)
                <tr>
                    <th scope="row" class="text-center align-middle">{{$item->id}}</th>
                    <td class="align-middle">{{$item->nombre}}</td>
                    <td class="align-middle" style="text-align: justify;">{{$item->descripcion}}</td>
                    <td>
                        @if ($item->cartelera)
                            <img src="{{ asset('carteles/' . $item->cartelera) }}" alt="Cartelera" style="max-width: 100px;">
                        @else
                            No hay imagen disponible
                        @endif
                    </td>
                    <td>{{$item->elenco}}</td>
                    <td class="align-middle">
                        <!-- Boton Editar -->
                        <a href="" data-bs-toggle="modal" data-bs-target="#ModalEditar{{$item->id}}" class="btn btn-sm"><i class="fa-solid fa-pen-to-square" style="color: #FFD43B;"></i></a>
                        <!-- Boton Eliminar -->
                        <a href="{{route('crud.delete',$item->id)}}" onclick="return res()" class="btn btn-sm"><i class="fa-solid fa-eraser" style="color: #ed0c39;"></i></a>
                    </td>

                    <!-- Modal de Modificar -->
                    <div class="modal fade" id="ModalEditar{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar datos de la película</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Formulario para Modificar -->
                                    <form method="POST" action="{{route('crud.update')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="txtcodigo" class="form-label">Código de la Película</label>
                                            <input type="text" class="form-control" id="txtcodigo" name="txtcodigo" value="{{$item->id}}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="txtnombre" class="form-label">Nombre de la Película</label>
                                            <input type="text" class="form-control" id="txtnombre" name="txtnombre" value="{{$item->nombre}}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="txtdescripcion" class="form-label">Descripción de la Película</label>
                                            <input type="text" class="form-control" id="txtdescripcion" name="txtdescripcion" value="{{$item->descripcion}}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="txtcartelera" class="form-label">Cartelera de la Película</label>
                                            <!-- Mostrar imagen actual de la película -->
                                            <img src="{{ asset('carteles/' . $item->cartelera) }}" alt="Cartelera" style="max-width: 100px;">
                                            <!-- Campo de carga de nueva imagen -->
                                            <input type="file" class="form-control mt-2" id="txtcartelera" name="cartelera" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="txtelenco" class="form-label">Elenco de la Película</label>
                                            <input type="text" class="form-control" id="txtelenco" name="txtelenco" value="{{$item->elenco}}" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Modificar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <!-- Botón "Anterior" -->
            <li class="page-item">
                <a class="page-link" href="{{ $datos->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Anterior</span>
                </a>
            </li>

            <!-- Números de página -->
            @for ($i = 1; $i <= $datos->lastPage(); $i++)
                <li class="page-item {{ $i == $datos->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $datos->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            <!-- Botón "Siguiente" -->
            <li class="page-item">
                <a class="page-link" href="{{ $datos->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Siguiente</span>
                </a>
            </li>
        </ul>
    </nav>

    <!--JS BOOTSTRAP-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
