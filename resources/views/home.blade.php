@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <!-- start .flash-message -->
                <div class="flash-message">
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))

                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                        @endif
                    @endforeach
                </div>
                <!-- end .flash-message -->
                <p><a class="btn btn-danger" href="/reset">Volver a cero y repartir</a></p>
                <h3>Total por socio</h3>
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
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
                </div>
                <h3>Historial de lo recaudado esta semana</h3>
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <tr class="active">
                            <td class="col-md-4"><b>Socio</b></td>
                            <td class="col-md-4"><b>Monto</b></td>
                            <td class="col-md-4"><b>Fecha</b></td>
                        </tr>
                        @forelse($operations as $operation)
                            <tr>
                                <td>{{ $operation->user->name }}</td>
                                <td class="alert alert-success">${{ ($operation->amount) }}</td>
                                <td>{{ $operation->date() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Sin operaciones</td>
                            </tr>
                        @endforelse
                    </table>
                    <p>
                        {{ $operations->render() }}
                    </p>
                </div>
                <hr>
                <div class="panel panel-default">
                    <div class="panel-heading">Operar</div>

                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="form-horizontal" method="POST" action="{{url('/home')}}">
                            {{  csrf_field()  }}
                            <div class="row">
                                <div class="col-sm-10 col-sm-offset-1">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="monto">Monto</label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-addon">$</div>
                                                <input id="monto" class="form-control" name="amount" type="number"
                                                       min="1" max="9999999999999999999999999999">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-offset-2 col-sm-10 text-center">
                                        <button type="submit" class="btn btn-info">Ingresar monto</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
