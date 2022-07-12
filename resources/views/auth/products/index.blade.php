@extends('auth.layouts.master')

@section('title', 'товары')

@section('content')
    <div class="col-md-12">
        <h1>Товары</h1>
        <table class="table">
            <tbody>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Код
                </th>
                <th>
                    Название
                </th>
                <th>
                    Кол-во товарных предложений
                </th>
                <th>
                    Действия
                </th>
            </tr>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->slug }}</td>
                    <td>{{ $product->name }}</td>
                    <td></td>
                    <td>
                        <div class="btn-group" role="group">
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                                <a class="btn btn-success" type="button" href="{{ route('admin.products.show', $product->id) }}"
                                    >Открыть</a>
                                <a class="btn btn-warning" type="button" href="{{ route('admin.products.edit', $product->id) }}"
                                    >Редактировать</a>
                                <a class="btn btn-primary" type="button" href="{{ route('admin.skus.index', $product->id) }}"
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
           href="{{ route('admin.products.create') }}">Добавить товар</a>
    </div>

    {{ $products->withQueryString()->links('includes.pagination') }}
@endsection
