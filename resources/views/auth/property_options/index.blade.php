@extends('auth.layouts.master')

@section('title', 'Варианты свойств')

@section('content')
    <div class="col-md-12">
        <h1>Варианты свойств</h1>
        <table class="table">
            <tbody>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Свойсвто
                </th>
                <th>
                    Название
                </th>
                <th>
                    Действия
                </th>
            </tr>
            @foreach($propertyOptions as $propertyOption)
                <tr>
                    <td>{{ $propertyOption->id }}</td>
                    <td>{{ $property->name }}</td>
                    <td>{{ $propertyOption->name }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <form action="{{ route('admin.property-options.destroy', [$property->id, $propertyOption->id]) }}" method="POST">
                                <a class="btn btn-success" type="button" href="{{ route('admin.property-options.show', [$property->id,
                                    $propertyOption->id]) }}"
                                    >Открыть</a>
                                <a class="btn btn-warning" type="button" href="{{ route('admin.property-options.edit', [$property->id,
                                    $propertyOption->id]) }}"
                                    >Редактировать</a>
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
           href="{{ route('admin.property-options.create', [$property->id]) }}">Добавить Вариант свойства</a>
    </div>

    {{ $propertyOptions->withQueryString()->links('includes.pagination') }}
@endsection
