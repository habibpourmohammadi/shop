@extends('home.layouts.master')

@section('title')
    <title>فروشگاه اینترنتی کالا نت - آدرس ها</title>
@endsection
@section('content')
    <!-- start body -->

    <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            <section class="row">
                <aside id="sidebar" class="sidebar col-md-3">
                    @include('home.account.layouts.sidebar')
                </aside>
                <main id="main-body" class="main-body col-md-9">
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            @foreach ($errors->all() as $error)
                                <strong class="text-dark">{{ $error }}</strong><br>
                            @endforeach
                        </div>
                    @endif
                    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                        <!-- start vontent header -->
                        <section class="content-header mb-4">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>آدرس های من</span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <!-- end vontent header -->

                        <section class="my-addresses">
                            <form action="{{ route('home.profile.myAddresses.update', $address) }}" method="POST"
                                class="address-add-wrapper" onsubmit="return myAddressForm()">
                                @csrf
                                @method('PUT')
                                <!-- start add address Modal -->
                                <section class="" id="add-address">
                                    <section class="modal-dialog">
                                        <section class="modal-content">
                                            <section class="modal-header">
                                                <h5 class="modal-title" id="add-address-label"><i class="fa fa-edit"></i>
                                                    ویرایش آدرس جدید</h5>
                                            </section>
                                            <section class="modal-body">
                                                <section class="row">
                                                    <section class="col-12 col-md-6 mb-2">
                                                        <label for="province_select" class="form-label mb-1">استان <strong
                                                                class="text-danger">*</strong></label>
                                                        <select id="province_select" class="form-select form-select-sm"
                                                            name="province_id">
                                                            <option value="">انتخاب استان</option>
                                                            @foreach ($provinces as $province)
                                                                <option @selected(old('province_id', $address->province_id) == $province->id)
                                                                    value="{{ $province->id }}">{{ $province->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </section>
                                                    <section class="col-12 col-md-6 mb-2">
                                                        <label for="city_select" class="form-label mb-1">شهر <strong
                                                                class="text-danger">*</strong></label>
                                                        <select class="form-select form-select-sm" id="city_select"
                                                            name="city_id">
                                                            <option value="">انتخاب شهر</option>
                                                        </select>
                                                    </section>
                                                    <section class="col-12 col-md-12">
                                                        <label for="mobile" class="form-label mb-1">شماره تماس <strong
                                                                class="text-danger">*</strong></label>
                                                        <input type="number" name="mobile" id="mobile"
                                                            class="form-control form-control-sm"
                                                            value="{{ old('mobile', $address->mobile) }}">
                                                        <small class="text-danger"><strong
                                                                id="mobileError"></strong></small>
                                                    </section>
                                                    <section class="col-12 mb-2">
                                                        <label for="address" class="form-label mb-1">نشانی <strong
                                                                class="text-danger">*</strong></label>
                                                        <input type="text" class="form-control form-control-sm"
                                                            id="address" placeholder="نشانی" name="address"
                                                            value="{{ old('address', $address->address) }}">
                                                        <small class="text-danger"><strong
                                                                id="addressError"></strong></small>
                                                    </section>

                                                    <section class="col-6 mb-2">
                                                        <label for="postal_code" class="form-label mb-1">کد پستی <strong
                                                                class="text-danger">*</strong></label>
                                                        <input type="number" class="form-control form-control-sm"
                                                            id="postal_code" placeholder="کد پستی" name="postal_code"
                                                            value="{{ old('postal_code', $address->postal_code) }}">
                                                        <small class="text-danger"><strong
                                                                id="postalCodeError"></strong></small>
                                                    </section>

                                                    <section class="col-3 mb-2">
                                                        <label for="no" class="form-label mb-1">پلاک</label>
                                                        <input type="number" class="form-control form-control-sm"
                                                            id="no" placeholder="پلاک" name="no"
                                                            value="{{ old('no', $address->no) }}">
                                                        <small class="text-danger"><strong id="noError"></strong></small>
                                                    </section>

                                                    <section class="col-3 mb-2">
                                                        <label for="unit" class="form-label mb-1">واحد</label>
                                                        <input type="number" class="form-control form-control-sm"
                                                            id="unit" placeholder="واحد" name="unit"
                                                            value="{{ old('unit', $address->unit) }}">
                                                        <small class="text-danger"><strong
                                                                id="unitError"></strong></small>
                                                    </section>

                                                    <section class="border-bottom mt-2 mb-3"></section>

                                                    <section class="col-12 mb-2">
                                                        <section class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" name="receiver" id="receiver"
                                                                @checked($address->recipient_first_name == null)>
                                                            <label class="form-check-label" for="receiver">
                                                                گیرنده سفارش خودم هستم
                                                            </label>
                                                        </section>
                                                    </section>

                                                    <section class="row" id="recipient">
                                                        <section class="col-6 mb-2">
                                                            <label for="first_name" class="form-label mb-1">نام
                                                                گیرنده <strong class="text-danger">*</strong></label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="first_name" placeholder="نام گیرنده"
                                                                name="recipient_first_name"
                                                                value="{{ old('recipient_first_name', $address->recipient_first_name) }}">
                                                            <small class="text-danger"><strong
                                                                    id="recipientFirstNameError"></strong></small>
                                                        </section>

                                                        <section class="col-6 mb-2">
                                                            <label for="last_name" class="form-label mb-1">نام خانوادگی
                                                                گیرنده <strong class="text-danger">*</strong></label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="last_name" placeholder="نام خانوادگی گیرنده"
                                                                name="recipient_last_name"
                                                                value="{{ old('recipient_last_name', $address->recipient_last_name) }}">
                                                            <small class="text-danger"><strong
                                                                    id="recipientLastNameError"></strong></small>
                                                        </section>

                                                        <section class="col-6 mb-2">
                                                            <label for="recipient_mobile" class="form-label mb-1">شماره
                                                                موبایل <strong class="text-danger">*</strong></label>
                                                            <input type="number" class="form-control form-control-sm"
                                                                id="recipient_mobile" placeholder="شماره موبایل"
                                                                name="recipient_mobile"
                                                                value="{{ old('recipient_mobile', $address->recipient_mobile) }}">
                                                            <small class="text-danger"><strong
                                                                    id="recipientMobileError"></strong></small>
                                                        </section>
                                                    </section>

                                                </section>
                                            </section>
                                            <section class="modal-footer justify-content-start py-1">
                                                <button type="submit" class="btn btn-sm btn-primary">ویرایش آدرس</button>
                                            </section>
                                        </section>
                                    </section>
                                </section>
                                <!-- end add address Modal -->
                            </form>
                        </section>
                    </section>
                </main>
            </section>
        </section>
    </section>
    <input type="hidden" id="cities_url" value="{{ route('home.profile.myAddresses.getCities') }}" class="d-none">
    <!-- end body -->
@endsection
@section('script')
    <script src="{{ asset('home-assets/js/home/add-address.js') }}"></script>
    <script src="{{ asset('home-assets/js/home/get-cities.js') }}"></script>
@endsection
