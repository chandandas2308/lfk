<div class="p-3">
    <!-- invoice Tab -->
        <div class="page-header flex-wrap">
            <h4 class="mb-0">
                Wallets History
            </h4>
            <!-- <div class="d-flex">
                <label for="VendorSectionFilter" id="searchLabel" class="text-white bg-primary fw-bold">Search </label>
                <input type="search" onkeypress="VendorFilterSection()" name="" id="VendorSectionFilter" placeholder="Search...">
                <a href="#" id="resetVendorFilterSection" class="bg-primary text-white" style="margin-left: 3px !important; margin-right:3px !important; border:2px solid #ccc !important;">reset</a>
            </div> -->
            <div class="d-flex">
                <!-- <a href="#" class="btn btn-sm ml-3 btn-primary" data-toggle="modal" data-target="#addVendors">  </a> -->
            </div>
        </div>

        <!-- table start -->
        <div class="table-responsive">
            <table class="table table-responsive text-center table-bordered text-center" style="width: 100%; border-collapse: collapse;">
                <caption class="vendors-main-table"></caption>
                <thead>
                    <tr>
                        <th class="text-center">S/N</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Email ID</th>
                        <th class="text-center">Gained Points</th>
                        <th class="text-center">Spend Points</th>
                        <th class="text-center">Remaining Points</th>
                        <th class="text-center">Last Transaction Date</th>
                        <th class="text-center" colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody class="tbody vendors-details">
                </tbody>
            </table>
        </div>
        <ul class="vendors-pagination-refs pagination-referece-css pagination justify-content-center"></ul>
        <!-- table end here -->        

</div>
