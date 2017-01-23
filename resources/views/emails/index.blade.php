@extends('layout.base')

@section('title', 'Emails enviados')
@section('sectionTitle', 'Emails enviados')

@section('content')
    @unless ($emails->isEmpty())
        {{-- <div class="row">
            {{ Form::open(['url' => '/', 'class' => 'form']) }}
                <div class="col-6">
                    <div class="form-group">
                        {{ Form::label('title', 'Título', ['class' => 'label']) }}
                        {{ Form::input('text', 'title', null, ['class' => 'input']) }}
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col-6 -->
                <div class="col-6">
                    <div class="form-group">
                        {{ Form::label('description', 'Descripción', ['class' => 'label']) }}
                        {{ Form::input('text', 'description', null, ['class' => 'input']) }}
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col-6 -->
            {{ Form::close() }}
        </div>
        <!-- /.row --> --}}
    @endunless
    <div class="row">
        <div class="col-12">
            @if ($emails->isEmpty())
                <div class="empty">
                    <i class="typcn typcn-coffee"></i>
                    <h2 class="title">Aún no se han enviado emails</h2>
                    <!-- /.title -->
                    <a href="{{ url('cotizaciones') }}" class="btn btn-blue">Ir a Cotizaciones</a>
                </div>
                <!-- /.empty -->
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Enviado a</th>
                            <th>Asunto</th>
                            <th>Mensaje</th>
                            <th>Fecha de envío</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($emails as $email)
                            <tr>
                                <td data-th="Enviado a">{{ $email->to }}</td>
                                <td data-th="Asunto">{{ $email->subject }}</td>
                                <td data-th="Mensaje">{{ $email->message }}</td>
                                <td data-th="Fecha de envío">{{ ucfirst(\Date::createFromFormat('Y-m-d H:i:s', $email->created_at)->diffForHumans()) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- /.table -->
            @endif
        </div>
        <!-- /.col-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-12">
            <div class="pagination">
                {{ $emails->links() }}
            </div>
            <!-- /.pagination -->
        </div>
        <!-- /.col-12 -->
    </div>
    <!-- /.row -->
@endsection
