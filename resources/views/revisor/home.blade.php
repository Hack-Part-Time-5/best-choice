<x-layout>
    <x-slot name='title'>BestChoice - Revisor Home</x-slot>
    @if ($ad)

    <div class='container my-3'>
        <div class='row'>
            <div class='col-12'>
                <div class="card">
                    <div class="card-header">
                        {{__('Anuncio')}} #{{ $ad->id }}
                    </div>
                    <div class="card-body">
                        <div class="row mx-3">
                            <div class="col-md-3">
                                <b>{{__('Usuario')}}:</b>
                            </div>
                            <div class="col-md-9">
                                #{{ $ad->user->id }} - {{ $ad->user->name }} - {{ $ad->user->email }}
                            </div>
                            <hr>
                            <div class="col-md-3">
                                <b>{{__('Título')}}:</b>
                            </div>
                            <div class="col-md-9">
                                {{ $ad->title }}
                            </div>
                            <hr>
                            <div class="col-md-3">
                                <b>{{__('Precio')}}:</b>
                            </div>
                            <div class="col-md-9">
                                {{ __($ad->price) }}€
                            </div>
                            <hr>
                            <div class="col-md-3">
                                <b>{{__('Descripción')}}:</b>
                            </div>
                            <div class="col-md-9">
                                {{ __($ad->body) }}
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-md-3">
                                    <b>{{__('Categoría')}}:</b>
                                </div>
                                <div class="col-md-9">
                                    {{ __($ad->category->name) }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-3">
                                    <b>{{__('Fecha de creación')}}:</b>
                                </div>
                                <div class="col-md-9">
                                    {{ $ad->created_at }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-3">
                                    <b>{{__('Imágenes') }}:</b>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        @forelse ($ad->images as $image)
                                        <div class="col-md-4">
                                            <img src="{{ $image->getUrl(400, 400) ?? 'https://via.placeholder.com/150'}}"
                                                class="card-img-top img-fluid" alt="...">
                                        </div>
                                        <div class="col-md-8">
                                            <b>Safe Search</b><br>
                                            <b>Adult: </b><i class="bi bi-circle-fill {{ $image->adult }}"></i>
                                            [{{ $image->adult }}] <br>

                                            <b>Spoof: </b><i class="bi bi-circle-fill {{ $image->spoof }}"></i>
                                            [{{ $image->spoof }}] <br>

                                            <b>Medical: </b><i class="bi bi-circle-fill {{ $image->medical }}"></i>
                                            [{{ $image->medical }}] <br>

                                            <b>Violence: </b><i class="bi bi-circle-fill {{ $image->violence }}"></i>
                                            [{{ $image->violence }}] <br>

                                            <b>Racy: </b><i class="bi bi-circle-fill {{ $image->racy }}"></i>
                                            [{{ $image->racy }}]
                                            <br><br>


                                            <b>Labels </b><br>
                                            @forelse ($image->getLabels() as $label)
                                            <a href="#" class="btn btn-info btn-sm m-1">{{ $label }}</a>
                                            @empty
                                            No labels
                                            @endforelse
                                            <br><br>

                                            <b>Id: </b>{{ $image->id }} <br>
                                            <b>URI: </b>{{ Storage::url($image->path) }} <br>
                                        </div>
                                        @empty
                                        <div class="col-12">
                                            <b>{{__('No hay imágenes') }}</b>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-6">
                        <form action="{{ route('revisor.ad.reject',$ad) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-danger">{{__('Rechazar')}}</button>
                        </form>
                    </div>
                    <div class="col-6 text-end">
                        <form action="{{ route('revisor.ad.accept',$ad) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-success">{{__('Aceptar')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @else
        <h3 class="text-center mt-5">{{__('No hay anuncios para revisar, vuelve más tarde, gracias!')}}</h3>

        @endif
</x-layout>
