@extends('auth.layouts.master')

@isset($sku)
    @section('title', 'Редактировать sku ' . $sku->name)
@else
    @section('title', 'Создать sku')
@endisset

@section('content')
    <div class="col-md-12">
        @isset($sku)
            <h1>Редактировать sku <b>{{ $sku->name }}</b></h1>
        @else
            <h1>Добавить sku</h1>
        @endisset
        <form method="POST"
              @isset($sku)
              action="{{ route('admin.skus.update', [$product->id, $sku->id]) }}"
              @else
              action="{{ route('admin.skus.store', $product->id) }}"
            @endisset>

            <div>
                @isset($sku)
                    @method('PUT')
                @endisset

                @csrf

                <div class="input-group row">
                    <label for="price" class="col-sm-2 col-form-label">Цена: </label>
                    <div class="col-sm-2">
                        @include('auth.layouts.error', ['fieldName' => 'price'])
                        <input type="text" class="form-control" name="price" class="form-control"
                               value="@isset($sku){{ $sku->price }}@endisset">
                    </div>
                </div>
                <br>

                <div class="input-group row">
                    <label for="count" class="col-sm-2 col-form-label">Кол-во: </label>
                    <div class="col-sm-2">
                        @include('auth.layouts.error', ['fieldName' => 'count'])
                        <input type="text" class="form-control" name="count" class="form-control"
                               value="@isset($sku){{ $sku->count }}@endisset">
                    </div>
                </div>
                <br>
                @foreach ($product->properties as $property)
                    <div class="input-group row">
                        <label for="property_ids[{{ $property->id }}]" class="col-sm-2 col-form-label">{{ $property->name }}: </label>
                        <div class="col-sm-6">
                            @include('auth.layouts.error', ['fieldName' => 'property_id'])
                            <select name="property_ids[{{ $property->id }}]" id="property_id" class="form-control">
                                @foreach($property->propertyOptions as $propertyOption)
                                    <option value="{{ $propertyOption->id }}"
                                        @selected(isset($sku) && $sku->propertyOptions->contains($propertyOption->id))
                                    >{{ $propertyOption->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                @endforeach

                <button class="btn btn-success">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
