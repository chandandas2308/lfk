@extends('pos.layout.master')
@section('title','Dashboard | POS')
@section('body')
<main id="main" class="main">
    
    <div class="col-12">
        <div class="row justify-content-center">
           <div class="col-8 justify-content-center">
                 <div class="card mt-2">
                    <div class="card-header"> <h5>Details</h5> </div>
                        <div class="card-body">
                        
                            <div class="col-md-12">
                                <label for="inputName5" class="form-label">Your Name</label>
                                <input type="text" class="form-control" id="inputName5">
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail5" class="form-label">Email</label>
                                <input type="email" class="form-control" id="inputEmail5">
                            </div>
                            <div class="col-md-6">
                                <label for="inputPassword5" class="form-label">Password</label>
                                <input type="password" class="form-control" id="inputPassword5">
                            </div>
                            <div class="col-12">
                                <label for="inputAddress5" class="form-label">Address</label>
                                <input type="text" class="form-control" id="inputAddres5s" placeholder="1234 Main St">
                            </div>
                            <div class="col-12">
                                <label for="inputAddress2" class="form-label">Address 2</label>
                                <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                            </div>
                            <div class="col-md-6">
                                <label for="inputCity" class="form-label">City</label>
                                <input type="text" class="form-control" id="inputCity">
                            </div>
                            <div class="col-md-4">
                                <label for="inputState" class="form-label">State</label>
                                <select id="inputState" class="form-select">
                                    <option selected>Choose...</option>
                                    <option>...</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="inputZip" class="form-label">Zip</label>
                                <input type="text" class="form-control" id="inputZip">
                            </div>
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>
</main>
@endsection