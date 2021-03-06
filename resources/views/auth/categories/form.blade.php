@extends('auth.layouts.master')

@isset($category)
    @section('title', 'Редактировать категорию ' . $category->name)
@else
@section('title', 'Создать категорию')
@endisset

@section('content')
<div class="col-md-12">
    @isset($category)
        <h1>Редактировать Категорию <b>{{ $category->name }}</b></h1>
    @else
        <h1>Добавить Категорию</h1>
    @endisset

    <form method="POST" enctype="multipart/form-data"
        @isset($category) action="{{ route('admin.categories.update', $category) }}"
                      @else
                      action="{{ route('admin.categories.store') }}" @endisset>
        <div>
            @isset($category)
                @method('PUT')
            @endisset
            @csrf
            <div class="input-group row">
                <label for="code" class="col-sm-2 col-form-label">Код: </label>
                <div class="col-sm-6">
                    @error('slug')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <input type="text" class="form-control" name="slug" id="slug"
                        value="{{ old('slug', isset($category) ? $category->slug : null) }}">
                </div>
            </div>
            <br>
            <div class="input-group row">
                <label for="name" class="col-sm-2 col-form-label">Название: </label>
                <div class="col-sm-6">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <input type="text" class="form-control" name="name" id="name"
                        value="@isset($category) {{ $category->name }} @endisset">
                </div>
            </div>
            <br>
            <div class="input-group row">
                <label for="name_en" class="col-sm-2 col-form-label">Название en: </label>
                <div class="col-sm-6">
                    @include('auth.layouts.error', ['fieldName' => 'name_en'])
                    <input type="text" class="form-control" name="name_en" id="name_en"
                           value="@isset($category){{ $category->name_en }}@endisset">
                </div>
            </div>
            <br>
            <div class="input-group row">
                <label for="description" class="col-sm-2 col-form-label">Описание: </label>
                <div class="col-sm-6">
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <textarea name="description" id="description" cols="72" rows="7">
                        @isset($category)
                           {{ $category->description }}
                        @endisset
                    </textarea>
                </div>
            </div>
            <br>
            <div class="input-group row">
                <label for="description_en" class="col-sm-2 col-form-label">Описание en: </label>
                <div class="col-sm-6">
                    @include('auth.layouts.error', ['fieldName' => 'description_en'])
                    <textarea name="description_en" id="description_en" cols="72"
                              rows="7">@isset($category){{ $category->description_en }}@endisset</textarea>
                </div>
            </div>
            <br>

            <div class="input-group row">
                <label for="image" class="col-sm-2 col-form-label">Картинка: </label>
                <div class="col-sm-10">
                    <label class="btn btn-default btn-file">
                        Загрузить <input type="file" style="display: none;" name="image" id="image">
                    </label>
                </div>
            </div>
            <br>

            <button class="btn btn-success">Сохранить</button>
        </div>
    </form>
</div>
@endsection
