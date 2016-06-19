@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <h3>Numeros finales</h3>
                        <tr class="active">
                            <td class="col-md-6"><b>Socio</b></td>
                            <td class="col-md-6"><b>Monto total</b></td>
                        </tr>
                        @forelse($stats as $stat)
                            <tr>
                                <td class="col-md-6">{{$stat->name}}</td>
                                <td class="col-md-6">${{(empty($stat->sum))?'0.00':$stat->sum}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">Falta información</td>
                            </tr>
                        @endforelse
                    </table>
                    {!! $message !!}
                    <p class="text-center">
                        <a class="btn btn-danger" href="/confirm_reset">Volver a cero</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
