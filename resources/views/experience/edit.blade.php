@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            @if (session()->has('error'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong> {{ session('error') }}</strong>
                    <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card mb-2">
                <div class="card-header pb-0">
                    <h6>Form Edit Example Lamaran</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('experience.update', $exp->id) }}" method="post" class="form-experience"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="form-group">
                                    <label for="nama">Nama <span style="color: red;">*</span></label>
                                    <input type="text" value="{{ old('nama', $exp->nama) }}"
                                        class="form-control @error('nama') is-invalid @enderror" autofocus
                                        autocomplete="off" required name="nama" id="nama">
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="5">{{ old('alamat', $exp->alamat) }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="no_ktp">No KTP <span style="color: red;">*</span></label>
                                    <input type="number" value="{{ old('no_ktp', $exp->no_ktp) }}"
                                        class="form-control @error('no_ktp') is-invalid @enderror" autofocus
                                        autocomplete="off" required name="no_ktp" id="no_ktp">
                                    @error('no_ktp')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <label>Pendidikan: </label>
                                @if (count($exp->educations) > 0)
                                    @foreach ($exp->educations as $key => $item)
                                        <div class="row dynamic-education" id="dynamic-education-{{ $key + 1 }}">
                                            <div class="col md-12">
                                                <div class="row align-items-center">
                                                    <div class="col-md-2">
                                                        <div class="row mt-3">
                                                            <div class="col-md-12">
                                                                <div class="clearfix">
                                                                    <button type="button"
                                                                        onclick="return addNewEducation(this)"
                                                                        id="add-button"
                                                                        class="btn btn-sm btn-primary float-start text-uppercase "><i
                                                                            class="fa fa-plus"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                        onclick="return removeLastEducation(this)"
                                                                        id="remove-button"
                                                                        class="btn btn-sm btn-danger float-start text-uppercase ms-1"><i
                                                                            class="fa fa-minus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Nama Sekolah / Universitas <span
                                                                            style="color: red;">*</span></label>
                                                                    <input type="text" autocomplete="off"
                                                                        class="form-control" name="nama_sekolah[]"
                                                                        value="{{ $item->nama_sekolah }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Jurusan <span
                                                                            style="color: red;">*</span></label>
                                                                    <input type="text" autocomplete="off"
                                                                        class="form-control" name="jurusan[]"
                                                                        value="{{ $item->jurusan }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Tahun Masuk <span
                                                                            style="color: red;">*</span></label>
                                                                    <input type="number" autocomplete="off"
                                                                        class="form-control" name="tahun_masuk[]"
                                                                        value="{{ $item->tahun_masuk }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Tahun Lulus <span
                                                                            style="color: red;">*</span></label>
                                                                    <input type="number" autocomplete="off"
                                                                        class="form-control" name="tahun_lulus[]"
                                                                        value="{{ $item->tahun_lulus }}">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row dynamic-education" id="dynamic-education-1">
                                        <div class="col md-12">
                                            <div class="row align-items-center">
                                                <div class="col-md-2">
                                                    <div class="row mt-3">
                                                        <div class="col-md-12">
                                                            <div class="clearfix">
                                                                <button type="button"
                                                                    onclick="return addNewEducation(this)" id="add-button"
                                                                    class="btn btn-sm btn-primary float-start text-uppercase "><i
                                                                        class="fa fa-plus"></i>
                                                                </button>
                                                                <button type="button"
                                                                    onclick="return removeLastEducation(this)"
                                                                    id="remove-button"
                                                                    class="btn btn-sm btn-danger float-start text-uppercase ms-1"><i
                                                                        class="fa fa-minus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Nama Sekolah / Universitas <span
                                                                        style="color: red;">*</span></label>
                                                                <input type="text" autocomplete="off"
                                                                    class="form-control" name="nama_sekolah[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Jurusan <span style="color: red;">*</span></label>
                                                                <input type="text" autocomplete="off"
                                                                    class="form-control" name="jurusan[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Tahun Masuk <span
                                                                        style="color: red;">*</span></label>
                                                                <input type="number" autocomplete="off"
                                                                    class="form-control" name="tahun_masuk[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Tahun Lulus <span
                                                                        style="color: red;">*</span></label>
                                                                <input type="number" autocomplete="off"
                                                                    class="form-control" name="tahun_lulus[]">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <label>Pengalaman Kerja: </label>
                                @if (count($exp->works) > 0)
                                    @foreach ($exp->works as $key => $item)
                                        <div class="row dynamic-work" id="dynamic-work-{{ $key + 1 }}">
                                            <div class="col md-12">
                                                <div class="row align-items-center">
                                                    <div class="col-md-2">
                                                        <div class="row mt-3">
                                                            <div class="col-md-12">
                                                                <div class="clearfix">
                                                                    <button type="button"
                                                                        onclick="return addNewWork(this)" id="add-button"
                                                                        class="btn btn-sm btn-primary float-start text-uppercase "><i
                                                                            class="fa fa-plus"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                        onclick="return removeLastWork(this)"
                                                                        id="remove-button"
                                                                        class="btn btn-sm btn-danger float-start text-uppercase ms-1"><i
                                                                            class="fa fa-minus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Perusahaan <span
                                                                            style="color: red;">*</span></label>
                                                                    <input type="text" autocomplete="off"
                                                                        class="form-control" name="perusahaan[]"
                                                                        value="{{ $item->perusahaan }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Jabatan <span
                                                                            style="color: red;">*</span></label>
                                                                    <input type="text" autocomplete="off"
                                                                        class="form-control" name="jabatan[]"
                                                                        value="{{ $item->jabatan }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Tahun <span style="color: red;">*</span></label>
                                                                    <input type="number" autocomplete="off"
                                                                        class="form-control" name="tahun[]"
                                                                        value="{{ $item->tahun }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Keterangan </label>
                                                                    <input type="number" autocomplete="off"
                                                                        class="form-control" name="keterangan[]"
                                                                        value="{{ $item->keterangan }}">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row dynamic-work" id="dynamic-work-1">
                                        <div class="col md-12">
                                            <div class="row align-items-center">
                                                <div class="col-md-2">
                                                    <div class="row mt-3">
                                                        <div class="col-md-12">
                                                            <div class="clearfix">
                                                                <button type="button" onclick="return addNewWork(this)"
                                                                    id="add-button"
                                                                    class="btn btn-sm btn-primary float-start text-uppercase "><i
                                                                        class="fa fa-plus"></i>
                                                                </button>
                                                                <button type="button"
                                                                    onclick="return removeLastWork(this)"
                                                                    id="remove-button"
                                                                    class="btn btn-sm btn-danger float-start text-uppercase ms-1"><i
                                                                        class="fa fa-minus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Perusahaan <span
                                                                        style="color: red;">*</span></label>
                                                                <input type="text" autocomplete="off"
                                                                    class="form-control" name="perusahaan[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Jabatan <span style="color: red;">*</span></label>
                                                                <input type="text" autocomplete="off"
                                                                    class="form-control" name="jabatan[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Tahun <span style="color: red;">*</span></label>
                                                                <input type="number" autocomplete="off"
                                                                    class="form-control" name="tahun[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Keterangan </label>
                                                                <input type="number" autocomplete="off"
                                                                    class="form-control" name="keterangan[]">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <input type="hidden" name="oldImage" value="{{ $exp->image }}">
                                    <label for="image" class="form-label">Foto <span
                                            style="color: red;">*</span></label>
                                    @if ($exp->image)
                                        <img class="img-preview img-fluid mb-3 col-sm-3 d-block"
                                            src="{{ asset("storage/{$exp->image}") }}">
                                    @else
                                        <img class="img-preview img-fluid mb-3 col-sm-3">
                                    @endif
                                    <input class="form-control @error('image') is-invalid @enderror" type="file"
                                        id="image" name="image" onchange="previewImage()">
                                    @error('image')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <button class="btn btn-primary" id="submit-btn" type="submit">Save</button>
                                <a href="{{ route('experience.index') }}" class="btn btn-danger">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let classNameEducation = ".dynamic-education",
            countEducation = 0,
            fieldEducation = "",
            maxFieldsEducation = 10,
            classNameWork = ".dynamic-work",
            countWork = 0,
            fieldWork = "",
            maxFieldsWork = 15;

        $(function() {
            $("#submit-btn").on("click", function(event) {
                if (!validateEducationInputs()) {
                    event.preventDefault();
                    console.log("Form education is not valid");
                    return;
                } else if (!validateWorkInputs()) {
                    event.preventDefault();
                    console.log("Form work is not valid");
                    return;
                } else {
                    // event.preventDefault(); 
                    console.log("Form is valid");
                }
            });
        });

        function previewImage() {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(ofREvent) {
                imgPreview.src = ofREvent.target.result;
            }
        }

        function totalFieldsEducation() {
            return $(classNameEducation).length;
        }

        function addNewEducation(obj) {
            if (totalFieldsEducation() < maxFieldsEducation) {
                countEducation = totalFieldsEducation() + 1;
                fieldEducation = $(".dynamic-education:last").clone();
                fieldEducation.find("input").val("");
                $(classNameEducation + ":last").after($(fieldEducation));
            } else {
                alert(`Maximum ${maxFieldsEducation} line`);
            }
        }

        function removeLastEducation(obj) {
            if (totalFieldsEducation() > 1) {
                $(obj).closest(classNameEducation).remove();
            } else {
                alert("Minimum 1 line");
            }
        }

        function validateEducationInputs() {
            let isValid = true;

            $(".dynamic-education").each(function(index) {
                const inputs = $(this).find(
                    "input[name^='nama_sekolah'], input[name^='jurusan'], input[name^='tahun_masuk'], input[name^='tahun_lulus']"
                );

                inputs.each(function() {
                    if ($(this).val() === "") {
                        const label = $(this).closest(".form-group").find("label").text();
                        alert(`Please fill in the required field: ${label}`);
                        isValid = false;
                        return false; // Break out of the loop
                    }

                });
            });

            return isValid;
        }

        function totalFieldsWork() {
            return $(classNameWork).length;
        }

        function addNewWork(obj) {
            if (totalFieldsWork() < maxFieldsWork) {
                countWork = totalFieldsWork() + 1;
                fieldWork = $(".dynamic-work:last").clone();
                fieldWork.find("input").val("");
                $(classNameWork + ":last").after($(fieldWork));
            } else {
                alert(`Maximum ${maxFieldsWork} line`);
            }
        }

        function removeLastWork(obj) {
            if (totalFieldsWork() > 1) {
                $(obj).closest(classNameWork).remove();
            } else {
                alert("Minimum 1 line");
            }
        }

        function validateWorkInputs() {
            let isValid = true;

            $(".dynamic-work").each(function(index) {
                const inputs = $(this).find(
                    "input[name^='perusahaan'], input[name^='jabatan'], input[name^='tahun']"
                );

                inputs.each(function() {
                    if ($(this).val() === "") {
                        const label = $(this).closest(".form-group").find("label").text();
                        alert(`Please fill in the required field: ${label}`);
                        isValid = false;
                        return false; // Break out of the loop
                    }

                });
            });

            return isValid;
        }
    </script>
@endsection
