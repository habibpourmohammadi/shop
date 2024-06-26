@extends('home.layouts.master')
@section('title')
    <title>فروشگاه اینترنتی کالا نت | فرصت های شغلی - {{ $job->title }}</title>
@endsection
@section('content')
    <div class="mb-3 mx-3">
        <span
            class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row hover:bg-gray-100">
            <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-lg ms-2"
                src="{{ asset($job->image_path) }}" alt="">
            <div class="flex flex-col justify-between p-4 leading-normal">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">فرصت شغلی :
                    {{ $job->title }}</h5>
                <p class="mb-3 font-normal text-gray-700">
                    {!! $job->description !!}
                </p>
            </div>
        </span>
    </div>
    <hr>
    <div class="my-3 ms-3">
        <span class="font-bold border-1 border-b-red-700 pe-4">ثبت درخواست :</span>
    </div>
    <form action="{{ route('home.job-opportunities.submitJobRequest', $job) }}" method="POST" enctype="multipart/form-data"
        class="max-w-lg mx-auto my-3 bg-gray-300 py-6 px-8 rounded-lg shadow-md">
        @csrf
        <div class="mb-3">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file">
                لطفاً رزومه خود را انتخاب کنید <span class="text-red-800 font-bold">*</span>
            </label>
            <input class="block w-full text-sm border-gray-300 rounded-lg cursor-pointer bg-gray-50" id="file"
                type="file" name="file_path">
            @error('file_path')
                <span class="text-red-700 font-bold text-sm d-block pt-2">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="block mb-2 text-sm font-medium ms-1">
                توضیحات درباره تجارب (اختیاری) :
            </label>
            <textarea name="description" id="description" cols="30" rows="5"
                placeholder="توضیحات تجارب (اختیاری) - اگر دارید، تجربیات خود را در اینجا وارد کنید."
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
            @error('description')
                <span class="text-red-700 font-bold text-sm d-block pt-2">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit"
            class="text-white mt-3 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">ارسال
            درخواست</button>
    </form>
    </div>
@endsection
