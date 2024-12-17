@extends('admin.layout.master')

@section('content')
    <div class="dashboard__body">
        <div class="dashboard__inner">
            <div class="dashboard__inner__item dashboard__card bg__white padding-20 radius-10">
                <div class="row">
                    <div class="col-lg-6">
                        <h4 class="dashboard__inner__item__header__title">City List</h4>
                    </div>
                    <div class="col-lg-6 d-flex justify-content-end">
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add-city">Add
                            City</button>
                    </div>
                </div>
                <!-- Table Design One -->
                <div class="tableStyle_one mt-4">
                    <div class="table_wrapper">
                        <!-- Table -->
                        <table id="cityTable">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Coutnry Name</th>
                                    <th>State Name</th>
                                    <th>City Name</th>
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
    <div class="modal fade" id="add-city" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add CIty</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="dashboard__card__inner mt-4">
                        <div class="form__input">
                            <form action="#" id="cityform">
                                {{-- @csrf --}}
                                {{-- <div class="form__input__single">
                                    <label for="country" class="form__input__single__label">Country Name</label>
                                    <select class="form__control radius-5" id="country"
                                        aria-label="Default select example">
                                        <option value="">Select A Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                        @endforeach

                                    </select>
                                </div> --}}
                                <div class="form__input__single">
                                    <label for="state" class="form__input__single__label">State Name</label>
                                    <select class="form__control radius-5" name='state_id' id="state"
                                        aria-label="Default select example">
                                        <option value="">Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form__input__single">
                                    <label for="city" class="form__input__single__label">City Name</label>
                                    <input type="text" name="city" id="city" class="form__control radius-5"
                                        placeholder="City Name...">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" id='submit-btn' class="btn btn-primary">Add City</button>
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
    <!-- Update Modal -->
    <div class="modal fade" id="edit-city" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit City</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="dashboard__card__inner mt-4">
                        <div class="form__input">
                            <form action="#" id="editcityform">
                                {{-- <div class="form__input__single">
                                    <label for="country" class="form__input__single__label">Country Name</label>
                                    <select class="form__control radius-5" id="country"
                                        aria-label="Default select example">
                                        <option value="">Select A Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                        @endforeach

                                    </select>
                                </div> --}}
                                <div class="form__input__single">
                                    <label for="state" class="form__input__single__label">State Name</label>
                                    <select class="form__control radius-5" name='state_id' id="editstate"
                                        aria-label="Default select example">
                                        {{-- <option value="">Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <input type="hidden" name="id" id="id">
                                <div class="form__input__single">
                                    <label for="city_name" class="form__input__single__label">City Name</label>
                                    <input type="text" name="city" id="city_name" class="form__control radius-5"
                                        placeholder="City Name...">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" id='submit-btn' class="btn btn-primary">Edit City</button>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // $('#country').on('change', function() {
            //     var countryId = $('#country').val();

            //     if (countryId) {
            //         $.ajax({
            //             url: `states/${countryId}`,
            //             type: 'GET',
            //             success: function(response) {
            //                 console.log(response.data);
            //                 $('#state').empty();
            //                 $('#state').append('<option value="">-- Select State --</option>');
            //                 response.data.forEach(function(state) {
            //                     $('#state').append(
            //                         `<option value="${state.id}">${state.name}</option>`
            //                     );
            //                 });
            //             },
            //             error: function(xhr) {
            //                 console.log(xhr);
            //                 alert('Error fetching states. Please try again.');
            //             }
            //         });
            //     } else {
            //         $('#state').empty();
            //         $('#state').append('<option value="">-- Select State --</option>');
            //     }
            // })

            // $('#editcountry').on('change', function() {
            //     var countryId = $('#editcountry').val();
            //     if (countryId) {
            //         $.ajax({
            //             url: `states/${countryId}`,
            //             type: 'GET',
            //             success: function(response) {
            //                 console.log(response.data);
            //                 $('#editstate').empty();
            //                 $('#editstate').append(
            //                     '<option value="">-- Select State --</option>');
            //                 response.data.forEach(function(state) {
            //                     $('#editstate').append(
            //                         `<option value="${state.id}">${state.name}</option>`
            //                     );
            //                 });
            //             },
            //             error: function(xhr) {
            //                 console.log(xhr);
            //                 alert('Error fetching states. Please try again.');
            //             }
            //         });
            //     } else {
            //         $('#state').empty();
            //         $('#state').append('<option value="">-- Select State --</option>');
            //     }
            // })



            // city add form ajax
            $('#cityform').submit(function(event) {
                event.preventDefault();
                let formData = $(this).serialize();
                // console.log(formData)
                $.ajax({
                    url: '{{ route('city.store') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('.output').text(response.success);
                        fetchcity();
                        $('#cityform')[0].reset();
                         $('#add-city').modal('hide');

                    },
                    error: function(xhr) {
                        let message = xhr.responseJSON.message;
                        $('.output2').text(message);
                    }

                });
            });

            // city data show in table 
            function fetchcity() {
                $.ajax({
                    url: '{{ route('city.all') }}',
                    type: 'GET',
                    success: function(response) {
                        const tbody = $('#cityTable tbody');
                        tbody.empty();
                        if (response.data.length > 0) {
                            response.data.forEach((city, index) => {
                                tbody.append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${city.state.country.country_name}</td>
                            <td>${city.state.name}</td>
                            <td>${city.city_name}</td>
                            <td>
                                <!-- Dropdown -->
                                <div class="dropdown custom__dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton8"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="las la-ellipsis-h"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="dropdownMenuButton8">
                                        <li><a class="dropdown-item edit-btn" data-id='${city.id}' data-bs-toggle="modal" data-bs-target="#edit-city" href="#">Edit</a></li>
                                        <li><a class="dropdown-item delete-btn" href="#" data-id="${city.id}">Delete</a></li>
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

            function editfetchAllState(id) {
                $.ajax({
                    url: '{{ route('state.all') }}',
                    type: 'GET',
                    success: function(response) {
                        console.log(response.data)
                        const select = $('#editstate');
                        select.empty();
                        select.append('<option value="" disabled selected>Select a country</option>');
                        response.data.forEach((state) => {
                            const isSelected = state.id === id ? 'selected' : '';
                            select.append(
                                `<option value="${state.id}" ${isSelected}>${state.name}</option>`
                            );
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    },
                });
            }

            // // edit data 
            $('#cityTable').on('click', '.edit-btn', function() {
                let dataId = $(this).attr('data-id');

                $.ajax({
                    type: 'GET',
                    url: `city/edit/${dataId}`,
                    success: function(response) {
                        console.log(response.data);
                        $('#city_name').val(response.data.city_name);
                        $('#id').val(response.data.id);
                        editfetchAllState(response.data.state_id)

                        $('#editStateModal').modal('show');
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    },
                })
            })

            $('#editcityform').submit(function() {
                event.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: '{{ route('city.update') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log(response.success);
                        $('.output').text(response.success);
                        fetchcity();
                        $('#edit-city').modal('hide');
                    },
                    error: function(xhr) {
                        let message = xhr.responseJSON.message;
                        $('.output2').text(message);
                    }

                })

            })

            // // delete with ajax 
            $('#cityTable').on('click', '.delete-btn', function() {
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
                            url: `city/delete/${data}`,
                            success: function(response) {
                                swalWithBootstrapButtons.fire({
                                    title: "Deleted!",
                                    text: `${response.delete}`,
                                    icon: "success",

                                });
                                fetchcity()
                            }
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

            fetchcity();
            editfetchAllState()
        })
    </script>
@endpush
