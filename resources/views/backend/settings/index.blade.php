@extends('backend.layout')

@section('content')

<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Site settings</h2>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row gx-5">
                <aside class="col-lg-3 border-end">
                    <nav class="nav nav-pills flex-lg-column mb-4">
                        <a class="nav-link active" aria-current="page" href="#">General</a>
                        <a class="nav-link" href="#">Moderators</a>
                        <a class="nav-link" href="#">Admin account</a>
                        <a class="nav-link" href="#">SEO settings</a>
                        <a class="nav-link" href="#">Mail settings</a>
                        <a class="nav-link" href="#">Newsletter</a>
                    </nav>
                </aside>
                <div class="col-lg-9">
                    <section class="content-body p-xl-4">
                        <form>
                            <div class="row border-bottom mb-4 pb-4">
                                <div class="col-md-5">
                                    <h5>Website name</h5>
                                    <p class="text-muted" style="max-width: 90%">Supported languages of all pages including each product lorem ipsum dolor sit amet, consectetur adipisicing</p>
                                </div>
                                <!-- col.// -->
                                <div class="col-md-7">
                                    <div class="mb-3">
                                        <label class="form-label">Home page title</label>
                                        <input class="form-control" type="text" name="" placeholder="Type here" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea type="text" class="form-control"></textarea>
                                    </div>
                                </div>
                                <!-- col.// -->
                            </div>
                            <!-- row.// -->
                            <div class="row border-bottom mb-4 pb-4">
                                <div class="col-md-5">
                                    <h5>Access</h5>
                                    <p class="text-muted" style="max-width: 90%">Give access of all pages including each product lorem ipsum dolor sit amet, consectetur adipisicing</p>
                                </div>
                                <!-- col.// -->
                                <div class="col-md-7">
                                    <label class="mb-2 form-check">
                                        <input class="form-check-input" checked="" name="mycheck_a1" type="radio" />
                                        <span class="form-check-label"> All registration is enabled </span>
                                    </label>
                                    <label class="mb-2 form-check">
                                        <input class="form-check-input" name="mycheck_a1" type="radio" />
                                        <span class="form-check-label"> Only buyers is enabled </span>
                                    </label>
                                    <label class="mb-2 form-check">
                                        <input class="form-check-input" name="mycheck_a1" type="radio" />
                                        <span class="form-check-label"> Only buyers is enabled </span>
                                    </label>
                                    <label class="mb-2 form-check">
                                        <input class="form-check-input" name="mycheck_a1" type="radio" />
                                        <span class="form-check-label"> Stop new shop registration </span>
                                    </label>
                                </div>
                                <!-- col.// -->
                            </div>
                            <!-- row.// -->
                            <div class="row border-bottom mb-4 pb-4">
                                <div class="col-md-5">
                                    <h5>Notification</h5>
                                    <p class="text-muted" style="max-width: 90%">Lorem ipsum dolor sit amet, consectetur adipisicing something about this</p>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="" id="mycheck_notify" checked />
                                        <label class="form-check-label" for="mycheck_notify"> Send notification on each user registration </label>
                                    </div>
                                    <div class="mb-3">
                                        <input class="form-control" placeholder="Text" />
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
                                    <div class="mb-3" style="max-width: 200px">
                                        <label class="form-label">Supported curencies</label>
                                        <select class="form-select">
                                            <option>US dollar</option>
                                            <option>RUBG russia</option>
                                            <option>INR india</option>
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