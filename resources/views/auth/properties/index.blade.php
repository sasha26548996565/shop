@extends('auth.layouts.master')

@section('title', 'Свойства')

@section('content')
    <div class="col-md-12">
        <h1>Свойства</h1>
        <table class="table">
            <tbody>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Название
                </th>
                <th>
                    Действия
                </th>
            </tr>
            @foreach($properties as $property)
                <tr>
                    <td>{{ $property->id }}</td>
                    <td>{{ $property->name }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <form action="{{ route('admin.properties.destroy', $property->id) }}" method="POST">
                                <a class="btn btn-success" type="button" href="{{ route('admin.properties.show', $property->id) }}"
                                    >Открыть</a>
                                <a class="btn btn-warning" type="button" href="{{ route('admin.properties.edit', $property->id) }}"
                                    >Редактировать</a>
                                <a class="btn btn-primary" type="button" href="{{ route('admin.property-options.index', [$property->id]) }}"
                                        >Варианты свойств</a>
                                @csrf
                                @method('DELETE')
                                <input class="btn btn-danger" type="submit" value="Удалить"></form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a class="btn btn-success" type="button"
           href="{{ route('admin.properties.create') }}">Добавить свойство</a>
    </div>

    {{ $properties->withQueryString()->links('includes.pagination') }}
@endsection
