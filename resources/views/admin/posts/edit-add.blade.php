@extends('admin.master')

@if(isset($post->id))
    @section('page_title','Edit '.$post_type->display_name_singular)
@else
    @section('page_title','Add '.$post_type->display_name_singular)
@endif

@section('css')
    <link rel="stylesheet" href="{!! asset('/css/dropzone.css') !!}"/>
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
        <i class="{{$post_type->icon}}"></i> @if(isset($post->id)){{ 'Edit' }}@else{{ 'New' }}@endif {{$post_type->display_name_singular}}
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <form role="form" action="@if(isset($post->id)){{ route($post_type->slug.'.update', $post->id) }}@else{{ route($post_type->slug.'.store') }}@endif" method="POST" enctype="multipart/form-data">
            <!-- PUT Method if we are editing -->
            @if(isset($post->id))
                {{ method_field("PUT") }}
            @endif
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-8">
                    <!-- ### TITLE ### -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Title
                            </h3>
                            <!-- Nav tabs -->
                            <ul class="trans nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#title-cn" aria-controls="title-cn" role="tab" data-toggle="tab">中文</a></li>
                                <li role="presentation"><a href="#title-en" aria-controls="title-en" role="tab" data-toggle="tab">English</a></li>
                            </ul>

                        </div>

                        <div class="panel-body">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="title-cn">
                                    <input type="text" class="form-control" name="title_cn" placeholder="Title" value="@if(isset($post->{'title:cn'})){{ $post->{'title:cn'} }}@endif">
                                </div>
                                <div role="tabpanel" class="tab-pane" id="title-en">
                                    <input type="text" class="form-control" name="title_en" placeholder="Title" value="@if(isset($post->{'title:en'} )){{ $post->{'title:en'} }}@endif">
                                </div>
                            </div>

                        </div>
                    </div>

                    @if($post_type->name == 'products')
                        <!-- ### IMAGE ### -->
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Image</h3>
                                </div>

                                <div class="panel-body">
                                    <button type="button" class="btn btn-primary dz-clickable" id="upload"><i class="voyager-upload"></i>Upload</button>
                                    <div id="uploadPreview" style="display:none;"></div>

                                    <div id="uploadProgress" class="progress active progress-striped">
                                        <div class="progress-bar progress-bar-success" style="width: 0"></div>
                                    </div>

                                    <ul id="img-preview">
                                        @if(isset($post->image))

                                            @foreach(explode(',', $post->image) as $img)
                                                <li>
                                                    <img class="thumb" src="/product-images/{{ $img }}_100x100.jpg" />
                                                    <p>
                                                        {{ $img }}
                                                    </p>
                                                    <div class="delete">
                                                        <i class="voyager-trash"></i>
                                                    </div>
                                                    <input class="product-images" name="product-images[]" type="hidden" value="{{ $img }}">
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>


                                </div>
                            </div>
                    @endif


                    <!-- ### EXCERPT ### -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Excerpt</h3>
                            <!-- Nav tabs -->
                            <ul class="trans nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#excerpt-cn" aria-controls="excerpt-cn" role="tab" data-toggle="tab">中文</a></li>
                                <li role="presentation"><a href="#excerpt-en" aria-controls="excerpt-en" role="tab" data-toggle="tab">English</a></li>
                            </ul>

                        </div>
                        <div class="panel-body">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="excerpt-cn">
                                    <textarea class="form-control" name="excerpt_cn">@if (isset($post->{'excerpt:cn'})){{ $post->{'excerpt:cn'} }}@endif</textarea>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="excerpt-en">
                                    <textarea class="form-control" name="excerpt_en">@if (isset($post->{'excerpt:en'})){{ $post->{'excerpt:en'} }}@endif</textarea>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- ### CONTENT ### -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Content</h3>
                            <!-- Nav tabs -->
                            <ul class="trans nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#content-cn" aria-controls="content-cn" role="tab" data-toggle="tab">中文</a></li>
                                <li role="presentation"><a href="#content-en" aria-controls="content-en" role="tab" data-toggle="tab">English</a></li>
                            </ul>

                        </div>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="content-cn">
                                <textarea class="richTextBox" name="content_cn" style="border:0px;">
                            @if(isset($post->{'content:cn'})){{ $post->{'content:cn'} }}@endif
                        </textarea>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="content-en">
                                <textarea class="richTextBox" name="content_en" style="border:0px;">
                            @if(isset($post->{'content:en'})){{ $post->{'content:en'} }}@endif
                        </textarea>
                            </div>
                        </div>

                    </div><!-- .panel -->

                    <!-- META -->
                    @if( $post_type->name == 'products')
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">Meta box</h3>
                            </div>
                            <ul class="meta-box">
                                <li class="form-group row">
                                    <label class="col-md-4">资料下载</label>
                                    <select name="meta[resource]" class="col-md-8">
                                        <option></option>
                                        <?php $download_ids = \App\Category::getAllIdFromRoot(23); ?>
                                        @foreach(\App\Post::whereIn('category_id', $download_ids)->get() as $dl_post)
                                            <option value="{{$dl_post->id}}" @if(isset($post->id) && json_decode($post->meta_box, true)['resource'] == $dl_post->id) selected @endif>
                                                {{$dl_post->title}}
                                            </option>
                                        @endforeach
                                    </select>
                                </li>
                                <li class="form-group row">
                                    <label class="col-md-4">应用案例</label>
                                    <select name="meta[application]" class="col-md-8">
                                        <option></option>
                                        <?php $application_ids = \App\Category::getAllIdFromRoot(22); ?>
                                        @foreach(\App\Post::whereIn('category_id', $application_ids)->get() as $app_post)
                                            <option value="{{$app_post->id}}" @if(isset($post->id) && json_decode($post->meta_box, true)['application'] == $app_post->id) selected @endif>
                                                {{$app_post->title}}
                                            </option>
                                        @endforeach
                                    </select>
                                </li>
                            </ul>
                        </div>
                    @endif


                </div>
                <div class="col-md-4">
                    <!-- ### DETAIL ### -->
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-heading">
                            <h4 class="panel-title">Detail</h4>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="name">Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug"
                                       value="@if(isset($post->slug)){{ $post->slug }}@else{{old('slug')}}@endif">
                            </div>

                            @if($post_type->name !== 'pages')
                                <div class="form-group">
                                    <label for="name">Category</label>
                                    @if(isset($post->id))
                                        <select class="form-control" name="category">
                                            <option></option>
                                            @foreach(\App\Category::whereNull('parent_id')->orderBy('order', 'asc')->get() as $root_cate)
                                                <option value="{{ $root_cate->id }}" @if($post->category_id == $root_cate->id) selected @endif>
                                                    {{ $root_cate->{'name:cn'} }}
                                                </option>
                                                @if(count($root_cate->child))
                                                    @foreach($root_cate->child as $child_one)
                                                        <option value="{{ $child_one->id }}" @if($post->category_id == $child_one->id) selected @endif>
                                                            &#8212; {{$child_one->name}}</option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </select>
                                    @else
                                        <select class="form-control" name="category">
                                            <option></option>
                                            @foreach(\App\Category::whereNull('parent_id')->orderBy('order', 'asc')->get() as $root_cate)
                                                <option value="{{ $root_cate->id }}">
                                                    {{ $root_cate->{'name:cn'} }}
                                                </option>
                                                @if(count($root_cate->child))
                                                    @foreach($root_cate->child as $child_one)
                                                        <option value="{{ $child_one->id }}">
                                                            &#8212; {{$child_one->name}}</option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif

                                </div>
                            @endif

                            <div class="form-group">
                                <label for="name">Status</label>
                                <select class="form-control" name="status">
                                    <option value="DRAFT" @if(isset($post->status) && $post->status == 'DRAFT'){{ 'selected="selected"' }}@endif>draft</option>
                                    <option value="PUBLISHED" @if(isset($post->status) && $post->status == 'PUBLISHED'){{ 'selected="selected"' }}@endif>published</option>
                                    <option value="PENDING" @if(isset($post->status) && $post->status == 'PENDING'){{ 'selected="selected"' }}@endif>pending</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <!-- ### SEO CONTENT ### -->
                    <div class="panel panel-bordered panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">SEO</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="nestpanel">
                                    <label for="name">SEO Title</label>
                                    <!-- Nav tabs -->
                                    <ul class="trans nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#seo-title-cn" aria-controls="seo-title-cn" role="tab" data-toggle="tab">中文</a></li>
                                        <li role="presentation"><a href="#seo-title-en" aria-controls="seo-title-en" role="tab" data-toggle="tab">English</a></li>
                                    </ul>
                                </div>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="seo-title-cn">
                                        <input type="text" class="form-control" name="seo_title_cn" value="@if(isset($post->{'seo_title:cn'})){{ $post->{'seo_title:cn'} }}@endif">
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="seo-title-en">
                                        <input type="text" class="form-control" name="seo_title_en" value="@if(isset($post->{'seo_title:en'})){{ $post->{'seo_title:en'} }}@endif">
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="nestpanel">
                                    <label for="name">Meta Description</label>
                                    <!-- Nav tabs -->
                                    <ul class="trans nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#seo-description-cn" aria-controls="seo-description-cn" role="tab" data-toggle="tab">中文</a></li>
                                        <li role="presentation"><a href="#seo-description-en" aria-controls="seo-description-en" role="tab" data-toggle="tab">English</a></li>
                                    </ul>
                                </div>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="seo-description-cn">
                                        <textarea class="form-control" name="seo_description_cn">@if(isset($post->{'seo_description:cn'})){{ $post->{'seo_description:cn'} }}@endif</textarea>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="seo-description-en">
                                        <textarea class="form-control" name="seo_description_en">@if(isset($post->{'seo_description:en'})){{ $post->{'seo_description:en'} }}@endif</textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="nestpanel">
                                    <label for="name">Meta Keywords</label>
                                    <!-- Nav tabs -->
                                    <ul class="trans nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#seo-keywords-cn" aria-controls="seo-keywords-cn" role="tab" data-toggle="tab">中文</a></li>
                                        <li role="presentation"><a href="#seo-keywords-en" aria-controls="seo-keywords-en" role="tab" data-toggle="tab">English</a></li>
                                    </ul>
                                </div>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="seo-keywords-cn">
                                        <textarea class="form-control" name="seo_keywords_cn">@if(isset($post->{'seo_keywords:cn'})){{ $post->{'seo_keywords:cn'} }}@endif</textarea>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="seo-keywords-en">
                                        <textarea class="form-control" name="seo_keywords_en">@if(isset($post->{'seo_keywords:en'})){{ $post->{'seo_keywords:en'} }}@endif</textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <input type="hidden" name="post_type" value="{{ $post_type->id }}">
            <input type="hidden" name="author" value="{{ Auth::id() }}">

            <button type="submit" class="btn btn-primary pull-right">
                @if(isset($post->id)){{ 'Update '.$post_type->display_name_singular }}@else <i class="icon wb-plus-circle"></i> Create New {{$post_type->display_name_singular}} @endif
            </button>

        </form>
    </div>
