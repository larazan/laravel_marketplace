@extends('backend.layout')

@section('content')

<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Edit Shop Information</h2>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row gx-5">
                
                <div class="col-lg-9">
                    <section class="content-body p-xl-4">
                        <form>
                            <div class="row border-bottom mb-4 pb-4">
                                <div class="col-md-5">
                                    <h5>Shop name</h5>
                                </div>
                                <!-- col.// -->
                                <div class="col-md-7">
                                    <div class="mb-3">
                                        <!-- <label class="form-label">Home page title</label> -->
                                        <input class="form-control" type="text" name="" placeholder="Type here" />
                                    </div>
                                    
                                </div>
                                <!-- col.// -->
                            </div>
                            <!-- row.// -->
                            
                            <!-- row.// -->
                            <div class="row border-bottom mb-4 pb-4">
                                <div class="col-md-5">
                                    <h5>Description</h5>
                                </div>
                                <div class="col-md-7">
                                    
                                    <div class="mb-3">
                                    <textarea type="text" class="form-control"></textarea>
                                    </div>
                                </div>
                                <!-- col.// -->
                            </div>
                            <!-- row.// -->
                            <div class="row border-bottom mb-4 pb-4">
                                <div class="col-md-5">
                                    <h5>Currency</h5>
                                    <p class="text-muted" style="max-width: 90%">Lorem ipsum dolor sit amet, consectetur adipisicing something about this</p>
                                </div>
                                <!-- col.// -->
                                <div class="col-md-7">
                                    <div class="mb-3" style="max-width: 200px">
                                        <label class="form-label">Main currency </label>
                                        <select class="form-select">
                                            <option>US Dollar</option>
                                            <option>EU Euro</option>
                                            <option>RU Ruble</option>
                                            <option>UZ Som</option>
                                        </select>
                                    </div>
                                    
                                </div>
                                <!-- col.// -->
                            </div>
                            <!-- row.// -->
                            <button class="btn btn-primary" type="submit">Save all changes</button> &nbsp;
                            <button class="btn btn-light rounded font-md" type="reset">Reset</button>
                        </form>
                    </section>
                    <!-- content-body .// -->
                </div>
                <!-- col.// -->
            </div>
            <!-- row.// -->
        </div>
        <!-- card-body .//end -->
    </div>
    <!-- card .//end -->
</section>

@endsection