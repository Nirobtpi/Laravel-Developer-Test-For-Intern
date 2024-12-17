@extends('admin.layout.master')

@section('content')
    <div class="dashboard__body">
        <div class="dashboard__inner">
            <div class="dashboard__inner__item dashboard__card bg__white padding-20 radius-10">
                <div class="row">
                    <div class="col-lg-6">
                        <h4 class="dashboard__inner__item__header__title">Latest Order</h4>
                    </div>
                    <div class="col-lg-6 d-flex justify-content-end">
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add-country">Add
                            Country</button>
                    </div>
                </div>
                <!-- Table Design One -->
                <div class="tableStyle_one mt-4">
                    <div class="table_wrapper">
                        <!-- Table -->
                        <table id="countryTable">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                    </div>
                </div>
                <!-- End-of Table one -->
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="add-country" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="dashboard__card__inner mt-4">
                        <div class="form__input">
                            <form action="#" id="countryform">
                                
                                <div class="form__input__single">
                                    <label for="country" class="form__input__single__label">Country Name</label>
                                    <input type="text" name="name" id="country" class="form__control radius-5"
                                        placeholder="Country Name...">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" id='submit-btn' class="btn btn-primary">Add Country</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="output text-primary"></div>
                    <div class="output2 text-danger"></div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="edit-country" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Country</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="dashboard__card__inner mt-4">
                        <div class="form__input">
                            <form action="#" id="editcountryform">
                                
                                <div class="form__input__single">
                                    <label for="edit_country" class="form__input__single__label">Edit Country Name</label>
                                    <input type="text" name="name" id="edit_country" class="form__control radius-5"
                                        placeholder="Country Name...">
                                </div>
                                <input type="hidden" id="id" name="id">
                                <div class="modal-footer">
                                    <button type="submit" id='submit-btn' class="btn btn-primary">Edit Country</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="output text-primary"></div>
                    <div class="output2 text-danger"></div>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            // csrf token setup 
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // add data 
            $('#countryform').submit(function(event) {
                event.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: '{{ route('country.store') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('.output').text(response.res);
                        fetchCountries();
                        $('#countryform')[0].reset();
                         $('#add-country').modal('hide');

                    },
                    error: function(xhr) {
                        let message = xhr.responseJSON.message;
                        $('.output2').text(message);
                    }

                });
            });

            // fetch data 
            function fetchCountries() {
                $.ajax({
                    url: '{{ route('country.all') }}',
                    type: 'GET',
                    success: function(response) {
                        const tbody = $('#countryTable tbody');
                        tbody.empty();
                        if (response.data.length > 0) {
                            response.data.forEach((country, index) => {
                                tbody.append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${country.country_name}</td>
                                <td>
                                    <!-- Dropdown -->
                                    <div class="dropdown custom__dropdown">
                                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton8"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="las la-ellipsis-h"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end"
                                            aria-labelledby="dropdownMenuButton8">
                                            <li><a class="dropdown-item edit-btn" data-id='${country.id}' data-bs-toggle="modal" data-bs-target="#edit-country" href="#">Edit</a></li>
                                            <li><a class="dropdown-item delete-btn" href="#" data-id="${country.id}">Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        `);
                            });
                        } else {
                            tbody.append("<tr><td colspan='3'>Data Not Found</td></tr>");
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    },
                });
            }

            // delete with ajax 
            $('#countryTable').on('click', '.delete-btn', function() {
                let data = ($(this).attr('data-id'));

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: false
                });
                swalWithBootstrapButtons.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: `country/delete/${data}`,
                            success: function(response) {
                                fetchCountries();
                            }
                        });
                        swalWithBootstrapButtons.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        });
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Your imaginary file is safe :)",
                            icon: "error"
                        });
                    }
                });

            })

            // edit data 
            $('#countryTable').on('click', '.edit-btn', function() {
                let dataId = $(this).attr('data-id');
                $.ajax({
                    type: 'GET',
                    url: `edit/data/${dataId}`,
                    success: function(response) {
                        console.log(response.data);
                        $('#edit_country').val(response.data.country_name);
                        $('#id').val(response.data.id);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    },
                })
            })

            $('#editcountryform').submit(function() {
                event.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: 'update',
                    type: 'POST',
                    data: formData,
                    success:function(response){
                        console.log(response.success);
                        $('.output').text(response.success);
                        fetchCountries();
                         $('#edit-country').modal('hide');
                    },
                    error:function(xhr){
                        let message = xhr.responseJSON.message;
                        $('.output2').text(message);
                    }

                })

            })


            fetchCountries()
        })
    </script>
@endpush
