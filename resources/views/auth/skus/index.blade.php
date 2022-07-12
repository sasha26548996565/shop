@extends('auth.layouts.master')

@section('title', 'skus')

@section('content')
    <div class="col-md-12">
        <h1>skus</h1>
        <table class="table">
            <tbody>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Товарное предложение (свойства)
                </th>
                <th>
                    Действия
                </th>
            </tr>
            @foreach($skus as $sku)
                <tr>
                    <td>{{ $sku->id }}</td>
                    <td>{{ $sku->propertyOptions->map->name->implode(',') }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <form action="{{ route('admin.skus.destroy', [$product->id, $sku->id]) }}" method="POST">
                                <a class="btn btn-success" type="button" href="{{ route('admin.skus.show', [$product->id, $sku->id]) }}"
                                    >Открыть</a>
                                <a class="btn btn-warning" type="button" href="{{ route('admin.skus.edit', [$product->id, $sku->id]) }}"
                                    >Редактировать</a>
                                <a class="btn btn-primary" type="button" href="{{ route('admin.skus.index', [$product->id, $sku->id]) }}"
                                        >Sku</a>
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
           href="{{ route('admin.skus.create', $product->id) }}">Добавить sku</a>
    </div>

    {{ $skus->withQueryString()->links('includes.pagination') }}
@endsection
