@extends('admin.layout.master')

@section('content')
    <div class="dashboard__body">
        <div class="dashboard__inner">
            <div class="dashboard__inner__item dashboard__card bg__white padding-20 radius-10">
                <div class="row">
                    <div class="col-lg-6">
                        <h4 class="dashboard__inner__item__header__title">State List</h4>
                    </div>
                    <div class="col-lg-6 d-flex justify-content-end">
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add-state">Add
                            State</button>
                    </div>
                </div>
                <!-- Table Design One -->
                <div class="tableStyle_one mt-4">
                    <div class="table_wrapper">
                        <!-- Table -->
                        <table id="stateTable">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Coutnry Name</th>
                                    <th>State Name</th>
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
    <div class="modal fade" id="add-state" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add State</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="dashboard__card__inner mt-4">
                        <div class="form__input">
                            <form action="#" id="stateform">
                                
                                <div class="form__input__single">
                                    <select class="form__control radius-5" name='country_id' id="allCountry"
                                        aria-label="Default select example">
                                    </select>
                                </div>
                                <div class="form__input__single">
                                    <label for="country" class="form__input__single__label">State Name</label>
                                    <input type="text" name="state_name" id="country" class="form__control radius-5"
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
    {{-- update modal  --}}
    <div class="modal fade" id="edit-state" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit State</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="dashboard__card__inner mt-4">
                        <div class="form__input">
                            <form action="#" id="editstateform">
                                
                                <div class="form__input__single">
                                    <select class="form__control radius-5" name='country_id' id="editcountry"
                                        aria-label="Default select example">
                                    </select>
                                </div>

                                <input type="hidden" id="id" name="id">
                                <div class="form__input__single">
                                    <label for="state_name" class="form__input__single__label">State Name</label>
                                    <input type="text" name="state_name" id="state_name" class="form__control radius-5"
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

            // fetch all country data 
            function fetchAllCountries() {
                $.ajax({
                    url: '{{ route('country.all') }}',
                    type: 'GET',
                    success: function(response) {
                        console.log(response.data)
                        const select = $('#allCountry');
                        select.empty();
                        select.append('<option value="" disabled selected>Select a country</option>');
                        if (response.data.length > 0) {
                            response.data.forEach((country) => {
                                select.append(`
                            <option value='${country.id}'>${country.country_name}</option>`);
                            });
                        } else {
                            option.append("<option>Data Not Found</option>");
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    },
                });
            }

            // add data 
            $('#stateform').submit(function(event) {
                event.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: '{{ route('state.store') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('.output').text(response.res);
                        fetchstate();
                        $('#add-state').modal('hide');
                        $('#countryform')[0].reset();
                    },
                    error: function(xhr) {
                        let message = xhr.responseJSON.message;
                        $('.output2').text(message);
                    }

                });
            });

            // state data show in table 
            function fetchstate() {
                $.ajax({
                    url: '{{ route('state.all') }}',
                    type: 'GET',
                    success: function(response) {
                        const tbody = $('#stateTable tbody');
                        tbody.empty();
                        if (response.data.length > 0) {
                            response.data.forEach((state, index) => {
                                tbody.append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${state.country.country_name}</td>
                                <td>${state.name}</td>
                                <td>
                                    <!-- Dropdown -->
                                    <div class="dropdown custom__dropdown">
                                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton8"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="las la-ellipsis-h"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end"
                                            aria-labelledby="dropdownMenuButton8">
                                            <li><a class="dropdown-item edit-btn" data-id='${state.id}' data-bs-toggle="modal" data-bs-target="#edit-state" href="#">Edit</a></li>
                                            <li><a class="dropdown-item delete-btn" href="#" data-id="${state.id}">Delete</a></li>
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

            // fetch country for edit 
            function editfetchAllCountries(id) {
                $.ajax({
                    url: '{{ route('country.all') }}',
                    type: 'GET',
                    success: function(response) {
                        console.log(response.data)
                        const select = $('#editcountry');
                        select.empty();
                        select.append('<option value="" disabled selected>Select a country</option>');
                        response.data.forEach((country) => {
                            const isSelected = country.id === id ? 'selected' : '';
                            select.append(
                                `<option value="${country.id}" ${isSelected}>${country.country_name}</option>`
                                );
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    },
                });
            }

            // edit data 
            $('#stateTable').on('click', '.edit-btn', function() {
                let dataId = $(this).attr('data-id');
                $.ajax({
                    type: 'GET',
                    url: `state/edit/${dataId}`,
                    success: function(response) {
                        console.log(response.data);
                        $('#state_name').val(response.data.name);
                        $('#id').val(response.data.id);
                        editfetchAllCountries(response.data.country_id);

                        $('#editStateModal').modal('show');
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    },
                })
            })

            $('#editstateform').submit(function() {
                event.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: 'state/update',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log(response.success);
                        $('.output').text(response.success);
                        fetchstate();
                        $('#edit-state').modal('hide');
                    },
                    error: function(xhr) {
                        let message = xhr.responseJSON.message;
                        $('.output2').text(message);
                    }

                })

            })

            // delete with ajax 
            $('#stateTable').on('click', '.delete-btn', function() {
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
                            url: `state/delete/${data}`,
                            success: function(response) {
                                fetchstate();
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

            fetchstate();
            fetchAllCountries();
            editfetchAllCountries();
        })
    </script>
@endpush
