@extends('admin.layouts.master')

@section('head-tag')
    <title>فرصت شغلی - ویرایش</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="">بخش تماس با ما</a></li>
            <li class="breadcrumb-item font-size-12 active"><a href="{{ route('admin.job-opportunities.index') }}">فرصت های
                    شغلی</a></li>
            </li>
            </li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">ویرایش</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش فرصت شغلی
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.job-opportunities.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{ route('admin.job-opportunities.update', $job) }}" method="POST" id="form"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <section class="row">
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="title">عنوان</label>
                                    <input type="text" class="form-control form-control-sm" name="title"
                                        value="{{ old('title', $job->title) }}" id="title">
                                </div>
                                @error('title')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="image">تصویر</label>
                                    <input type="file" class="form-control form-control-sm" name="image_path"
                                        id="image">
                                </div>
                                @if ($job->image_path)
                                    <a href="{{ asset($job->image_path) }}" target="_blank">
                                        <img src="{{ asset($job->image_path) }}" alt="{{ $job->title }}" width="50">
                                    </a>
                                @endif
                                @error('image_path')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="description">توضیحات</label>
                                    <textarea name="description" id="description" cols="30" rows="5" class="form-control">{{ old('description', $job->description) }}</textarea>
                                </div>
                                @error('description')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 mt-3">
                                <button class="btn btn-primary btn-sm">ویرایش</button>
                            </section>
                        </section>
                    </form>
                </section>
            </section>
        </section>
    </section>
@endsection
@section('script')
    <script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
@endsection
