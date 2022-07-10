@extends('auth.layouts.master')

@isset($propertyOption)
    @section('title', 'Редактировать вариант свойства ' . $propertyOption->name)
@else
    @section('title', 'Создать вариант свойства')
@endisset

@section('content')
    <div class="col-md-12">
        @isset($propertyOption)
            <h1>Редактировать вариант свойства <b>{{ $propertyOption->name }}</b></h1>
        @else
            <h1>Добавить вариант свойства <b>{{ $property->name }}</b></h1>
        @endisset

        <form method="POST"
            @isset($propertyOption)
                action="{{ route('admin.property-options.update', [$property->id, $propertyOption]) }}"
            @else
                action="{{ route('admin.property-options.store', $property->id) }}"
            @endisset>
            <div>
                @isset($propertyOption)
                    @method('PUT')
                @endisset

                @csrf

                <div class="input-group row">
                    <label for="name" class="col-sm-2 col-form-label">Название: </label>
                    <div class="col-sm-6">
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" class="form-control" name="name" id="name"
                            value="@isset($propertyOption) {{ $propertyOption->name }} @endisset">
                    </div>
                </div>
                <br>

                <div class="input-group row">
                    <label for="name_en" class="col-sm-2 col-form-label">Название en: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'name_en'])
                        <input type="text" class="form-control" name="name_en" id="name_en"
                            value="@isset($propertyOption){{ $propertyOption->name_en }}@endisset">
                    </div>
                </div>
                <br>

                <button class="btn btn-success">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
