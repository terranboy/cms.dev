@extends('admin.master')

@if(isset($category->id))
    @section('page_title','Edit Category')
@else
    @section('page_title','Add Category')
@endif

@section('css')
    <style>
        .panel .mce-panel {
            border-left-color: #fff;
            border-right-color: #fff;
        }

        .panel .mce-toolbar,
        .panel .mce-statusbar {
            padding-left: 20px;
        }

        .panel .mce-edit-area,
        .panel .mce-edit-area iframe,
        .panel .mce-edit-area iframe html {
            padding: 0 10px;
            min-height: 350px;
        }

        .mce-content-body {
            color: #555;
            font-size: 14px;
        }

        .panel.is-fullscreen .mce-statusbar {
            position: absolute;
            bottom: 0;
            width: 100%;
            z-index: 200000;
        }

        .panel.is-fullscreen .mce-tinymce {
            height:100%;
        }

        .panel.is-fullscreen .mce-edit-area,
        .panel.is-fullscreen .mce-edit-area iframe,
        .panel.is-fullscreen .mce-edit-area iframe html {
            height: 100%;
            position: absolute;
            width: 99%;
            overflow-y: scroll;
            overflow-x: hidden;
            min-height: 100%;
        }
        .panel-bordered>.panel-heading>.panel-title {
            font-size:16px;
            padding:10px 20px;
        }
    </style>
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-categories"></i> @if(isset($category->id)){{ 'Edit' }}@else{{ 'New' }}@endif Category
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">

                    <!-- form start -->
                    <form role="form" action="@if(isset($category->id)){{ route('categories.update', $category->id) }}@else{{ route('categories.store') }}@endif" method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                        @if(isset($category->id))
                            {{ method_field("PUT") }}
                        @endif
                        {{ csrf_field() }}

                        <div class="panel-body">

                            <!-- If we are editing -->
                            <div class="extra form-group">
                                <label for="name">Name</label>
                                <!-- Nav tabs -->
                                <ul class="trans nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#name-cn" aria-controls="name-cn" role="tab" data-toggle="tab">中文</a></li>
                                    <li role="presentation"><a href="#name-en" aria-controls="name-en" role="tab" data-toggle="tab">English</a></li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="name-cn">
                                        <input type="text" class="form-control" name="name_cn" value="@if(isset($category->{'name:cn'})){{ $category->{'name:cn'} }}@endif">
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="name-en">
                                        <input type="text" class="form-control" name="name_en" value="@if(isset($category->{'name:en'})){{ $category->{'name:en'} }}@endif">
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="name">Slug</label>
                                <input type="text" class="form-control" name="slug" value="@if(isset($category->slug)){{ $category->slug}}@else{{ old('slug') }} @endif">
                            </div>

                            <div class="form-group">
                                <label for="name">Order</label>
                                <input type="text" class="form-control" name="order" value="@if(isset($category->order)){{ $category->order}}@else 1 @endif">

                            </div>

                            <div class="form-group">
                                <label for="name">Parent category</label>

                                @if(isset($category->id))

                                    @if(count($category->child))
                                        <select id="categories" class="form-control" name="parent_category" disabled="disabled"></select>
                                    @else
                                        <select id="categories" class="form-control" name="parent_category">
                                            <option></option>
                                            @foreach(\App\Category::whereNull('parent_id')->get() as $cate)
                                                <option value="{{ $cate->id }}"
                                                        @if($category->parent_id == $cate->id) selected @endif
                                                >
                                                    {{ $cate->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif

                                @else
                                    <select id="categories" class="form-control" name="parent_category">
                                        <option></option>
                                        @foreach(\App\Category::whereNull('parent_id')->get() as $cate)
                                            <option value="{{ $cate->id }}">
                                                {{ $cate->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif


                            </div>

                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@stop

