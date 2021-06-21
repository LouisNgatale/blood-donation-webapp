@extends('layouts.blood_bank')

@section('blood_bank')
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        New blood stock
                    </div>
                    <div class="card-body">
                        <form action="{{ route('blood_bank.store') }}" method="post">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="blood_group">Blood Group</label>
                                <select name="blood_group" class="form-select @error('blood_group') is-invalid @enderror" aria-label="Default select example" required>
                                    <option selected disabled>Choose...</option>
                                    <option value="A">Group A</option>
                                    <option value="B">Group B</option>
                                    <option value="AB">Group AB</option>
                                    <option value="O">Group O</option>
                                </select>
                                @error('blood_group')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>
                            <div class="form-group mb-3">
                                <label for="blood_rha">Blood Rhesus factor</label>
                                <input type="text" class="form-control @error('blood_rha') is-invalid @enderror" id="blood_rha" name="blood_rha" placeholder="Blood RHA">
                                @error('blood_rha')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <div class="form-group col">
                                    <label for="donor_id">Blood Donor Id</label>
                                    <input type="text" class="form-control @error('donor_id') is-invalid @enderror" id="donor_id" name="donor_id" placeholder="Blood donor Id">
                                    @error('donor_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col">
                                    <label for="expire_date">Expire date</label>
                                    <input type="date" class="form-control @error('expire_date') is-invalid @enderror" id="expire_date" name="expire_date">
                                    @error('expire_date')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="quantity">Quantity</label>
                                <input type="text" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" placeholder="Number of blood bags">
                                @error('quantity')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                        @if ( session('status'))
                            <div class="alert alert-success my-2">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