@stop

@section('javascript')
    <script src="{!! asset('/js/tinymce/tinymce.min.js') !!}"></script>
    <script src="{!! asset('/js/voyager_tinymce.js') !!}"></script>
    <script src="{!! asset('/js/dropzone.js') !!}"></script>
    <script>
        CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $("#upload").dropzone({
            url: "/admin/media/upload",
            previewsContainer: "#uploadPreview",
            createImageThumbnails: false,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            totaluploadprogress: function(uploadProgress, totalBytes, totalBytesSent){
                $('#uploadProgress .progress-bar').css('width', uploadProgress + '%');
                if(uploadProgress == 100){
                    $('#uploadProgress').delay(1500).slideUp(function(){
                        $('#uploadProgress .progress-bar').css('width', '0%');
                    });

                }
            },
            processing: function(){
                $('#uploadProgress').fadeIn();
            },
            sending: function(file, xhr, formData) {
                formData.append("_token", CSRF_TOKEN);
                //formData.append("upload_path", manager.files.path);
            },
            success: function(e, res){
                if(res.success){
                    toastr.success(res.message, "Sweet Success!");
                    console.log(res.image_name);
                    $('#img-preview').append(
                        '<li><img src="/product-images/' + res.image_name + '_100x100.jpg" />' +
                        '<p>' + res.image_name + '</p>' +
                        '<div class="delete"><i class="voyager-trash"></i></div>' +
                        '<input class="product-images" name="product-images[]" type="hidden" value="' + res.image_name + '">' +
                        '</li>'
                    );
                } else {
                    toastr.error(res.message, "Whoopsie!");
                }
            },
            error: function(e, res, xhr){
                toastr.error(res, "Whoopsie");
            },
            //queuecomplete: function(){
              //  getFiles(manager.folders);
            //}
        });



        $('#img-preview').on({
            mouseenter: function () {
                $(this).find('.delete').fadeIn();
            },
            mouseleave: function () {
                $(this).find('.delete').fadeOut();
            }
        }, 'li');

        $('#img-preview').on('click','.delete',function () {
            $(this).parent('li').remove();
        });

    </script>
@stop
